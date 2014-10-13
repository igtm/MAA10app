<?php
require 'http://i-and-i.main.jp/API/MAA10app/lib/twilio-php/Services/Twilio.php';
require 'http://i-and-i.main.jp/API/MAA10app/app/models/config.php';
function h($value){return htmlspecialchars($value,ENT_QUOTES,'UTF-8');}
$project_id = $_GET['project_id'];

mysql_connect('mysql572.phy.lolipop.jp','LAA0350474','2x2jycy9') or die(mysql_error());
mysql_select_db('LAA0350474-3tnmww');
mysql_query('SET NAMES UTF8');

$sql = sprintf("SELECT t.name AS toName, m.name AS fromName, p.comp_voice  FROM MA10_projects p,MA10_targets t, MA10_members m 
				WHERE t.id=p.target_id AND p.member_id=m.id AND p.id='%s'",mysql_real_escape_string($project_id));
	$record = mysql_query($sql) or die(mysql_error());
	$table = mysql_fetch_assoc($record);

	$message_first = 'こちらは、ファイトコールです。';
	$message_first .= h($table['fromName'])."様より";
	$message_first .= h($table['toName']).'様宛に、応援のメッセージを預かっております。';
	
	$message_last = '以上ファイトコールでした!';
	$response = new Services_Twilio_Twiml();
	$response->say($message_first, array("language"=>"ja-jp"));
	// $response->play('https://api.twilio.com/cowbell.mp3', array("loop" => 1));
	$response->say($message_last, array("language"=>"ja-jp"));
	
	header("Content-Type : text/xml; charset=utf-8");
	print $response;

?>