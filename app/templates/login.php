<?php $title = 'ログイン';?>
<?php $isLogin = false;?>
<?php ob_start();?>
<h1><?php echo $title;?></h1>
<?php 
$error_message = false;
if(!empty($_POST)){
if(!empty($_POST['username']) && !empty($_POST['password'])){
	$flag = $Member->login($_POST['username'],$_POST['password']);
	if($flag){
		header('Location: '.ROOT_DIR.'app/mypage');
		exit();
	}else{
		$error_message = 'ユーザー名とパスワードが一致しません。';
	}
}else{
	$error_message = '記入漏れが有ります。';
}
}?>
<?php require '_loginBlock.php';?>

<?php $content = ob_get_clean();?>
<?php include 'layout.php';?>