<?php	
header("Content-type: text/html; charset=utf-8");?>
<?php session_start();?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,height=device-height,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
<link rel="stylesheet" type="text/css" href="style.css">
<title><?php echo $title;?></title>
</head>
<body>
	<header>
    	<ul class="Nav">
        	<li class="Nav_item"><a href="./">Homeロゴ</a></li>
			<?php if($isLogin){?>
                <li class="Nav_item Nav_item-right"><?php echo $_SESSION['name'];?>さん</li>
                <li class="Nav_item Nav_item-right"><a href="logout">Log out</a></li>
            <?php }else{?>
                <li class="Nav_item Nav_item-right"><a href="login">ログイン</a></li>
                <li class="Nav_item Nav_item-right"><a href="signup">サインアップ</a></li>
            <?php }?>
        </ul>
    </header>
	<div class="Container">
		<?php echo $content;?>
	</div>
</body>
</html>