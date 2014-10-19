<?php
class Target extends ModelBase{
		private $id;
		protected $table_name = 'MA10_targets';
		
		
		public function __construct($id = null){
			parent::__construct();

			if($id != null){
				$this->id = $id;
			}
		}
		public function create_target($phone){
			$sql = sprintf("INSERT INTO %s (phone,created) VALUES (:phone,NOW())",$this->table_name);
			$stmt = $this->db->prepare($sql);
			$stmt -> bindValue(':phone', $phone, PDO::PARAM_STR);
			$stmt -> execute();
			
			// target_id 取得　（autoIncreamentなので）
			$stmt = $this->db->query("SELECT LAST_INSERT_ID()");
			$result = $stmt -> fetch(PDO::FETCH_ASSOC);
			$target_id = $result['LAST_INSERT_ID()'];
			return $target_id;
		}
}
?>