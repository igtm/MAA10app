<?php 
	class Project extends ModelBase{
		private $id;
		protected $table_name = 'MA10_projects';
		
		
		public function __construct($id){
			parent::__construct();
			$this->id = $id;
		}
		
		public function get_id(){
			return $this->id;	
		}
		public function get_projects($member_id){
			$sql = sprintf('select * from "%s" WHERE member_id=:id ORDER BY id DESC',$this->table_name);
			$stmt = $this->$db->prepare($sql);
			$stmt -> bindValue(":id",$member_id, PDO::PARAM_INT);
			$stmt -> execute();
			$return = $stmt -> fetchAll();
			return $return;
		}
		
	}
?>