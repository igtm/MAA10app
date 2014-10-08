<?php 
require 'config.php';

function get_pdo(){
	try {
		$pdo = new PDO(DSN,USER_NAME,PASSWORD,
					array(PDO::ATTR_EMULATE_PREPARES => false,
					PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
		$pdo->query("SET NAMES utf8");
		return $pdo;
	} catch (PDOException $e) {
		exit('データベース接続失敗。'.$e->getMessage());
	}
}

//ログインしているかどうか
function is_login(){
	if(isset($_SESSION['id']) && $_SESSION['time'] +3600 >time()){
		//ログインしている　最期の操作から１時間以内なら
		$_SESSION['time'] = time();
		return true; 
	}else{
		return false;
	}
}


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
function show_projectDetail($id){
	$pdo = get_pdo();
	$stmt = $pdo -> prepare("SELECT *,p.id FROM MA10_projects p,MA10_targets t WHERE p.id=:id AND p.target_id=t.id");
	$stmt -> bindValue(":id",$id, PDO::PARAM_INT);
	$stmt -> execute();
	$return = $stmt -> fetch();
	return $return;
}

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