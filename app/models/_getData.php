<?php 
function get_member($id){
	$pdo = get_pdo();
	
	$stmt = $pdo->prepare('select * from MA10_members where id=:id');
	$stmt -> bindValue(':id', $id, PDO::PARAM_INT);
	$stmt -> execute();
	$return = $stmt -> fetch();
	return $return;
}
function get_projects($member_id){
	$return = array();
	$pdo = get_pdo();
	
	$stmt = $pdo->prepare('select * from MA10_projects WHERE member_id=:id ORDER BY id DESC');
	$stmt -> bindValue(":id",$member_id, PDO::PARAM_INT);
	$stmt -> execute();
	while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
		$return[] = $row;
	}
	return $return;
}
function get_projectDetail($id){
	$pdo = get_pdo();
	$stmt = $pdo -> prepare("SELECT *,p.id,p.name AS project_name, t.name AS target_name FROM MA10_projects p,MA10_targets t WHERE p.id=:id AND p.target_id=t.id");
	$stmt -> bindValue(":id",$id, PDO::PARAM_INT);
	$stmt -> execute();
	$return = $stmt -> fetch();
	return $return;
}
function get_memberName($project_id){
	$pdo = get_pdo();
	$stmt = $pdo -> prepare("SELECT m.name FROM MA10_projects p,MA10_members m WHERE m.id=p.member_id AND p.id=:id");
	$stmt -> bindValue(":id",$project_id, PDO::PARAM_INT);
	$stmt -> execute();
	$return = $stmt -> fetch();
	return $return['name'];
}
function get_targetName($id){
	$pdo = get_pdo();
	$stmt = $pdo -> prepare("SELECT name FROM MA10_targets WHERE id=:id");
	$stmt -> bindValue(":id",$id, PDO::PARAM_INT);
	$stmt -> execute();
	$return = $stmt -> fetch();
	return $return['name'];
}

?>