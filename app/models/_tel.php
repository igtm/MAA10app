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



?>