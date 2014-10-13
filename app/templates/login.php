<?php $title = 'ログイン';?>
<?php $isLogin = false;?>
<?php ob_start();?>
<h1><?php echo $title;?></h1>
<?php $authPear->start();?>
<?php 
$error_message = false;
if($authPear->getAuth()){
	header('Location: /API/MAA10app/app/mypage');
	exit();
}elseif(!empty($_POST['username']) && !empty($_POST['password'])){
	$error_message = 'ユーザー名とパスワードが一致しません。';
}?>

<?php $content = ob_get_clean();?>
<?php include 'layout.php';?>