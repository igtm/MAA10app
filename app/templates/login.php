<?php $title = 'ログイン';?>
<?php $isLogin = false;?>
<?php ob_start();?>
<h1><?php echo $title;?></h1>
    <form action="" method="post">
    <dl>
	<dt>ターゲット：</dt>
        <li>フリガナ：</li>
        <li>電話番号：</li>
        <li>ステータス：</li>
        <li>ID：</li>
    </dl>
    </form>
<?php $content = ob_get_clean();?>
<?php include 'layout.php';?>