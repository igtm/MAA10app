<?php $title = '戦う君へ。ファイトコール！';?>
<?php $isLogin = false;?>

<?php ob_start();?>
<h1><?php echo $title;?></h1>

<?php $content = ob_get_clean();?>
<?php include 'layout.php';?>