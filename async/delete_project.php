<?php 
require dirname(__FILE__).'/../lib/twilio-php/Services/Twilio.php';
require dirname(__FILE__).'/../app/controllers/controller.php';
$member_id = $_POST['member_id'];
$project_id = $_POST['project_id'];
$Project = new Project($project_id);
$Voice = new Voice();

//そのメンバーとそのプロジェクトが一致するか
if($Project->is_ownProject($member_id)){
	$project = $Project->get_projectDetail();
	$Project->delete_project();
	$table = $Voice->get_voices($project_id);
	if(!empty($table)){
		$Voice->delete_voices($project_id);
		// voiceの削除(TwilioDBから)
		$client = new Services_Twilio(ACCOUNT_SID, AUTH_TOKEN); 
		foreach ($table as $result){
			$client->account->recordings->delete($result['voice']);
		}
	}
	if($project['status']!=1){
		$Target = new Target();
		$Target->delete_target($project['target_id']);	
	}	
	// 成功したか
	$return = array("status"=>true);
}else{
	$return = array("status"=>false,"error"=>"不正な操作です");
}
echo json_encode($return);
exit();
?>