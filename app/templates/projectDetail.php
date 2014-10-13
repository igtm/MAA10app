<?php $title = 'プロジェクト';?>
<?php $isLogin = true;?>
<?php $status = array(1 => "編集中","実行待ち","実行中","エラー","完了");?>
<?php ob_start();?>
<h1><?php echo $title;?></h1>
<div class="Box">
    <ul>
        <li>プロジェクト名：<?php echo $project['project_name'];?></li>
        <li>ステータス：<?php echo $status[$project['status']];?></li>
        <li>ターゲット：<?php echo $project['target_name'];?></li>
        <li>フリガナ：<?php echo $project['kana'];?></li>
        <li>電話番号：<?php echo $project['phone'];?></li>
    </ul>
</div>
<?php $content = ob_get_clean();?>
<?php include 'layout.php';?>