<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width,height=device-height,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
<link rel="stylesheet" type="text/css" href="/API/MAA10app/app/styles/style.css">
<link rel="stylesheet" type="text/css" href="/API/MAA10app/app/styles/font-awesome.min.css">
<link type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/flick/jquery-ui.css" rel="stylesheet" />
<script type="text/javascript"
  src="http://code.jquery.com/jquery-1.7.2.min.js"></script>
<script type="text/javascript"
  src="http://code.jquery.com/ui/1.8.21/jquery-ui.min.js"></script>
<script type="text/javascript"
  src="/API/MAA10app/app/styles/jquery.ui.touch-punch.min.js"></script>
<script type="text/javascript">
$(function() {
  $('.Voices_lists').sortable({ change : function( evt, ui ) { 
  		console.log("change");
		$("#submit-modify").removeAttr("disabled");
		$("#submit-execute").attr("disabled","disabled");
		}});
  $("#submit-modify").click(function() {
	  // animation
	  $(this).css({"transform":"none","-moz-transform":"none","-webkit-transform":"none"});
	  $(this).css({"box-shadow":"none","-moz-box-shadow":"none","-webkit-box-shadow":"none"});
	  var result = $(".Voices_lists").sortable("toArray");
	  $("#result_modify").val(result);
	  $("form").submit();
  });
  /* ------- ダイアログボックス ----------- */
  var dialogW = 450;
  var windowW = $(window).width();
  var configW = 500;
  if(windowW < configW){
	  dialogW = windowW * 0.9;
  }
   	$("#dialog").dialog({
		autoOpen: false,
		modal: true	,
		width: dialogW,
		resizable: false
	});
	
	$("#datetime").change(function() {
		$("#dialog-execute").removeAttr("disabled");
    });
	$("#phone").keypress(function() {
		$("#dialog-execute").removeAttr("disabled");
    });
	$("#dialog-complete").click(function() {
		if(confirm("プロジェクトを完了しますか。結合音声は保存されますが、個別の音声は削除され、これ以上の録音は受け付けません。")){
			$("#Loading").show();
			$("#dialog").dialog('close');
			
			$.ajax({
			  type:"POST",
			  dataType:"json",
			  url:"<?php echo ROOT_DIR."async/complete.php";?>",
			  data:{member_id:<?php echo h($_SESSION['MA10_id']);?>,
					project_id:<?php echo h($project['id']);?>}
			  }).done(function(data, status, xhr) {
				// 通信成功時の処理
				$("#Loading").hide();

				if(data['status']){
					// mypageへ遷移！
					location.href = "<?php echo ROOT_DIR;?>app/mypage?complete=true";
				}else{
					alert(data['error']);
				}
			  }).fail(function(xhr, status, error) {
				 // 通信失敗時の処理
				  $("#Loading").hide();

			  }).always(function(arg1, status, arg2) {
				// 通信完了時の処理
			  });
		}
	});
	$("#dialog-execute").click(function() {
		var send_time = $("#datetime").val();
		var phone = $("#phone").val();
		if(send_time && phone){
		if(confirm("指定された番号に、指定時刻に入電します。")){
			$("#Loading").show();
			$("#dialog").dialog('close');
				  $.ajax({
			  type:"POST",
			  dataType:"json",
			  url:"<?php echo ROOT_DIR."async/queue.php";?>",
			  data:{member_id:<?php echo h($_SESSION['MA10_id']);?>,
					project_id:<?php echo h($project['id']);?>,
					send_time:send_time,
					phone:phone}
			  }).done(function(data, status, xhr) {
				// 通信成功時の処理
				$("#Loading").hide();
				if(data['status']){
					// mypageへ遷移！
					location.href = "<?php echo ROOT_DIR;?>app/mypage?execute=true";
				}else{
					alert(data['error']);
				}
			  }).fail(function(xhr, status, error) {
				 // 通信失敗時の処理
				  $("#Loading").hide();

			  }).always(function(arg1, status, arg2) {
				// 通信完了時の処理
			  });
		  
		}
		}else{
			alert("値が入力されていません。");	
		}

    });

  /* ------- 結合！ ----------- */

  $("#submit-execute").click(function(e) {
	  //e.preventDefault();
	  if(confirm("音声結合しますか？※通信状態が良い場所で行って下さい")){
	  // animation
	  $("#Loading").show();
	  $("#submit-execute").attr("disabled","disabled");
	  $(this).css({"transform":"none","-moz-transform":"none","-webkit-transform":"none"});
	  $(this).css({"box-shadow":"none","-moz-box-shadow":"none","-webkit-box-shadow":"none"});
	  $.ajax({
		  type:"POST",
		  dataType:"json",
		  url:"<?php echo ROOT_DIR."async/combine.php";?>",
		  data:{member_id:<?php echo h($_SESSION['MA10_id']);?>,
		  		project_id:<?php echo h($project['id']);?>}
	  	  }).done(function(data, status, xhr) {
 			// 通信成功時の処理
			$("#Loading").hide();

			if(data['status']){
				$(".Dialog_left a").attr("href",data["comp_voice"]);
				$('#dialog').dialog('open');
			}else{
				alert(data['error']);
			}
			//alert("成功");
			//alert(data);
			//alert(status);
			//alert(xhr);
		  }).fail(function(xhr, status, error) {
			 // 通信失敗時の処理
	 	  $("#Loading").hide();
			alert("失敗");
			alert(xhr);
			alert(status);
			alert(error);
		  }).always(function(arg1, status, arg2) {
			// 通信完了時の処理
		  });
		
	  }
  });

  
  /* -------Tab----------- */
   //クリックしたときのファンクションをまとめて指定
    $('.Tab_block li').click(function() {
        //.index()を使いクリックされたタブが何番目かを調べ、
        //indexという変数に代入します。
        var index = $('.Tab_block li').index(this);
        //コンテンツを一度すべて非表示にし、
        $('.Tab_content li').css('display','none');
        //クリックされたタブと同じ順番のコンテンツを表示します。
        $('.Tab_content li').eq(index).css('display','block');
        //一度タブについているクラスselectを消し、
        $('.Tab_block li').removeClass('Tab_select');
        //クリックされたタブのみにクラスselectをつけます。
        $(this).addClass('Tab_select')
		
	});
  /* ------- Tab form ----------- */
  // POST: project_name , scene , recordtime, (original_content)
    $('.Tab_button').click(function(e) {
		e.preventDefault();
		var scene = $(this).attr("data-scene");
		var project_name = $(".Tab_input[data-scene="+scene+"]").val();
		if(project_name == ''){alert("プロジェクト名が記入されていません。");
		return ;}
		if(scene == 10){
			if($("#select_recordtime").val() == 'unselected'){
				alert("プロジェクト名が記入されていません。");
				return;	
			}
			var recordtime = $("#select_recordtime").val();
			if($("#original_content").val() == ''){
				alert("録音して欲しい内容が記入されていません。");
				return;	
			}
			var original_content = $("#original_content").val();
		}else{
			var recordtime = $(this).attr("data-recordtime");
		}
		$("#Tab_hidden_project_name").val(project_name);
		$("#Tab_hidden_scene").val(scene);
		$("#Tab_hidden_recordtime").val(recordtime);
		if(scene == 10){$("#Tab_hidden_original_content").val(original_content);}
	    $("form").submit();
	});
	  // enterの無効化
	    $(document).on("keypress", ".Tab_input", function(event) {
		    return event.which !== 13;
		});
  
});
</script>
<title><?php echo $title;?></title>
</head>
<body>
	<header>
    	<ul class="Nav">
        	<li class="Nav_item"><a href="/API/MAA10app/app">Home</a></li>
			<?php if($isLogin){?>
                <li class="Nav_item Nav_item-right"><a href="/API/MAA10app/app/logout">Log out</a></li>
                <li class="Nav_item Nav_item-right"><a href="/API/MAA10app/app/account"><?php echo $member_name;?>さん</a></li>
            <?php }else{?>
                <li class="Nav_item Nav_item-right"><a href="/API/MAA10app/app/login">ログイン</a></li>
                <li class="Nav_item Nav_item-right"><a href="/API/MAA10app/app/signup">サインアップ</a></li>
            <?php }?>
        </ul>
    </header>
	<div class="Container">
		<?php echo $content;?>
	</div>
    <div id="Loading" style="display:none;">
    	<div id="Loading_mask"></div>
        <span id="Loading_icon"><i class="fa fa-spinner fa-spin"></i></span>
    </div>
</body>
</html>