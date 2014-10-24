<?php
require dirname(__FILE__).'/../lib/twilio-php/Services/Twilio.php';
require dirname(__FILE__).'/../app/models/model.php';
function h($value){return htmlspecialchars($value,ENT_QUOTES,'UTF-8');}
function phone($phone){return "+81".ltrim($phone, '0');}
$Project = new Project();
$returns = $Project->checkProjectTobeExecuted();// t.phone p.id
if($returns){
	foreach ($returns as $return){	
		cron($Project,$return);
	}
}

function cron($Project,$return){
	$tel_to = phone($return['phone']);
	$project_id = $return['id'];
	$url = ROOT_DIR.'tel/outbound_call.php?project_id='.h($project_id);
	// status=3　実行中
	$Project->set_id($project_id);
	$Project->change_status(3);
	$client = new Services_Twilio(ACCOUNT_SID, AUTH_TOKEN);
	try {
		$message = $client->account->calls->create(
			TEL_FROM,
			$tel_to,
			$url,
			array('StatusCallback'=>ROOT_DIR.'tel/outbound_end.php')
		);
	} catch (Services_Twilio_RestException $e) {
		echo $e->getMessage();
	}
}

		mb_language('japanese');
		mb_internal_encoding("UTF-8");
		$email = '';
		$subject = 'VoiceHub';
		
		$message = '仮登録されました。１時間以内に下記URLにアクセスして登録を完了させてください。'.PHP_EOL;
		
		$headers = 'From: info@i-and-i.main.jp';
		$success = mb_send_mail($email, $subject, $message, $headers);
		
		if($success){ header('Location: pre_thanks.php'); exit();}
		else{echo '確認メールを送信出来ませんでした。';}


?>