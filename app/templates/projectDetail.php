<?php $secondHierarchyLevel = true;?>
<?php $title = 'プロジェクト';?>
<?php $isLogin = true;?>
<?php $status = array(1 => "<i class='fa fa-edit'></i> 編集中","<i class='fa fa-clock-o'></i> 実行待ち","<i class='fa fa-caret-square-o-right'></i> 実行中","<i class='fa fa-exclamation-triangle'></i> エラー","<i class='fa fa-check'></i> 完了");?>
<?php $scene = array(1 => "<i class='fa fa-birthday-cake'></i> 誕生日",2=>"<i class='fa fa-flag-o scene_cheerup'></i> 応援！",3=>"<i class='fa fa-child scene_farewell'></i> 別れ",10=>"<i class='fa fa-file-audio-o scene_original'></i> オリジナル");?>
<?php $sceneArray = array(1 => INBOUND_BIRTHDAY,2=>INBOUND_CHEERUP,3=>INBOUND_FAREWELL);?>
<?php
	if($project['scene']==10){
		$contentTobeRecorded = $project['original_content'];
	}else{
		$contentTobeRecorded = $sceneArray[$project['scene']];
	}
?>
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
    <td>録音して欲しい内容</td>
    <td><?php echo "：".h($contentTobeRecorded);?></td>
    </tr>
    <tr>
    <td>ステータス</td>
    <td><?php echo "：".$status[$project['status']];?></td>
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
<p id="SetPhrase_title"><i class="fa fa-caret-right"></i> メール定型文を表示</p>
<p class="Project_delete">削除</p>
<div id="SetPhrase_box" style="display:none;">

            <div class="Tutorial_box">
                <hr style="border: solid 1px #e74c3c;">
				<div class="Tutorial_sentence">
                【<?php echo h($project['name']);?>】<br>
                このサービスは「電話でみんなの声を集める」サービスです。<br>
                皆さんの【<?php echo h($contentTobeRecorded);?>】をつなぎあわせ、大切な人へ送ります。<br>
                ーーーーーーーーーー<br>
                編集者：<?php echo $member_name;?>さん<br>
                ーーーーーーーーーー<br>
                協力して頂けるみなさんへ（１分程度）<br>
                １：【05031717110】に電話<br>
                ２：PINコード【<?php echo h($project['pin']);?>】を入力<br>
                ３：【<?php echo h($project['recordtime']);?>秒以内で】あなたの名前と【<?php echo h($contentTobeRecorded);?>】を録音！<br><br>
                
                <br />
                ----------------<br />
                Voice Hub<br />
                〜みんなの声を電話で収集できるWEBアプリ〜<br />
                <?php echo ROOT_DIR.'app/';?><br />
                </div>
            </div>

</div>
</div>
<div class="form_modifyVoice">
<form method="POST">
<input type="hidden" name="result_modify" id="result_modify">
<div class="form_btn">
<button id="submit-modify" class="btn-original" disabled>変更保存</button>
<input type="button" id="submit-execute" class="btn-original" value="音声結合！" <?php if(empty($voices) || $project['status']!=1){?>disabled<?php }?>>
</div>
</form>
</div>
<?php if($project['status']==1){?>
<div class="Voices">
	<ul class="Voices_lists">
    <?php if(empty($voices)){?>
        <li class="Voices_list">録音された音声がありません。</li>
    <?php }else{?>
    	<?php $i = 1;?>
		<?php foreach ($voices as $voice):?>
    	<li class="Voices_list" id="<?php echo h($voice['id']);?>" data-voice="<?php echo $voice['voice'];?>">
			<?php echo $voice['memo'];?>
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
<?php }else{?>
<div class="center">
	<a href="<?php echo h($project['comp_voice']);?>" target="_blank"><i class="fa fa-5x fa-caret-square-o-right"></i></a>
</div>
<?php }?>

<div id="dialog" title="音声結合完了！">
<div class="Dialog_boxes">
    <div class="Dialog_left">
    	<div class="Dialog_title">ダウンロード</div>
        <div class="Dialog_body"><a href="" target="_blank"><i class="fa fa-4x fa-caret-square-o-right"></i></a></div>
        <button id="dialog-complete" class="btn-original">プロジェクト完了</button>
    </div>
    <div class="Dialog_right">
    	<div class="Dialog_title">電話で再生する</div>
        <div class="Dialog_body">
                <label for="datetime">入電したい時間：</label>
                <input type="datetime-local" id="datetime" class="Dialog_datetime" style="width: 100%;font-size: .8rem;" name="datetime" min="<?php echo date("Y-m-d")."T".date("H:00",strtotime("+1 hour"));?>"
                max="<?php echo date("Y-m-d",strtotime("+3 month"))."T".date("H:00",strtotime("+1 hour"));?>" step="1800" value="<?php echo date("Y-m-d")."T".date("H:00",strtotime("+1 hour"));?>">
                <input type="tel" placeholder="電話番号" id="phone" name="phone" style="width: 100%;font-size: .8rem;" />
		</div>
        <button id="dialog-execute" class="btn-original" disabled>実行</button>
    </div>
</div>
</div>
<?php $content = ob_get_clean();?>
<?php include 'layout.php';?>