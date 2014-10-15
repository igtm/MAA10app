    	<div class="Tutorial">
            <div class="Tutorial_title">プロジェクトが作成されました！</div>
            <div class="Tutorial_box">
				まずはみんなの声を集めましょう。以下の文章は一例です。コピペして使用して下さい。
                <hr>
				<div class="Tutorial_sentence">
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
                １：【05031717110】に電話<br>
                ２：PINコード【<?php echo h($_GET['pin']);?>】を入力<br>
                ３：【10秒以内で】あなたの名前とメッセージを録音！<br><br>
                </div>
            </div>
        </div>
