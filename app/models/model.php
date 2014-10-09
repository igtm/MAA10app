<?php 
require '../config.php';
require '_db.php';
require '_oath.php';
require '_getData.php';
require '_tel.php';



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