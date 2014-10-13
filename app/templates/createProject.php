<?php $title = '新規プロジェクト';?>
<?php $isLogin = true;?>
<?php ob_start();?>
<h1><?php echo $title;?></h1>
<?php echo $error_message;?>
<div class="Box">
<table>
<form method="post" accept-charset="utf-8">
<tr><td><label for="project_name">プロジェクト名：</label></td><td><input type='text' id="project_name" name='project_name' maxlength="32" required></td></tr>
<tr><td><label for="target_name">相手の名前：</label></td><td><input type='text' id="target_name" name='target_name' maxlength="32" required></td></tr>
<tr><td><label for="phone">相手の電話番号：</label></td><td><input type='tel' id="phone" name='phone' maxlength="32" required></td></tr>
<tr><td><label for="datetime">入電したい時間：</label></td>
	<td><input type="datetime-local" name="datetime" min="" 
    	max="" step="1800" value="<?php echo date("Y-m-d\T H-i-s");?>" required>
    </td>
</tr>
<tr><td><input type='submit' value="作成！" maxlength="32"></td></tr>
</form>
</table>
</div>
<?php $content = ob_get_clean();?>
<?php include 'layout.php';?>