<?php
class Target extends ModelBase{
		private $id;
		protected $table_name = 'MA10_targets';
		
		
		public function __construct($id = null){
			if($id != null){
				$this->id = $id;
			}
			parent::__construct();
		}
		public function create_target(){
			$sql = spritf("INSERT INTO '%s' (name,phone,created) VALUES (:tName,:phone,NOW())",$this->table_name);
			$stmt = $this->db->prepare($sql);
			$stmt -> bindValue(':tName', $tName, PDO::PARAM_STR);
			$stmt -> bindValue(':phone', $phone, PDO::PARAM_STR);
			$stmt -> execute();
			
			// target_id 取得　（autoIncreamentなので）
			$stmt = $this->db->query("SELECT LAST_INSERT_ID()");
			$result = $stmt -> fetch(PDO::FETCH_ASSOC);
			$target_id = $result['LAST_INSERT_ID()'];
			return $target_id;
		}
		public function get_targetName(){
			$sql = sprintf("SELECT name FROM '%s' WHERE id=:id",$this->table_name);
			$stmt = $this->db-> prepare($sql);
			$stmt -> bindValue(":id",$this->id, PDO::PARAM_INT);
			$stmt -> execute();
			$return = $stmt -> fetch(PDO::FETCH_ASSOC);
			return $return['name'];
		}

}
?>