<?php
require dirname(__FILE__).'/../lib/twilio-php/Services/Twilio.php';
require dirname(__FILE__).'/../app/models/model.php';
function h($value){return htmlspecialchars($value,ENT_QUOTES,'UTF-8');}
$CallSid = h($_POST['CallSid']); 
$project_id = $_GET['project_id'];
$CallStatus = $_POST['CallStatus'];
switch($CallStatus){
	case 'completed':
		// status=5　終了。
		$Project = new Project($project_id);
		$Project->change_status(5);
		break;
	default:
		break;
}
?>