<?php $title = 'サインアップ';?>
<?php $isLogin = false;?>
<?php ob_start();?>
<?php
// POSTされていたらDBへの登録
$error_message = false;
if(!empty($_POST)){
	if (!empty($_POST['username']) && !empty($_POST['name']) && !empty($_POST['kana']) && !empty($_POST['email']) && !empty($_POST['password'])){
		$otherColumn = array('name' => $_POST['name'],'kana'=>$_POST['kana'],'email'=>$_POST['email'],'created'=>'NOW()');
		$authPear -> addUser($_POST['username'], $_POST['password'], $otherColumn);
	}else{
		$error_message = "記入漏れがあります。";
	}
}
?>
<h1><?php echo $title;?></h1>
<?php require '_signupBlock.php';?>
<?php $content = ob_get_clean();?>
<?php include 'layout.php';?>