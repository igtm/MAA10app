<?php 
class ModelBase{
	protected $db;
	protected $table_name;
	
	public function __construct(){
		$this->initDB();	
	}
	
	public function initDB(){
		$pdo = new PDO(DSN,USER_NAME,PASSWORD,
					array(PDO::ATTR_EMULATE_PREPARES => false,
					PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
		$pdo->query("SET NAMES utf8");
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$this->db = $pdo;
	}
}
?>