<?php 
function create_project($table,$member_id){
	
	$pName = $table['project_name'];
	$tName = $table['target_name'];
	$phone = $table['phone'];
	
	mysql_connect('mysql572.phy.lolipop.jp','LAA0350474','2x2jycy9') or die(mysql_error());
	mysql_select_db('LAA0350474-3tnmww');
	mysql_query('SET NAMES UTF8');
	
	$sql = sprintf("INSERT INTO MA10_targets (name,phone,created) VALUES ('%s','%s',NOW())"
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
					(name,member_id,target_id,pin,created) VALUES ('%s','%s','%s','%s','%s',NOW())",
					mysql_real_escape_string($pName),mysql_real_escape_string($member_id),
					mysql_real_escape_string($target_id),mysql_real_escape_string($pin));
	mysql_query($sql) or die(mysql_error());
	// project_id 取得　（autoIncreamentなので）
	$res = mysql_query("SELECT LAST_INSERT_ID()");
	$dat = mysql_fetch_row($res);
	$project_id = $dat[0];
	return array($pin,$project_id,$target_id);
}

function set_voice_order($result_serialize,$project_id){
	
	mysql_connect('mysql572.phy.lolipop.jp','LAA0350474','2x2jycy9') or die(mysql_error());
	mysql_select_db('LAA0350474-3tnmww');
	mysql_query('SET NAMES UTF8');

	$sql = sprintf("UPDATE MA10_projects SET voice_order='%s'  WHERE id=%d"
					,mysql_real_escape_string($result_serialize),mysql_real_escape_string($project_id));
	mysql_query($sql) or die(mysql_error());
}
function set_send_time($send_time,$project_id){
	
	mysql_connect('mysql572.phy.lolipop.jp','LAA0350474','2x2jycy9') or die(mysql_error());
	mysql_select_db('LAA0350474-3tnmww');
	mysql_query('SET NAMES UTF8');

	$sql = sprintf("UPDATE MA10_projects SET send_time='%s'  WHERE id=%d"
					,mysql_real_escape_string($send_time),mysql_real_escape_string($project_id));
	mysql_query($sql) or die(mysql_error());
}
?>