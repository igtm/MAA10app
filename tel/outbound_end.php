<?php
require dirname(__FILE__).'/../lib/twilio-php/Services/Twilio.php';
require dirname(__FILE__).'/../app/models/model.php';
function h($value){return htmlspecialchars($value,ENT_QUOTES,'UTF-8');}
$project_id = $_GET['project_id'];
$CallStatus = $_POST['CallStatus'];
$Project = new Project($project_id);
switch($CallStatus){
	case 'completed':
		// voiceの削除(TwilioDBから)
		$client = new Services_Twilio(ACCOUNT_SID, AUTH_TOKEN); 
		$Voice = new Voice();
		$table = $Voice->get_voices($project_id);
		foreach ($table as $result){
			$client->account->recordings->delete($result['voice']);
		}
		// voice行の完全削除(自DBから)
		$Voice->delete_voices($project_id);

		// status=5　終了。
		$Project->change_status(5);
		break;
		
	case 'failed':
		//通話を接続できませんでした。通常は、ダイヤルした電話番号が存在しません。
		// status=4　エラー
		$Project->change_status(4);
		break;
	case 'canceled':
		//queued または ringing 中に、通話がキャンセルされました。
		// status=2　もう一度実行待ち
		$Project->change_status(2);
		break;
	case 'no-answer':
		//相手が応答せず、通話が終了しました。
		// status=2　もう一度実行待ち
		$Project->change_status(2);
		break;
	case 'busy':
		//相手からビジー信号を受信しました。
		// status=2　もう一度実行待ち
		$Project->change_status(2);
		break;
	default:
		break;
}
?>