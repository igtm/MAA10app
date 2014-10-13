<?php $title = '戦う君へ。ファイトコール！';?>
<?php $isLogin = false;?>

<?php ob_start();?>
<h1><?php echo $title;?></h1>
<div class="Box">
このサービスは「みんなの声で大切な人を感動させる」ためのサービスです。<br>
                皆さんの声をつなぎあわせ、音楽にのせ、大切な人へ送ります。<br>
                どんな高価な物よりも、みなさんの声が感動させるのです。<br>
                日頃は、面と向かっていえない感謝の言葉、他愛のないメッセージ、、、など伝えましょう！<br>
</div>
<?php $content = ob_get_clean();?>
<?php include 'layout.php';?>