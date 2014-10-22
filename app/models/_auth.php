<?php 
function isLogin($app,$redirect){
	if(isset($_SESSION['MA10_id']) && $_SESSION['MA10_time'] +3600 >time()){
		$_SESSION['MA10_time'] = time();
		return true;	
	}else{
		$app -> redirect(ROOT_DIR.$redirect);
		exit();
	}
}
?>