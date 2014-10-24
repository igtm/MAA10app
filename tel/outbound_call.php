<?php
require dirname(__FILE__).'/../lib/twilio-php/Services/Twilio.php';
require dirname(__FILE__).'/../app/models/model.php';
function h($value){return htmlspecialchars($value,ENT_QUOTES,'UTF-8');}
$project_id = $_GET['project_id'];
	$Project = new Project($project_id);
	$table = $Project->get_who_called();// toName fromName comp_voice

	$message_first = 'こちらは、ファイトコールです。';
	$message_first .= h($table['fromName'])."様より";
	$message_first .= 'メッセージを預かっております。';
	$message_first .= 'それでは再生します。';
	
	$message_last = '以上ファイトコールでした!';
	$response = new Services_Twilio_Twiml();
	$response->say($message_first, array("language"=>"ja-jp"));
	$response->play(h($table['comp_voice']), array("loop" => 1));
	$response->pause("");
	$response->say($message_last, array("language"=>"ja-jp"));
	
	header("Content-Type : text/xml; charset=utf-8");
	print $response;

?>