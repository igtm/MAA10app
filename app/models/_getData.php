<?php 
function get_member($id){
	$pdo = get_pdo();
	
	$stmt = $pdo->prepare('select * from MA10_members where id=:id');
	$stmt -> bindValue(':id', $id, PDO::PARAM_INT);
	$stmt -> execute();
	$return = $stmt -> fetch();
	return $return;
}
function get_projects(){
	$return = array();
	$pdo = get_pdo();
	
	$stmt = $pdo->query('select * from MA10_projects');
	while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
		$return[] = $row;
	}
	return $return;
}
function get_projectDetail($id){
	$pdo = get_pdo();
	$stmt = $pdo -> prepare("SELECT *,p.id FROM MA10_projects p,MA10_targets t WHERE p.id=:id AND p.target_id=t.id");
	$stmt -> bindValue(":id",$id, PDO::PARAM_INT);
	$stmt -> execute();
	$return = $stmt -> fetch();
	return $return;
}


?>