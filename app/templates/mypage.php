<?php $title = 'マイページ';?>
<?php $isLogin = true;?>
<?php $icons = array(1 => "fa-edit","fa-clock-o","fa-caret-square-o-right","fa-exclamation-triangle","fa-check");?>
<?php $scene = array(1 => "<i class='fa fa-birthday-cake scene_birthday'></i>",2=>"<i class='fa fa-flag-o scene_cheerup'></i>",3=>"<i class='fa fa-child scene_farewell'></i>",10=>"<i class='fa fa-file-audio-o scene_original'></i>");?>
<?php ob_start();?>
<?php if(!empty($error_message)){echo $error_message;}?>
<?php if($_GET['execute']):?>
<div class="modified">プロジェクトが実行待ち状態に入りました！</div>
<?php endif;?>
<?php if($_GET['complete']):?>
<div class="modified">プロジェクト完了！</div>
<?php endif;?>

	<?php if($_GET['created']):?>
    	<?php require("_tutorial_NewProject.php");?>
    <?php endif;?>
    <?php if($_GET['first']):?>
    	<?php require("_tutorial_NewMember.php");?>
    <?php endif;?>

    <div class="Tab">
    <p class="Tab_title">プロジェクト作成</p>
        <ul class="Tab_block">
        <li class="Tab_select"><i class='fa fa-birthday-cake'></i> 誕生日</li>
        <li><i class='fa fa-flag-o'></i> 応援！</li>
        <li><i class='fa fa-child'></i> 別れ</li>
        <li><i class='fa fa-file-audio-o'></i> オリジナル</li>
        </ul>
        <ul class="Tab_content">
        <form method="POST">
        <input type="hidden" id="Tab_hidden_project_name" name="project_name"/>
        <input type="hidden" id="Tab_hidden_scene" name="scene"/>
        <input type="hidden" id="Tab_hidden_recordtime" name="recordtime"/>
        <input type="hidden" id="Tab_hidden_original_content" name="original_content"/>
            <li>
            <p class="Tab_infoText">・「お誕生日、おめでとう。」の一言のみを届ける、シンプルなプロジェクトです。<br>・録音５秒以内/人</p>
            <input type="text" name="" class="Tab_input" data-scene="1" placeholder="プロジェクト名" maxlength="32" required />
            <button class="Tab_button" data-scene="1" data-recordtime="5">作成</button>
            </li>
            <li class="Tab_hide">
            <p class="Tab_infoText">・みんなの応援の言葉を届けよう<br>・録音８秒以内/人</p>
            <input type="text" name="" class="Tab_input" data-scene="2" placeholder="プロジェクト名" maxlength="32" required/>
            <button class="Tab_button" data-scene="2" data-recordtime="8">作成</button>
            </li>
            <li class="Tab_hide">
            <p class="Tab_infoText">・みんなの言葉を届けよう<br>・録音１５秒以内/人</p>
            <input type="text" name="" class="Tab_input" data-scene="3" placeholder="プロジェクト名" maxlength="32" required />
            <button class="Tab_button" data-scene="3" data-recordtime="15">作成</button>
            </li>
            <li class="Tab_hide">
            <p class="Tab_infoText">・録音
            
                <select name="select_recordtime" id="select_recordtime">
                    <option value="unselected">未選択</option>
                    <?php for($i=1;$i<=60;$i++):?>
                    <option value="<?php echo $i;?>"><?php echo $i;?>秒</option>
                    <?php endfor;?>
                </select>
            
            秒/人<br>
            ・録音して欲しい内容<br>
            <input type="text" id="original_content" style="color: #F66D5D;border: #F66D5D solid 2px;line-height: 22px;font-size: 16px;" 
            	class="Tab_input" placeholder="例：田中への感謝の言葉" maxlength="32" required/><br>
            
            </p>
            <input type="text" name="" class="Tab_input" data-scene="10" placeholder="プロジェクト名" maxlength="32"required />
            <button class="Tab_button" data-scene="10">作成</button>
            </li>
        </form>
        </ul>
	</div>
    <ul class="Lists">
    <p class="Lists_title">プロジェクト一覧</p>

    <?php foreach($projects as $project):?>
        <li class="List"><span class="List_status"><?php echo $scene[$project['scene']];?><i class="fa <?php echo $icons[$project['status']];?> icon_status"></i></span><a href="mypage/<?php echo $project['id'];?>"><?php echo $project['name'];?></a></li>
    <?php endforeach;?>
    </ul>
    <div class="Reference_icon"><?php $a = '<i class="fa '; $b = '"></i>';?>
    	<?php echo $a.$icons[1].$b.":編集中 ".$a.$icons[2].$b.":実行待ち ".$a.$icons[3].$b.":実行中 ".$a.$icons[4].$b.":エラー ".$a.$icons[5].$b.":完了";?>
    </div>
<?php $content = ob_get_clean();?>
<?php include 'layout.php';?>