<?php
require dirname(__FILE__).'/../lib/twilio-php/Services/Twilio.php';
require dirname(__FILE__).'/../app/models/model.php';

$RecordingSid = $_REQUEST['RecordingSid'];
$RecordingUrl = $_REQUEST['RecordingUrl'];
$callSid = $_REQUEST['CallSid'];

$response = new Services_Twilio_Twiml();
$response->say("録音されました。", array("language"=>"ja-jp"));

mysql_connect('mysql572.phy.lolipop.jp','LAA0350474','2x2jycy9') or die(mysql_error());
mysql_select_db('LAA0350474-3tnmww');
mysql_query('SET NAMES UTF8');
$sql = sprintf("UPDATE MA10_voices SET voice='%s' WHERE CallSid='%s'",mysql_real_escape_string($RecordingSid),mysql_real_escape_string($callSid));
mysql_query($sql) or die(mysql_error());

$response->play($RecordingUrl);
print $response;
?>