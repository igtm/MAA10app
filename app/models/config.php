<?php 
define("ACCOUNT_SID","AC1a5cb11fc93ebd4c8df75d7b056e62bb");
define("AUTH_TOKEN","055a390ab99c2db1e2876ee486986cf6");
define('TEL_FROM','+81-50-3171-7110');
define('HOST','mysql572.phy.lolipop.jp');
define('DB_NAME','LAA0350474-3tnmww');
define('USER_NAME','LAA0350474');
define('PASSWORD','2x2jycy9');

define('DSN','mysql:dbname='.DB_NAME.';host='.HOST.';charset=utf8');
define('DSN_DB','mysql://'.USER_NAME.':'.PASSWORD.'@'.HOST.'/'.DB_NAME);
define('VOICE_URL','http://api.twilio.com/2010-04-01/Accounts/'.ACCOUNT_SID.'/Recordings/');
?>