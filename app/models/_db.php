<?php 
function get_pdo(){
	try {
		$pdo = new PDO(DSN,USER_NAME,PASSWORD,
					array(PDO::ATTR_EMULATE_PREPARES => false,
					PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
		$pdo->query("SET NAMES utf8");
		return $pdo;
	} catch (PDOException $e) {
		exit('データベース接続失敗。'.$e->getMessage());
	}
}


?>