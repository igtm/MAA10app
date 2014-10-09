<?php
require '../lib/twilio-php/Services/Twilio.php';
require '../app/models/model.php';

$message_1 = 'こちらは、ファイトコールです。';
$message_1 .= 'PINコードを入力して下さい。とりあえず5番で。';

$message_2 = '録音して下さい';


$response = new Services_Twilio_Twiml();
$response->say($message_1, array("language"=>"ja-jp"));

$gather = $response->gather(array('numDigits' => 5));
	$gather->say("Hello Caller");
	
$response->say($message_2, array("language"=>"ja-jp"));

$response->record(array(
				  'action' => 'inbound_record.php',
				  'maxLength' => 7,
				  'method' => "POST"
				));
header("Content-Type : text/xml; charset=utf-8");
print $response;

?>