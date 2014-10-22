<?php 
session_start();
require dirname(__FILE__).'/../app/controllers/controller.php';
$member_id = $_POST['member_id'];
$project_id = $_POST['project_id'];
$Project = new Project($project_id);

//そのメンバーとそのプロジェクトが一致するか
if($Project->is_ownProject($member_id)){
	list($wav_path,$playtime) = execute_project($project_id);
	// 結合に成功したか
	if(!empty($wav_path) && !empty($playtime)){
		$return = array("status"=>true,"comp_voice"=>$wav_path,"playtime"=>$playtime);
	}else{
		$return = array("status"=>false,"error"=>"結合が完了しませんでした。もう一度実行して下さい。");
	}
}else{
	$return = array("status"=>false,"error"=>"不正な操作です");
}
echo json_encode($return);
exit();
?>