<?php $title = 'サインアップ';?>
<?php $isLogin = false;?>
<?php ob_start();?>
<h1><?php echo $title;?></h1>
signuppage
<?php $content = ob_get_clean();?>
<?php include 'layout.php';?>