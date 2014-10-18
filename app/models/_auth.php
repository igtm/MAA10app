<?php 
function isLogin($app,$redirect){
	if(isset($_SESSION['MA10_id']) && isset($_SESSION['MA10_time'])){
		return true;	
	}else{
		$app -> redirect(ROOT_DIR.$redirect);
		exit();
	}
}
?>