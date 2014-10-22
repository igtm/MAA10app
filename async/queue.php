<?php 
session_start();
require dirname(__FILE__).'/../app/controllers/controller.php';
$member_id = $_POST['member_id'];
$project_id = $_POST['project_id'];
$phone = $_POST['phone'];
$send_time = $_POST['send_time'];
$Project = new Project($project_id);

//そのメンバーとそのプロジェクトが一致するか
if($Project->is_ownProject($member_id)){
	$Target = new Target();
	$target_id = $Target->create_target($phone);
	
	$flag = $Project->queue($send_time,$target_id);
	// 成功したか
	if($flag){
		$return = array("status"=>true);
	}else{
		$return = array("status"=>false,"error"=>"結合が完了しませんでした。もう一度実行して下さい。");
	}
}else{
	$return = array("status"=>false,"error"=>"不正な操作です");
}
echo json_encode($return);
exit();
?>