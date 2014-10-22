<?php 
	class Voice extends ModelBase{
		private $id;
		protected $table_name = 'MA10_voices';
		
		
		public function __construct($id = null){
			if($id != null){
				$this->id = $id;
			}
			parent::__construct();
		}
/* ------- GET DATA --------- */
		public function get_id(){
			return $this->id;	
		}
		public function get_voice($CallSid){
			$params = array("CallSid"=>$CallSid);
			$return = $this->select("voice",$params);
			return $return[0];
		}
		public function get_voices($project_id){
			$params = array("project_id"=>$project_id);
			$return = $this->select("voice",$params);
			return $return;
		}
		public function get_setting($CallSid){
			$sql = "SELECT p.scene,p.recordtime FROM MA10_voices v,MA10_projects p WHERE p.id=v.project_id AND v.CallSid=:CallSid";
			$stmt = $this->db->prepare($sql);
			$stmt -> bindValue(":CallSid",$CallSid, PDO::PARAM_INT);
			$stmt -> execute();
			$return = $stmt -> fetch();
			return array((int)$return['scene'],(int)$return['recordtime']);
		}
		
/* ------- SET DATA --------- */
		public function before_record($project_id,$CallSid) {
			$params = array("project_id"=>$project_id, "CallSid"=>$CallSid,"created"=>"NOW()");
			$this->insert($params);
		}
		public function after_record($RecordingSid,$CallSid){
			$sql = sprintf("UPDATE %s SET voice=:voice, created=NOW() WHERE CallSid=:CallSid",$this->table_name);
			$stmt = $this->db -> prepare($sql);
			$stmt -> bindValue(":voice",$RecordingSid, PDO::PARAM_INT);
			$stmt -> bindValue(":CallSid",$CallSid, PDO::PARAM_INT);
			$stmt -> execute();
		}
		
/* ------- DELETE DATA --------- */
		public function delete_voice($CallSid){
			$params = array("CallSid"=>$CallSid);
			$this->delete($params);
		}
		public function delete_onlyVoiceColumn($CallSid){
			$sql = sprintf("UPDATE %s SET voice='' WHERE CallSid=:CallSid",$this->table_name);
			$stmt = $this->db -> prepare($sql);
			$stmt -> bindValue(":CallSid",$CallSid, PDO::PARAM_INT);
			$stmt -> execute();
		}
		public function delete_voices($project_id){
			$params = array("project_id"=>$project_id);
			$return = $this->delete($params);
			return $return;
		}
		
	}
?>