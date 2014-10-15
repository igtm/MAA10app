<?php $title = 'プロジェクト';?>
<?php $isLogin = true;?>
<?php $status = array(1 => "編集中","実行待ち","実行中","エラー","完了");?>
<?php ob_start();?>
<h1><?php echo h($title);?></h1>
<?php if($modified):?>
<div class="modified">変更されました。</div>
<?php endif;?>
<div class="Box">
    <ul>
        <li>プロジェクト名：<?php echo h($project['project_name']);?></li>
        <li>ステータス：<?php echo h($status[$project['status']]);?></li>
        <li>ターゲット：<?php echo h($project['target_name']);?></li>
        <li>フリガナ：<?php echo h($project['kana']);?></li>
        <li>電話番号：<?php echo h($project['phone']);?></li>
                   
    </ul>
</div>
<div class="form_modifyVoice">
<form method="POST">
<input type="hidden" name="result_datetime" id="result_datetime">
<input type="hidden" name="result_modify" id="result_modify">
<label for="datetime">入電したい時間：</label>
<input type="datetime-local" id="datetime" name="datetime" min="<?php echo date("Y-m-d")."T".date("H:00",strtotime("+1 hour"));?>" 
    	max="<?php echo date("Y-m-d",strtotime("+3 month"))."T".date("H:00",strtotime("+1 hour"));?>" step="1800" value="<?php echo h(str_replace(" ", "T", $project['send_time']));?>">
<div class="form_btn">
<button id="submit-modify" class="btn-original" disabled>変更保存</button>
<button id="submit-execute" class="btn-original" <?php if(empty($project['send_time']) || empty($voices)){?>disabled<?php }?>>実行！</button>
</div>
</form>
</div>
<div class="Voices">

	<ul class="Voices_lists">
    <?php if(empty($voices)){?>
        <li class="Voices_list">録音された音声がありません。</li>
    <?php }else{?>
    	<?php $i = 1;?>
		<?php foreach ($voices as $voice):?>
    	<li class="Voices_list" id="<?php echo h($voice['id']);?>" data-voice="<?php echo $voice['voice'];?>">
			<?php echo $voice['id'].$voice['voice'].$voice['created'];?>
            <a href="http://api.twilio.com/2010-04-01/Accounts/AC1a5cb11fc93ebd4c8df75d7b056e62bb/Recordings/<?php echo h($voice['voice']);?>"><i class="fa fa-caret-square-o-right Voices_play" style="font-size:22px;"></i></a>
        </li>
		<?php $i++;?>
        <?php endforeach;?>
    <?php }?>
    </ul>
    <ul class="Voices_Ranks">
    <span class="Voices_RanksInfo">再生順</span>
    <?php for($j=1;$j<$i;$j++):?>
        <li class="Voices_Rank"><?php echo $j;?></li>
    <?php endfor;?>
    </ul>
</div>
<?php $content = ob_get_clean();?>
<?php include 'layout.php';?>