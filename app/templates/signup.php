<?php $title = 'サインアップ';?>
<?php $isLogin = false;?>
<?php ob_start();?>
<?php
// POSTされていたらDBへの登録
define(PREG_EMAIL,"/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/");
$Member = new Member();
$error_message = null;
if(!empty($_POST)){
	if (empty($_POST['username']) || empty($_POST['name']) || empty($_POST['email']) || empty($_POST['password'])){$error_message = "記入漏れがあります。";}
	
	if(empty($error_message) && !($Member -> isNewUserName($_POST['username'])) || strlen($_POST['username']) <4){ $error_message = "このユーザー名は使用できません。"; }
	
	if(empty($error_message) && !(preg_match(PREG_EMAIL,$_POST['email'])) || !($Member -> isNewEmail($_POST['email']))){ $error_message = "このメールアドレスは使用できません。"; }
	if(empty($error_message) && strlen($_POST['password']) <6){ $error_message = "パスワードが短すぎます。"; }
	if(empty($error_message)){
		$Column = array('username'=>$_POST['username'],'password'=>$_POST['password'],'name' => $_POST['name'],'email'=>$_POST['email'],'created'=>'NOW()');
		$Member -> addMember($Column);
		header("Location: ".ROOT_DIR."app/mypage?first=true");
	}	
		
	
}
?>
<h1><?php echo $title;?></h1>
<?php require '_signupBlock.php';?>
<?php $content = ob_get_clean();?>
<?php include 'layout.php';?>