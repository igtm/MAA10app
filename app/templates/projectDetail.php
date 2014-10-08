<?php $title = 'プロジェクト';?>
<?php $isLogin = true;?>
<?php ob_start();?>
<h1><?php echo $title;?></h1>
    <ul>
        <li>ターゲット：<?php echo $project['name'];?></li>
        <li>フリガナ：<?php echo $project['kana'];?></li>
        <li>電話番号：<?php echo $project['phone'];?></li>
        <li>ステータス：<?php echo $project['status'];?></li>
        <li>ID：<?php echo $project['id'];?></li>
    </ul>
<?php $content = ob_get_clean();?>
<?php include 'layout.php';?>