<?php
require dirname(__FILE__).'/../lib/twilio-php/Services/Twilio.php';
require dirname(__FILE__).'/../app/models/model.php';
$sceneArray = array(1 => INBOUND_BIRTHDAY,2=>INBOUND_CHEERUP,3=>INBOUND_FAREWELL);
function h($value){return htmlspecialchars($value,ENT_QUOTES,'UTF-8');}
$response = new Services_Twilio_Twiml();
$cnt = 1;

if(!empty($_POST['Digits'])){
	$pin = $_POST['Digits'];
	$callSid = $_POST['CallSid'];
	
	$Project = new Project();
	$table = $Project->get_projectDetailByPin($pin);
	
	if($table['status'] != 1 && !empty($table)){ // 既に実行済み
		$message_2 = '申し訳ございません。';
		$message_2 .= 'このプロジェクトは既に終了しています。';

		$response->say($message_2, array("language"=>"ja-jp"));	
		header("Content-Type : text/xml; charset=utf-8");
		print $response;
	}elseif(!empty($table)){ // 正解
		if($table['scene']==10){
			$msg = $table['original_content'];
		}else{
			$msg = $sceneArray[$table['scene']];
		}

		
		$message_2 = 'ピンコードが確認されました。';
		$message_2 .= 'それでは、お名前と、';
		$message_2 .= $msg;
		$message_2 .= 'を、'.h($table['recordtime']).'秒以内で';
		$message_2 .= '録音して下さい。';

		$response->say($message_2, array("language"=>"ja-jp"));	
		$response->record(array(
						  'action' => 'inbound_record.php',
						  'maxLength' => h($table['recordtime']),
						  'method' => "	POST"
						));
		header("Content-Type : text/xml; charset=utf-8");
		print $response;
		// CallSidとproject_idを入力
		$Voice = new Voice();
		$Voice->before_record($table['id'],$callSid);

	}else{ // 間違い
		$cnt++;
		$message_1 = 'ピンコードが間違っています。';
		$message_1 .= 'ピンコードを入力して下さい。';
		
		$response->say($message_1, array("language"=>"ja-jp"));
		$gather = $response->gather(array('numDigits' => 5));
		header("Content-Type : text/xml; charset=utf-8");
		print $response;
	}
}else{
	$message_1 = 'こちらは、ぼいすはぶ、です。';
	$message_1 .= 'ピンコードを入力して下さい。';
	
	$response->say($message_1, array("language"=>"ja-jp"));
	$gather = $response->gather(array('numDigits' => 5,'timeout'=>10));
	$response->redirect(ROOT_DIR.'tel/inbound.php',array('method'=>'GET'));
	header("Content-Type : text/xml; charset=utf-8");
	print $response;
}
?>