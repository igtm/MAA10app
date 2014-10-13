<?php
require 'http://i-and-i.main.jp/API/MAA10app/lib/twilio-php/Services/Twilio.php';
require 'http://i-and-i.main.jp/API/MAA10app/app/models/config.php';
mysql_connect('mysql572.phy.lolipop.jp','LAA0350474','2x2jycy9') or die(mysql_error());
mysql_select_db('LAA0350474-3tnmww');
mysql_query('SET NAMES UTF8');
function h($value){return htmlspecialchars($value,ENT_QUOTES,'UTF-8');}

$sql = "SELECT t.phone, p.id  FROM MA10_projects p, MA10_targets t WHERE p.status=2 AND p.send_time<=NOW() AND p.target_id=t.id";
$record = mysql_query($sql) or die(mysql_error());
$table = mysql_fetch_assoc($record);
if($table){
	
}
?>