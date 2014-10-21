<?php $title = 'プロジェクト';?>
<?php $isLogin = true;?>
<?php $status = array(1 => "編集中","実行待ち","実行中","エラー","完了");?>
<?php $scene = array(1 => "誕生日<i class='fa fa-birthday-cake'></i>",2=>"応援！<i class='fa fa-flag-o scene_cheerup'></i>",3=>"別れ<i class='fa fa-child scene_farewell'></i>",10=>"オリジナル<i class='fa fa-file-audio-o scene_original'></i>");?>
<?php ob_start();?>
<?php if($modified):?>
<div class="modified">変更されました。</div>
<?php endif;?>
<div class="Box">
<p class="Box_title"><?php echo h($title);?></p>
	<table>
    <tr>
    <td>プロジェクト名</td>
    <td><?php echo "：".h($project['name']);?></td>
    </tr>
    <tr>
    <td>ステータス</td>
    <td><?php echo "：".h($status[$project['status']]);?></td>
    </tr>
    <tr>
    <td>シーン</td>
    <td><?php echo "：".$scene[$project['scene']];?></td>
    </tr>
    <tr>
    <td>録音可能秒数</td>
    <td><?php echo "：".h($project['recordtime']);?></td>
    </tr>
    <tr>
    <td>PINコード</td>
    <td><?php echo "：".h($project['pin']);?></td>
    </tr>
    </table>
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
<button id="submit-execute" class="btn-original" <?php if(empty($project['send_time']) || empty($voices)){?>disabled<?php }?>>音声結合！</button>
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
			<?php echo $voice['id'].$voice['memo'];?>
            <a href="<?php echo VOICE_URL.h($voice['voice']);?>"><i class="fa fa-caret-square-o-right Voices_play" style="font-size:22px;"></i></a>
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
<div id="dialog" title="音声結合完了！">
<div class="Dialog_boxes">
    <div class="Dialog_left">結合ファイルをダウンロード<a href=""><i class="fa fa-caret-square-o-right"></i>
</a></div>
    <div class="Dialog_right">指定番号に入電、自動再生</div>
</div>
</div>
<?php $content = ob_get_clean();?>
<?php include 'layout.php';?>