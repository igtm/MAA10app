    	<div class="Tutorial">
            <div class="Tutorial_title"></div>
            <div class="Tutorial_box">
            	<p style="color:#1abc9c">プロジェクトが作成されました！</p>
				まずはみんなの声を集めましょう。以下の文章は一例です。コピペして使用して下さい。
                <hr>
				<div class="Tutorial_sentence">
                【<?php echo h(urldecode($_GET['project_name']));?>】<br>
                このサービスは「電話でみんなの声を集める」サービスです。<br>
                皆さんの【<?php echo h(urldecode($_GET['original_content']));?>】をつなぎあわせ、大切な人へ送ります。<br>
                ーーーーーーーーーー<br>
                編集者：<?php echo $member_name;?>さん<br>
                ーーーーーーーーーー<br>
                協力して頂けるみなさんへ（１分程度）<br>
                １：【05031717110】に電話<br>
                ２：PINコード【<?php echo h($_GET['pin']);?>】を入力<br>
                ３：【<?php echo h($_GET['recordtime']);?>秒以内で】あなたの名前と【<?php echo h(urldecode($_GET['original_content']));?>】を録音！<br><br>
                
                <br />
                ----------------<br />
                Voice Hub<br />
                〜電話で簡単に声を集められるサイト〜<br />
                <?php echo ROOT_DIR.'app/';?><br />
                </div>
            </div>
        </div>
