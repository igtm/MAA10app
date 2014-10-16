<?php
class Member extends ModelBase{
		private $id;
		protected $table_name = 'MA10_members';
		
		
		public function __construct($id = null){
			if($id != null){
				$this->id = $id;
			}
			parent::__construct();
		}
		public function get_member(){
			$sql = sprintf("select * from '%s' where id=:id",$this->table_name);
			$stmt = $this->db->prepare($sql);
			$stmt -> bindValue(':id', $this->id, PDO::PARAM_INT);
			$stmt -> execute();
			$return = $stmt -> fetch(PDO::FETCH_ASSOC);
			return $return;
		}

}
?>