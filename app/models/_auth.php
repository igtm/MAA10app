<?php 
include_once dirname(__FILE__).'/../../lib/Auth/Auth.php';
//include_once dirname(__FILE__).'/../../lib/DB/DB.php';
require 'config.php';

function get_auth_pear(){
	/*$db = DB::connect(DSN_DB);
	if (PEAR::isError($db)) {
		die($db->getMessage());
	}
	
	$db->query('SET NAMES utf8');
	if (PEAR::isError($db)) {
		die($db->getMessage());
	}
	*/
	
	$params = array(
		"dsn" => DSN_DB,
		"table" => "MA10_members",
		"usernamecol" => "username",
		"passwordcol" => "password",
		"cryptType"=>"none",
		"db_fields"=>"*",
	);
	$authPear = new Auth("DB", $params, "loginFunction");
	return $authPear;
}

function loginFunction($username, $status){
	switch($status) {
	case AUTH_EXPIRED:
		$error_message = '有効期限が切れました';
		break;
	case AUTH_IDLED:
		$error_messages = '長時間操作がなかったのでタイムアウトしました';
		break;
	case AUTH_WRONG_LOGIN:
		$error_message = 'ユーザー名、またはパスワードが間違っています。';
		break;
	default:
		$error_message = '';
	}
	
	require dirname(__FILE__).'/../templates/_loginBlock.php';
}

?>