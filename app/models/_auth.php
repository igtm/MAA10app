<?php 
require_once '../lib/Auth/Auth.php';
require 'config.php';

function get_auth_pear(){
	$params = array(
		"dsn" => "mysqli://".USER_NAME.":".PASSWORD."@".HOST."/".DB_NAME,
		"table" => "MA10_members",
		"usernamecol" => "username",
		"passwordcol" => "password"
	);
	$authPear = new Auth("DB", $params, "loginFunction");
	return $authPear;
}

function loginFunction($username, $status){
	require '/API/MAA10app/app/templates/_authBlock.php';
}

?>