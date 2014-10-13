<?php
require 'http://i-and-i.main.jp/API/MAA10app/lib/twilio-php/Services/Twilio.php';
require 'http://i-and-i.main.jp/API/MAA10app/app/models/config.php';
mysql_connect('mysql572.phy.lolipop.jp','LAA0350474','2x2jycy9') or die(mysql_error());
mysql_select_db('LAA0350474-3tnmww');
mysql_query('SET NAMES UTF8');
function h($value){return htmlspecialchars($value,ENT_QUOTES,'UTF-8');}

echo 'Good!';
/*
$sql = "SELECT t.phone, p.id  FROM MA10_projects p, MA10_targets t WHERE p.status=2 AND p.send_time<=NOW() AND p.target_id=t.id";
$record = mysql_query($sql) or die(mysql_error());
$table = mysql_fetch_assoc($record);
if($table){
	$tel_to = $table['phone'];
	$project_id = $table['id'];
	$url = 'http://i-and-i.main.jp/API/MAA10app/tel/outbound_call.php?project_id='.h($project_id);
	// status=3　実行中
	$sql = sprintf("UPDATE MA10_projects SET status=3 WHERE id='%s'",mysql_real_escape_string($project_id));
	mysql_query($sql) or die(mysql_error());
	$client = new Services_Twilio(ACCOUNT_SID, AUTH_TOKEN);
	
	$message = $client->account->calls->create(
		TEL_FROM,
		$tel_to,
		$url,
		array('StatusCallback'=>'http://i-and-i.main.jp/API/MAA10app/tel/outbound_end.php')
	);
}
*/
/*
$tel_to = h($_GET['phone']);
$project_id = h($_GET['project_id']);
$url = 'http://i-and-i.main.jp/API/MAA10app/tel/outbound_call.php?project_id='.h($project_id);
mysql_connect('mysql572.phy.lolipop.jp','LAA0350474','2x2jycy9') or die(mysql_error());
mysql_select_db('LAA0350474-3tnmww');
mysql_query('SET NAMES UTF8');
	// status=3　実行中
	$sql = sprintf("UPDATE MA10_projects SET status=3 WHERE id='%s'",mysql_real_escape_string($project_id));
	mysql_query($sql) or die(mysql_error());
	$client = new Services_Twilio(ACCOUNT_SID, AUTH_TOKEN);
	
	$message = $client->account->calls->create(
		TEL_FROM,
		$tel_to,
		$url,
		array('StatusCallback'=>'http://i-and-i.main.jp/API/MAA10app/tel/outbound_end.php')
	);
	
*/
?>