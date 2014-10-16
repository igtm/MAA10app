<?php 
function create_project($pName,$tName,$phone,$member_id){
	
	$pdo = get_pdo();
	$stmt = $pdo->prepare("INSERT INTO MA10_targets (name,phone,created) VALUES (:tName,:phone,NOW())");
	$stmt -> bindValue(':tName', $tName, PDO::PARAM_STR);
	$stmt -> bindValue(':phone', $phone, PDO::PARAM_STR);
	$stmt -> execute();
	
	// target_id 取得　（autoIncreamentなので）
	$stmt = $pdo->query("SELECT LAST_INSERT_ID()");
	$result = $stmt -> fetch(PDO::FETCH_ASSOC);
	$target_id = $result['LAST_INSERT_ID()'];
	
	// pin作成
	$flag = true;
	$pin = 0;
	while($flag){
		$pin = rand(10000,99999);
		
		$stmt = $pdo->prepare("SELECT COUNT(*) AS cnt FROM MA10_projects WHERE pin=:pin");
		$stmt -> bindValue(':pin', $pin, PDO::PARAM_INT);
		$stmt -> execute();
		$table = $stmt -> fetch(PDO::FETCH_ASSOC);
		if($table['cnt'] ==0){$flag = false;}
	}
		$stmt = $pdo->prepare("INSERT INTO MA10_projects
					(name,member_id,target_id,pin,created) VALUES (:pName,:member_id,:target_id,:pin,NOW())");
		$stmt -> bindValue(':pName', $pName, PDO::PARAM_STR);
		$stmt -> bindValue(':member_id', $member_id, PDO::PARAM_INT);
		$stmt -> bindValue(':target_id', $target_id, PDO::PARAM_INT);
		$stmt -> bindValue(':pin', $pin, PDO::PARAM_INT);
		$stmt -> execute();
		
	// project_id 取得　（autoIncreamentなので）
	$stmt = $pdo->query("SELECT LAST_INSERT_ID()");
	$result = $stmt -> fetch(PDO::FETCH_ASSOC);
	$project_id = $result['LAST_INSERT_ID()'];

	return array($pin,$project_id,$target_id);
}

function set_voice_order($result_serialize,$project_id){ //class
	$pdo = get_pdo();
	$stmt = $pdo->prepare("UPDATE MA10_projects SET voice_order=:result_serialize  WHERE id=:project_id");
	$stmt -> bindValue(':result_serialize', $result_serialize, PDO::PARAM_STR);
	$stmt -> bindValue(':project_id', $project_id, PDO::PARAM_INT);
	$stmt -> execute();
}
function set_send_time($send_time,$project_id){ //class
	$pdo = get_pdo();
	$stmt = $pdo->prepare("UPDATE MA10_projects SET send_time=:send_time  WHERE id=:project_id");
	$stmt -> bindValue(':send_time', $send_time, PDO::PARAM_STR);
	$stmt -> bindValue(':project_id', $project_id, PDO::PARAM_INT);
	$stmt -> execute();
}
?>