<?php $title = 'マイページ';?>
<?php $isLogin = true;?>
<?php $icons = array(1 => "fa-edit","fa-clock-o","fa-caret-square-o-right","fa-exclamation-triangle","fa-check");?>
<?php ob_start();?>
<h1><?php echo $title;?></h1>
<a href="/API/MAA10app/app/mypage/createProject">新しいプロジェクトを作成する</a>
	<?php if($_GET['created']):?>
    	<div class="NewProjTutorial">
            <div class="NewProjTutorial_title">プロジェクトが作成されました！</div>
            <div class="NewProjTutorial_box">
				まずはみんなの声を集めましょう。以下の文章は一例です。コピペして使用して下さい。
                <hr>
				<div class="NewProjTutorial_sentence">
                <?php echo $target_name;?>さんをみんなのショートボイスで感動させよう！<br>
                このサービスは「みんなの声で大切な人を感動させる」ためのサービスです。<br>
                皆さんの声をつなぎあわせ、音楽にのせ、大切な人へ送ります。<br>
                どんな高価な物よりも、みなさんの声が感動させるのです。<br>
                日頃は、面と向かっていえない感謝の言葉、他愛のないメッセージ、、、など伝えましょう！<br>
                ーーーーーーーーーー<br>
                おおよその期限日時：
                編集者：<?php echo $member_name;?>さん<br>
                感動させたい人：<?php echo $target_name;?>さん<br>
                ーーーーーーーーーー<br>
                協力して頂けるみなさんへ（所要時間１分程度）<br>
                １：【05031717906】に電話<br>
                ２：PINコード【<?php echo h($_GET['pin']);?>】を入力<br>
                ３：【10秒以内で】あなたの名前とメッセージを録音！<br><br>
                
                出来上がったボイスメッセージは、みなさんもお聴き頂けます。<br>
                
                </div>
            </div>
        </div>
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