<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width,height=device-height,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
<link rel="stylesheet" type="text/css" href="/API/MAA10app/app/styles/style.css">
<link rel="stylesheet" type="text/css" href="/API/MAA10app/app/styles/font-awesome.min.css">
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
  	  $("#result_datetime").val($("#datetime").val().replace("T", " "));
	  $("form").submit();
  });
  $("#submit-execute").click(function() {
	  // animation
	  $(this).css({"transform":"none","-moz-transform":"none","-webkit-transform":"none"});
	  $(this).css({"box-shadow":"none","-moz-box-shadow":"none","-webkit-box-shadow":"none"});

	  alert("まだできてへんねん、、");
  });
  $("#datetime").change(function() {
		$("#submit-modify").removeAttr("disabled");
		$("#submit-execute").attr("disabled","disabled");

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
                <li class="Nav_item Nav_item-right"><a href="/API/MAA10app/app/account"><?php echo $authPear->getUsername();?>さん</a></li>
            <?php }else{?>
                <li class="Nav_item Nav_item-right"><a href="/API/MAA10app/app/login">ログイン</a></li>
                <li class="Nav_item Nav_item-right"><a href="/API/MAA10app/app/signup">サインアップ</a></li>
            <?php }?>
        </ul>
    </header>
	<div class="Container">
		<?php echo $content;?>
	</div>
</body>
</html>