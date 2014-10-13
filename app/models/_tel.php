<?php 
/* ------------ TEL inbound ------- */
function get_target_name($phone){
	$pdo = get_pdo();
	
	$stmt = $pdo->prepare('select name from MA10_targets where phone=:phone');
	$stmt -> bindParam(':phone', $phone, PDO::PARAM_STR);
	$stmt -> execute();
	var_dump($stmt);
	$return = $stmt -> fetch();
	var_dump($return);
	return $return;
}
function is_target($pin){
	$pdo = get_pdo();
	var_dump($pdo);
	$stmt = $pdo -> prepare("SELECT p.pin,t.name FROM MA10_projects p, MA10_targets t WHERE p.target_id=t.id AND t.pin= :pin");
	$stmt -> bindParam(':pin', $pin, PDO::PARAM_STR);
	$stmt -> execute();
	//$resultSet = $stmt->fetchAll();
	//$resultNum = count($resultSet);
	return $stmt;
}



?>