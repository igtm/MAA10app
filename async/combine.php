<?php 
session_start();
require dirname(__FILE__).'/../app/controllers/controller.php';
$member_id = $_POST['member_id'];
$project_id = $_POST['project_id'];
$Project = new Project($project_id);
if($Project->is_ownProject($member_id)){
	list($wav_path,$playtime) = execute_project($project_id);
	$return = array("is_ownProject"=>true,"comp_voice"=>$wav_path,"playtime"=>$playtime);
}else{
	$return = array("is_ownProject"=>false,"error"=>"不正な操作です");
}
echo json_encode($return);
exit();
?>