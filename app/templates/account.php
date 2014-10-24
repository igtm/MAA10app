<?php $title = 'アカウント';?>
<?php $isLogin = true;?>

<?php ob_start();?>
<div class="Box">
<p class="Box_title"><?php echo $title;?></p>
氏名：<?php echo $member['name'];?><br>
ユーザー名：<?php echo $member['username'];?><br>
メールアドレス：<?php echo $member['email'];?><br>
</div>
<?php $content = ob_get_clean();?>
<?php include 'layout.php';?>