<?php 
require dirname(__FILE__).'/../models/model.php';
function h($value){return htmlspecialchars($value,ENT_QUOTES,'UTF-8');}

//index
function index($app){
	$authPear = get_auth_pear();
	if($authPear->getAuth()){
		$app -> redirect(ROOT_DIR."app/mypage");
		exit();
	}
	$app->render('index.php');
}
///mypage
function mypage($app){
	$authPear = get_auth_pear();
	if(!$authPear->getAuth()){
		$app -> redirect(ROOT_DIR."app/");
		exit();
	}elseif($_GET['created']){
		$target_name = get_targetName($_GET['target_id']);
		$member_name = $authPear->getUsername();
	}
	$projects = get_projects($authPear->getAuthData('id'));
	$app->render('mypage.php', array('authPear'=>$authPear,'projects'=> $projects,'target_name'=>$target_name,'member_name'=>$member_name));
}
function get_projects($member_id){ // Class OK
	$Project = new Project();
	$return = $Project->get_projects($member_id);
	return $return;
}
function get_targetName($id){//class
	$Target = new Target($id);
	return $Target->get_targetName();
}

// mypage/createProject
function createProject($app){
	$authPear = get_auth_pear();
	if(!$authPear->getAuth()){
		$app -> redirect(ROOT_DIR."app/");
		exit();
	}elseif(!empty($_POST)){
		if(!empty($_POST['project_name'])&&!empty($_POST['target_name'])&&!empty($_POST['phone'])){
			list($pin,$project_id,$target_id) = create_project($_POST['project_name'],$_POST['target_name'],$_POST['phone'],$authPear->getAuthData('id'));
			$url = ROOT_DIR."app/mypage?created=true&pin=".h($pin)."&project_id=".h($project_id)."&target_id=".h($target_id);
			$app -> redirect($url);
		}else{
			$error_message = '記入漏れがあります。';
		}
	}
	$app->render('createProject.php', array('authPear'=>$authPear,'error_message'=>$error_message));	
}
function create_project($pName,$tName,$phone,$member_id){
	
	$Target = new Target();
	$target_id = $Target->create_target($tName,$phone);
	$Project = new Project();
	list($pin,$project_id) = $Project->create_project($pName,$member_id,$target_id);
	return array($pin,$project_id,$target_id);
}
// mypage/:id
function projectDetail($app,$id){
	$authPear = get_auth_pear();
	if(!$authPear->getAuth()){
		$app -> redirect(ROOT_DIR."app/");
		exit();
	}
	if(!empty($_POST['result_modify'])){ //順番が変更された
		$result_array = explode(',', $_POST['result_modify']);
		$result_serialize = serialize($result_array);
		set_voice_order($result_serialize,$id);
	}
	if(!empty($_POST['result_datetime'])){ //時間が変更された
		$send_time = $_POST['result_datetime'];
		set_send_time($send_time,$id);
	}
	if(!empty($_POST['result_datetime']) || !empty($_POST['result_modify'])){
		$app -> redirect(ROOT_DIR."app/mypage/".$id."?modified=true");
	}
	if($_GET['modified']){ //変更ー＞一旦リダイレクト　更新しても２重登録されない！
		$modified = true;
	}
	$project = get_projectDetail($id);
	$voices = get_voices($id,$voice_order);
	$app->render('projectDetail.php', array('authPear'=>$authPear,'project'=> $project,'voices'=>$voices,'modified'=>$modified));

}
function get_voices($project_id){ // class
	$Project = new Project($project_id);
	$return = $Project->get_voices();
	return $return;
}
function get_projectDetail($id){ // Class OK
	$Project = new Project($id);
	$return = $Project->get_projectDetail();
	return $return;
}
function set_voice_order($result_serialize,$project_id){ //class
	$Project = new Project($project_id);
	$Project->set_voice_order($result_serialize);
}
function set_send_time($send_time,$project_id){ //class
	$Project = new Project($project_id);
	$Project->set_send_time($send_time);
}
//account
function account($app){
	$authPear = get_auth_pear();
	if(!$authPear->getAuth()){
		$app -> redirect(ROOT_DIR."app/");
		exit();
	}
	$app->render('account.php',array('authPear'=>$authPear));
	
}
//logout
function logout($app){
	$authPear = get_auth_pear();
	$authPear -> logout();
	$authPear -> start();
	$app -> redirect(ROOT_DIR."app/");

}
//login
function login($app){
	$authPear = get_auth_pear();
	$app->render('login.php',array('authPear'=>$authPear));
}
//signup
function signup($app){
	$authPear = get_auth_pear();
	$app->render('signup.php',array('authPear'=>$authPear));
}
?>