<?php 
function get_member($id){ //class
	$pdo = get_pdo();
	
	$stmt = $pdo->prepare('select * from MA10_members where id=:id');
	$stmt -> bindValue(':id', $id, PDO::PARAM_INT);
	$stmt -> execute();
	$return = $stmt -> fetch(PDO::FETCH_ASSOC);
	return $return;
}
function get_projects($member_id){ // Class OK
	$pdo = get_pdo();
	
	$stmt = $pdo->prepare('select * from MA10_projects WHERE member_id=:id ORDER BY id DESC');
	$stmt -> bindValue(":id",$member_id, PDO::PARAM_INT);
	$stmt -> execute();
	$return = $stmt -> fetchAll();
	return $return;
}

function get_projectDetail($id){ // Class OK
	$pdo = get_pdo();
	$stmt = $pdo -> prepare("SELECT *,p.id,p.name AS project_name, t.name AS target_name FROM MA10_projects p,MA10_targets t WHERE p.id=:id AND p.target_id=t.id");
	$stmt -> bindValue(":id",$id, PDO::PARAM_INT);
	$stmt -> execute();
	$return = $stmt -> fetch(PDO::FETCH_ASSOC);
	return $return;
}

function get_voices($project_id){ // class
	
	$pdo = get_pdo();
	$stmt = $pdo -> prepare("SELECT * FROM MA10_voices WHERE project_id=:project_id");
	$stmt -> bindValue(":project_id",$project_id, PDO::PARAM_INT);
	$stmt -> execute();
	while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
		$return[] = $row;
	}
	$stmt->closeCursor();
	//並び替え voice_order
	$order = get_voice_order($project_id);
	if($order){ // 順番が記録されている場合のみ
		$order_serialize = unserialize($order);
		return sort_by_baseArray($return,$order_serialize);
	}
	return $return;
	
}

// voiceの順番をbaseArrayに入ってるidで並び替える
function sort_by_baseArray($array,$baseArray){ // class
	
	$a = array();
	for($i=0;$i<count($baseArray);$i++){
		for($j=0;$j<count($array);$j++){
			if($baseArray[$i]==$array[$j]['id']){ // 同じだったら
				$a[] = $array[$j];//入れる
				array_splice($array,$j,1); // 消す
				break;
			}
		}
	}
	for($i=0;$i<count($array);$i++){ // 残ったやつ(新しく録音されたやつ)
		$a[] = $array[$i];
	}
	return $a;
	
}

function get_voice_order($project_id){ //get_voicesから呼ばれる classOK

	$pdo = get_pdo();
	$stmt = $pdo -> prepare("SELECT voice_order FROM MA10_projects WHERE id=:project_id");
	$stmt -> bindValue(":project_id",$project_id, PDO::PARAM_INT);
	$stmt -> execute();
	$result = $stmt -> fetch(PDO::FETCH_ASSOC);
	$stmt->closeCursor();

	return $result['voice_order'];
}

function get_memberName($project_id){//class
	
	$pdo = get_pdo();
	$stmt = $pdo -> prepare("SELECT m.name FROM MA10_projects p,MA10_members m WHERE m.id=p.member_id AND p.id=:id");
	$stmt -> bindValue(":id",$project_id, PDO::PARAM_INT);
	$stmt -> execute();
	$return = $stmt -> fetch(PDO::FETCH_ASSOC);
	return $return['name'];
}

function get_targetName($id){//class
	
	$pdo = get_pdo();
	$stmt = $pdo -> prepare("SELECT name FROM MA10_targets WHERE id=:id");
	$stmt -> bindValue(":id",$id, PDO::PARAM_INT);
	$stmt -> execute();
	$return = $stmt -> fetch(PDO::FETCH_ASSOC);
	return $return['name'];
}

?>