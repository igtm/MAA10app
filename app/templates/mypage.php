<?php $title = 'マイページ';?>
<?php $isLogin = true;?>
<?php $icons = array(1 => "fa-edit","fa-clock-o","fa-caret-square-o-right","fa-exclamation-triangle","fa-check");?>
<?php ob_start();?>
<h1><?php echo $title;?></h1>
<?php if($execute):?>
<div class="modified">プロジェクトが実行待ち状態に入りました！</div>
<?php endif;?>
<a href="/API/MAA10app/app/mypage/createProject">新しいプロジェクトを作成する</a>
	<?php if($_GET['created']):?>
    	<?php require("_tutorial_NewProject.php");?>
    <?php endif;?>
    <ul class="Lists">
    <p class="Lists_title">プロジェクト一覧</p>
    <?php foreach($projects as $project):?>
        <li class="List"><span class="List_status"><i class="fa <?php echo $icons[$project['status']];?>"></i></span><a href="mypage/<?php echo $project['id'];?>"><?php echo $project['name'];?></a></li>
    <?php endforeach;?>
    </ul>
    <div class="Reference_icon"><?php $a = '<i class="fa '; $b = '"></i>';?>
    	<?php echo $a.$icons[1].$b.":編集中 ".$a.$icons[2].$b.":実行待ち ".$a.$icons[3].$b.":実行中 ".$a.$icons[4].$b.":エラー ".$a.$icons[5].$b.":完了";?>
    </div>
<?php $content = ob_get_clean();?>
<?php include 'layout.php';?>