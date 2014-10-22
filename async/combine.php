<?php 
session_start();
require dirname(__FILE__).'/../app/controllers/controller.php';
$member_id = $_POST['member_id'];
$project_id = $_POST['project_id'];
$Project = new Project($project_id);

//そのメンバーとそのプロジェクトが一致するか
if($Project->is_ownProject($member_id)){
	$table = $Project->get_projectDetail();
	$voice = $table['comp_voice'];
	if($voice){
		$filename = strstr($voice, "wav_");
		$isDeleted = unlink(dirname(__FILE__).'/../app/models/voices/'.$filename);
		if(!$isDeleted){return array('status'=>false,'error'=>'元の結合音声の削除が完了出来ませんでした。');}
	}
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