<?php $title = 'アカウント';?>
<?php $isLogin = true;?>

<?php ob_start();?>
<h1><?php echo $title;?></h1>
<div class="Box">
名前：<?php echo $authPear->getUsername();?>
</div>
<?php $content = ob_get_clean();?>
<?php include 'layout.php';?>