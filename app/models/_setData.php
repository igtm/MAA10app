<?php 
function create_project($table,$member_id){
	
	$pName = $table['project_name'];
	$tName = $table['target_name'];
	$phone = $table['phone'];
	$send_time = $table['datetime'];
	
	mysql_connect('mysql572.phy.lolipop.jp','LAA0350474','2x2jycy9') or die(mysql_error());
	mysql_select_db('LAA0350474-3tnmww');
	mysql_query('SET NAMES UTF8');
	
	$sql = sprintf("INSERT INTO MA10_targets (name,phone) VALUES ('%s','%s')"
					,mysql_real_escape_string($tName),mysql_real_escape_string($phone));
	mysql_query($sql) or die(mysql_error());
	// target_id 取得　（autoIncreamentなので）
	$res = mysql_query("SELECT LAST_INSERT_ID()");
	$dat = mysql_fetch_row($res);
	$target_id = $dat[0];
	// pin作成
	$flag = true;
	$pin = 0;
	while($flag){
		$pin = rand(10000,99999);
		$sql = sprintf("SELECT COUNT(*) AS cnt FROM MA10_projects WHERE pin='%s'",
						mysql_real_escape_string($pin));
		$record = mysql_query($sql) or die(mysql_error());
		$table = mysql_fetch_assoc($record);
		if($table['cnt'] ==0){$flag = false;}
	}
	
	$sql = sprintf("INSERT INTO MA10_projects
					(name,member_id,target_id,pin,send_time) VALUES ('%s','%s','%s','%s','%s')",
					mysql_real_escape_string($pName),mysql_real_escape_string($member_id),
					mysql_real_escape_string($target_id),mysql_real_escape_string($pin),
					mysql_real_escape_string($send_time));
	mysql_query($sql) or die(mysql_error());
	// project_id 取得　（autoIncreamentなので）
	$res = mysql_query("SELECT LAST_INSERT_ID()");
	$dat = mysql_fetch_row($res);
	$project_id = $dat[0];
	return array($pin,$project_id,$target_id);
}
?>