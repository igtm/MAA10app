<?php
require 'http://i-and-i.main.jp/API/MAA10app/app/models/config.php';
function h($value){return htmlspecialchars($value,ENT_QUOTES,'UTF-8');}
$CallSid = h($_POST['CallSid']); 
mysql_connect('mysql572.phy.lolipop.jp','LAA0350474','2x2jycy9') or die(mysql_error());
mysql_select_db('LAA0350474-3tnmww');
mysql_query('SET NAMES UTF8');

	// status=5　終了。
		$sql = sprintf("UPDATE MA10_projects SET status=5 WHERE CallSid='%s'",mysql_real_escape_string($CallSid));
	mysql_query($sql) or die(mysql_error());

?>