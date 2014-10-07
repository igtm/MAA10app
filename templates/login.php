<?php $title = 'ログイン';?>
<?php $isLogin = true;?>
<?php ob_start();?>
<h1><?php echo $title;?></h1>
    <form action="" method="post">
    <dl>
	<dt>ターゲット：<?php echo $project['name'];?></dt>
        <li>フリガナ：<?php echo $project['kana'];?></li>
        <li>電話番号：<?php echo $project['phone'];?></li>
        <li>ステータス：<?php echo $project['status'];?></li>
        <li>ID：<?php echo $project['id'];?></li>
    </dl>
    </form>
<?php $content = ob_get_clean();?>
<?php include 'layout.php';?>