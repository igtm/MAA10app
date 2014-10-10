<?php $title = 'ログイン';?>
<?php $isLogin = false;?>
<?php ob_start();?>
<h1><?php echo $title;?></h1>
<?php $authPear->start();?>
<?php $content = ob_get_clean();?>
<?php include 'layout.php';?>