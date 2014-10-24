<?php $title = 'アカウント';?>
<?php $isLogin = true;?>
<?php $member_name = $member['username'];?>

<?php ob_start();?>
<div class="Box">
<p class="Box_title"><?php echo $title;?></p>
<table>
<tr>
<td>氏名</td>
<td><?php echo "：".h($member['name']);?></td>
</tr>
<tr>
<td>ユーザー名</td>
<td><?php echo "：".h($member['username']);?></td>
</tr>
<tr>
<td>メールアドレス</td>
<td><?php echo "：".h($member['email']);?></td>
</tr>
</table>
</div>
<?php $content = ob_get_clean();?>
<?php include 'layout.php';?>