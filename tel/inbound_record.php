<?php
require dirname(__FILE__).'/../lib/twilio-php/Services/Twilio.php';
require dirname(__FILE__).'/../app/models/model.php';
function h($value){return htmlspecialchars($value,ENT_QUOTES,'UTF-8');}
$sceneArray = array(1 => INBOUND_BIRTHDAY,2=>INBOUND_CHEERUP,3=>INBOUND_FAREWELL,10=>INBOUND_ORIGINAL);


	$RecordingSid = $_REQUEST['RecordingSid'];
	$RecordingUrl = $_REQUEST['RecordingUrl'];
	$callSid = $_REQUEST['CallSid'];
	$response = new Services_Twilio_Twiml();
	
	$mes1 = '保存されたメッセージの再生は、1を。';
	$mes1 .= 'もう一度、録音し直す場合は、2を。';
	$mes1 .= '録音をキャンセルしたい場合は、3を。';
	$mes1 .= 'もう一度番号の案内を聞きたい場合は、9を。';
	$mes1 .= '保存して、終了したい場合は、そのままお切り下さい。';

if(empty($RecordingUrl)){
	$Digits = $_REQUEST['Digits'];
	switch($Digits){
		case 1: // メッセージの再生
			$Voice = new Voice();
			$table = $Voice->get_voice($callSid);
			$RecordingUrl = VOICE_URL.h($table['voice']);
			$response->play($RecordingUrl);
		break;
		case 2:
			// シーン、録音秒数を取得
			$Voice = new Voice();
			list($scene,$recordtime) = $Voice->get_setting($callSid);
		
			// voiceの削除(TwilioDBから)
			$client = new Services_Twilio(ACCOUNT_SID, AUTH_TOKEN); 
			$table = $Voice->get_voice($callSid);
			
			$client->account->recordings->delete($table['voice']);
			// voiceの削除(自DBから)
			$Voice->delete_onlyVoiceColumn($callSid);
			
			// 録音
			$message_2 = 'もう一度、録音し直します。';
			$message_2 .= 'それでは、お名前と、';
			$message_2 .= $sceneArray[$scene];
			$message_2 .= h($recordtime).'秒以内で';
			$message_2 .= '録音して下さい。';
	
			$response->say($message_2, array("language"=>"ja-jp"));	
			$response->record(array(
							  'action' => 'inbound_record.php',
							  'maxLength' => $recordtime,
							  'method' => "	POST"
							));

		break;
		case 3:
			// voiceの削除(TwilioDBから)
			$client = new Services_Twilio(ACCOUNT_SID, AUTH_TOKEN); 
			$Voice = new Voice();
			$table = $Voice->get_voice($callSid);
			
			$client->account->recordings->delete($table['voice']);
			// voice行の完全削除(自DBから)
			$Voice->delete_voice($callSid);
			
			// 電話を切る
			$response->say('キャンセルされました。電話を切断します。', array("language"=>"ja-jp"));	
			$response->hangup();
		break;
		case 9://何もしない
		break;
		case 'hangup':
			// voiceの削除(TwilioDBから)
			$client = new Services_Twilio(ACCOUNT_SID, AUTH_TOKEN); 
			$Voice = new Voice();
			$table = $Voice->get_voice($callSid);
			
			$client->account->recordings->delete(h($table['voice']));
			// voice行の完全削除(自DBから)
			$Voice->delete_voice($callSid);

		break;
		default:
			$response->say('番号が間違っています。', array("language"=>"ja-jp"));
		break;
	}
}else{
	$response->say('録音されました。', array("language"=>"ja-jp"));
	$Voice = new Voice();
	$Voice->after_record($RecordingSid,$callSid);
}

	$gather = $response->gather(array('numDigits' => 1,'timeout'=>10));
	$response->redirect(ROOT_DIR.'tel/inbound_record.php?Digits=9',array('method'=>'GET'));
	$gather->say($mes1, array("language"=>"ja-jp"));



print $response;
?>