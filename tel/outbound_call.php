<?php
require '../lib/twilio-php/Services/Twilio.php';
/*
$sql = sprintf(SELECT id, name FROM targets WHERE phone=%S,
				mysql_real_escape_string($_POST['from']));
				
$sql = sprintf(SELECT comp_voice FROM projecs WHERE target_id=%d,
				mysql_real_escape_string($target_id);


*/

$message_first = 'こちらは、ファイトコールです。';
$message_first .= "イグチトモカツ様より";
$message_first .= 'まるまる様宛に、応援のメッセージを預かっております。';

$message_last = 'うまく行ってたら、井口におしえてあげてくだしゃい。';

$response = new Services_Twilio_Twiml();
$response->say($message_first, array("language"=>"ja-jp"));
// $response->play('https://api.twilio.com/cowbell.mp3', array("loop" => 1));
$response->say($message_last, array("language"=>"ja-jp"));

header("Content-Type : text/xml; charset=utf-8");
print $response;

?>