<?php 
require dirname(__FILE__).'/../app/models/model.php';
			$Voice = new Voice();
			list($scene,$recordtime) = $Voice->get_setting("CAd943d93905e0963ca1bcf0d446cc7a8c");
var_dump((int)$scene);
var_dump((int)$recordtime);
?>