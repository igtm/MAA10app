<?php $title = 'マイページ';?>
<?php $isLogin = true;?>
<?php $icons = array(1 => "fa-edit","fa-clock-o","fa-caret-square-o-right","fa-exclamation-triangle","fa-check");?>
<?php ob_start();?>
<?php if($execute):?>
<div class="modified">プロジェクトが実行待ち状態に入りました！</div>
<?php endif;?>
	<?php if($_GET['created']):?>
    	<?php require("_tutorial_NewProject.php");?>
    <?php endif;?>
    <ul class="Lists">
    <p class="Lists_title">プロジェクト一覧</p>
    <a href="/API/MAA10app/app/mypage/createProject"><i class="fa fa-plus-square fa-2x icon_plus"></i></a>
    <div class="Tab">
        <ul class="Tab_block">
        <li class="Tab_select">誕生日</li>
        <li>応援！</li>
        <li>別れ</li>
        <li>オリジナル</li>
        </ul>
        <ul class="Tab_content">
            <li>親譲りの無鉄砲で小供の時から損ばかりしている。</li>
            <li class="Tab_hide">なぜそんな無闇をしたと聞く人があるかも知れぬ。</li>
            <li class="Tab_hide">新築の二階から首を出していたら、同級生の一人が冗談に</li>
            <li class="Tab_hide">この次は抜かさずに飛んで見せますと答えた。</li>
        </ul>
	</div>

    <?php foreach($projects as $project):?>
        <li class="List"><span class="List_status"><i class="fa <?php echo $icons[$project['status']];?>"></i></span><a href="mypage/<?php echo $project['id'];?>"><?php echo $project['name'];?></a></li>
    <?php endforeach;?>
    </ul>
    <div class="Reference_icon"><?php $a = '<i class="fa '; $b = '"></i>';?>
    	<?php echo $a.$icons[1].$b.":編集中 ".$a.$icons[2].$b.":実行待ち ".$a.$icons[3].$b.":実行中 ".$a.$icons[4].$b.":エラー ".$a.$icons[5].$b.":完了";?>
    </div>
<?php $content = ob_get_clean();?>
<?php include 'layout.php';?>