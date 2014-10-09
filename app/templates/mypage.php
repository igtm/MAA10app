<?php $title = 'マイページ';?>
<?php $isLogin = true;?>
<?php ob_start();?>
<h1><?php echo $title;?></h1>
    <ul class="Lists">
    <p class="Lists_title">プロジェクト一覧</p>
    <?php foreach($projects as $project):?>
        <li><a href="mypage/<?php echo $project['id'];?>"><?php echo $project['pin'];?></a></li>
    <?php endforeach;?>
    </ul>
<?php $content = ob_get_clean();?>
<?php include 'layout.php';?>