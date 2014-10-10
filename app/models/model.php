<?php 
require 'config.php';
require_once '_db.php';
require_once '_oath.php';
require_once '_getData.php';
require_once '_voice.php';
require_once '_tel.php';







/* --その他 -- */

//ログインしているかどうか
function is_login(){
	if(isset($_SESSION['id']) && $_SESSION['time'] +3600 >time()){
		//ログインしている　最期の操作から１時間以内なら
		$_SESSION['time'] = time();
		return true; 
	}else{
		return false;
	}
}

?>