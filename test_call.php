<?php
require 'twilio-php/Services/Twilio.php';
require 'define.php';

/*
$sql = sprintf(SELECT id, name FROM targets WHERE phone=%S,
				mysql_real_escape_string($_POST['from']));
				
$sql = sprintf(SELECT comp_voice FROM projecs WHERE target_id=%d,
				mysql_real_escape_string($target_id);


*/
$message_first = 'こちらは、ファイトコールです。';
$message_first += '井口智勝様より、応援のメッセージを預かっております。';
$message_first += '';

$message_last = '';

$response = new Services_Twilio_Twiml();
$response->say($message_first);
$response->play('https://api.twilio.com/cowbell.mp3', array("loop" => 5));
$response->say($message_last);
print $response;

?>