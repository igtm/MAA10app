<?php 
session_start();
require dirname(__FILE__).'/../lib/twilio-php/Services/Twilio.php';
require dirname(__FILE__).'/../app/controllers/controller.php';
$member_id = $_POST['member_id'];
$project_id = $_POST['project_id'];
$Project = new Project($project_id);
$Voice = new Voice();
//そのメンバーとそのプロジェクトが一致するか
if($Project->is_ownProject($member_id)){
			// voiceの削除(TwilioDBから)
			$client = new Services_Twilio(ACCOUNT_SID, AUTH_TOKEN); 
			$table = $Voice->get_voices($project_id);
			foreach ($table as $voice){
				$client->account->recordings->delete($voice['voice']);
			}
			// voice行の完全削除(自DBから)
			$return = $Voice->delete_voices($project_id);
			
			$Project->change_status(5); // 完了

		$return = array("status"=>true);
}else{
	$return = array("status"=>false,"error"=>"不正な操作です");
}
echo json_encode($return);
exit();
?>