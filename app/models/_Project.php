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
		
		public function get_projectDetail(){
			$sql = sprintf("SELECT *,p.id,p.name AS project_name, t.name AS target_name FROM '%s' p,MA10_targets t WHERE p.id=:id AND p.target_id=t.id",$this->table_name);
			$stmt = $this->$db -> prepare($sql);
			$stmt -> bindValue(":id",$this->id, PDO::PARAM_INT);
			$stmt -> execute();
			$return = $stmt -> fetch(PDO::FETCH_ASSOC);
			return $return;
		}
		public function get_voice_order(){
			$sql = sprintf("SELECT voice_order FROM '%s' WHERE id=:id",$this->table_name);
			$stmt = $this->$db -> prepare($sql);
			$stmt -> bindValue(":id",$this->id, PDO::PARAM_INT);
			$stmt -> execute();
			$result = $stmt -> fetch(PDO::FETCH_ASSOC);
			$stmt->closeCursor();
			return $result['voice_order'];
		}
		
		public function set_voice_order($result_serialize){
			$sql = sprintf("UPDATE '%s' SET voice_order=:result_serialize  WHERE id=:id",$this->table_name);
			$stmt = $pdo->prepare($sql);
			$stmt -> bindValue(':result_serialize', $result_serialize, PDO::PARAM_STR);
			$stmt -> bindValue(':id', $this->id, PDO::PARAM_INT);
			$stmt -> execute();
		}
		public function set_send_time($send_time){
						$sql = sprintf("UPDATE '%s' SET send_time=:send_time  WHERE id=:id",$this->table_name);
			$stmt = $pdo->prepare($sql);
			$stmt -> bindValue(':send_time', $send_time, PDO::PARAM_STR);
			$stmt -> bindValue(':id', $this->id, PDO::PARAM_INT);
			$stmt -> execute();
		}
	}
?>