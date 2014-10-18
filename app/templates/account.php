<?php $title = 'アカウント';?>
<?php $isLogin = true;?>

<?php ob_start();?>
<div class="Box">
<p class="Box_title"><?php echo $title;?></p>
名前：<?php echo $member_name;?>
</div>
<?php $content = ob_get_clean();?>
<?php include 'layout.php';?>