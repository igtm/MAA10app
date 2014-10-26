<?php 
session_start();
require dirname(__FILE__).'/../lib/twilio-php/Services/Twilio.php';
require dirname(__FILE__).'/../app/controllers/controller.php';
$member_id = $_POST['member_id'];
$Project = new Project();
$Voice = new Voice();
$Member = new Member($member_id);
$Target = new Target();

//そのメンバーが存在するか
if($Member->is_member()){
	//メンバー消す
	$Member->delete_member();
	//target消す
	//voice消す
	$projects = $Project->get_target_idWithMember($member_id);
	foreach ($projects as $project){
		$Target->delete_target($project['target_id']);
		$Voice->delete_voices($project['id']);
	}
	//project消す
	$Project->delete_projectWithMember($member_id);
	$_SESSION = array();
	session_destroy();

	// 成功したか
	$return = array("status"=>true);
}else{
	$return = array("status"=>false,"error"=>"不正な操作です");
}
echo json_encode($return);
exit();
?>