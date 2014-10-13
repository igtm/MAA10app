<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,height=device-height,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
<link rel="stylesheet" type="text/css" href="/API/MAA10app/app/styles/style.css">
<link rel="stylesheet" type="text/css" href="/API/MAA10app/app/styles/font-awesome.min.css">

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