<?php 
	class Project extends ModelBase{
		private $id;
		protected $table_name = 'MA10_projects';
		
		
		public function __construct($id = null){
			if($id != null){
				$this->id = $id;
			}
			parent::__construct();
		}
		
		public function get_id(){
			return $this->id;	
		}
		public function set_id($id){
			$this->id = $id;	
		}
		
/* ------- GET DATA --------- */

		public function get_projects($member_id){
			$sql = sprintf('select * from %s WHERE member_id=:id ORDER BY id DESC',$this->table_name);
			$stmt = $this->db->prepare($sql);
			$stmt -> bindValue(":id",$member_id, PDO::PARAM_STR);
			$stmt -> execute();
			$return = $stmt -> fetchAll();
			return $return;
		}
		
		public function get_projectDetail(){
			$params = array("id"=>$this->id);
			$return = $this->select("*",$params);
			return $return[0];
		}
		public function get_voices(){
			$stmt = $this->db->prepare("SELECT * FROM MA10_voices WHERE project_id=:project_id");
			$stmt -> bindValue(":project_id",$this->id, PDO::PARAM_INT);
			$stmt -> execute();
			$return = $stmt -> fetchAll();
			//並び替え voice_order
			$order = $this->get_voice_order($this->id);
			if($order){ // 順番が記録されている場合のみ
				$order_serialize = unserialize($order);
				return $this->sort_by_baseArray($return,$order_serialize);
			}
			return $return;
		}
		public function is_ownProject($member_id){
			$sql = sprintf('select * from %s WHERE member_id=:member_id AND id=:id ORDER BY id DESC',$this->table_name);
			$stmt = $this->db->prepare($sql);
			$stmt -> bindValue(":member_id",$member_id, PDO::PARAM_STR);
			$stmt -> bindValue(":id",$this->id, PDO::PARAM_STR);
			$stmt -> execute();
			$return = $stmt -> fetch();
			if($return){
				return true;
			}else{return false;}
		}
		public function get_target_idWithMember($member_id){
			$params = array("member_id"=>$member_id);
			$return = $this->select("id,target_id",$params);
			return $return;
		}
		
/* ------- SET DATA --------- */

		public function set_voice_order($result_serialize){
			
			$sql = sprintf("UPDATE %s SET voice_order=:result_serialize  WHERE id=:id",$this->table_name);
			$stmt = $this->db->prepare($sql);
			$stmt -> bindValue(':result_serialize', $result_serialize, PDO::PARAM_STR);
			$stmt -> bindValue(':id', $this->id, PDO::PARAM_INT);
			$stmt -> execute();
		}
		
		public function queue($send_time,$target_id){
			
			$sql = sprintf("UPDATE %s SET send_time=:send_time,target_id=:target_id  WHERE id=:id",$this->table_name);
			$stmt = $this->db->prepare($sql);
			$stmt -> bindValue(':send_time', $send_time, PDO::PARAM_STR);
			$stmt -> bindValue(':target_id', $target_id, PDO::PARAM_STR);
			$stmt -> bindValue(':id', $this->id, PDO::PARAM_INT);
			$return = $stmt -> execute();
			
			$this->change_status(2);// 実行待ち
			return $return;
		}
		public function create_project($member_id,$pName,$scene,$recordtime){
			
			$pin = $this->create_pin();
			$sql = sprintf("INSERT INTO %s (name,member_id,pin,scene,recordtime,created) 
			VALUES (:pName,:member_id,:pin,:scene,:recordtime,NOW())",$this->table_name);
			$stmt = $this->db->prepare($sql);
			$stmt -> bindValue(':pName', $pName, PDO::PARAM_STR);
			$stmt -> bindValue(':member_id', $member_id, PDO::PARAM_INT);
			$stmt -> bindValue(':pin', $pin, PDO::PARAM_INT);
			$stmt -> bindValue(':scene', $scene, PDO::PARAM_INT);
			$stmt -> bindValue(':recordtime', $recordtime, PDO::PARAM_INT);
			$stmt -> execute();
			// project_id 取得　（autoIncreamentなので）
			$stmt = $this->db->query("SELECT LAST_INSERT_ID()");
			$result = $stmt -> fetch(PDO::FETCH_ASSOC);
			$project_id = $result['LAST_INSERT_ID()'];
			return array($pin,$project_id);
		}
		
		public function create_projectWithAnnounce($member_id,$pName,$scene,$recordtime,$original_content){
			
			$pin = $this->create_pin();
			$sql = sprintf("INSERT INTO %s (name,member_id,pin,scene,original_content,recordtime,created) 
			VALUES (:pName,:member_id,:pin,:scene,:original_content,:recordtime,NOW())",$this->table_name);
			$stmt = $this->db->prepare($sql);
			$stmt -> bindValue(':pName', $pName, PDO::PARAM_STR);
			$stmt -> bindValue(':member_id', $member_id, PDO::PARAM_INT);
			$stmt -> bindValue(':pin', $pin, PDO::PARAM_INT);
			$stmt -> bindValue(':scene', $scene, PDO::PARAM_INT);
			$stmt -> bindValue(':original_content', $original_content, PDO::PARAM_STR);
			$stmt -> bindValue(':recordtime', $recordtime, PDO::PARAM_INT);
			$stmt -> execute();
			// project_id 取得　（autoIncreamentなので）
			$stmt = $this->db->query("SELECT LAST_INSERT_ID()");
			$result = $stmt -> fetch(PDO::FETCH_ASSOC);
			$project_id = $result['LAST_INSERT_ID()'];
			return array($pin,$project_id);
		}
		
		public function set_comp_voice($comp_voice,$playtime){
			$sql = sprintf("UPDATE %s SET comp_voice=:comp_voice,
			playtime=:playtime WHERE id=:project_id",$this->table_name);
			$stmt = $this->db -> prepare($sql);
			$stmt -> bindValue(":comp_voice",$comp_voice, PDO::PARAM_STR);
			$stmt -> bindValue(":playtime",$playtime, PDO::PARAM_INT);
			$stmt -> bindValue(":project_id",$this->id, PDO::PARAM_INT);
			$stmt -> execute();
		}
		
		//ステータス
		public function change_status($status){
			$sql = sprintf("UPDATE %s SET status=:status WHERE id=:project_id",$this->table_name);
			$stmt = $this->db->prepare($sql);
			$stmt -> bindValue(":status",$status, PDO::PARAM_INT);
			$stmt -> bindValue(":project_id",$this->id, PDO::PARAM_INT);
			$stmt -> execute();
		}
/* ------- DELETE DATA --------- */
		public function delete_project(){
			$params = array("id"=>$this->id);
			$this->delete($params);			
		}
		public function delete_projectWithMember($member_id){
			$params = array("member_id"=>$member_id);
			$this->delete($params);			
		}
		
		
		
/* ------- private --------- */
		
		// get_voices
		private function get_voice_order(){
			
			$sql = sprintf("SELECT voice_order FROM %s WHERE id=:id",$this->table_name);
			$stmt = $this->db -> prepare($sql);
			$stmt -> bindValue(":id",$this->id, PDO::PARAM_INT);
			$stmt -> execute();
			$result = $stmt -> fetch(PDO::FETCH_ASSOC);
			$stmt->closeCursor();
			return $result['voice_order'];
		}
		
		// voiceの順番をbaseArrayに入ってるidで並び替える
		private function sort_by_baseArray($array,$baseArray){
			
			$a = array();
			for($i=0;$i<count($baseArray);$i++){
				for($j=0;$j<count($array);$j++){
					if($baseArray[$i]==$array[$j]['id']){ // 同じだったら
						$a[] = $array[$j];//入れる
						array_splice($array,$j,1); // 消す
						break;
					}
				}
			}
			for($i=0;$i<count($array);$i++){ // 残ったやつ(新しく録音されたやつ)
				$a[] = $array[$i];
			}
			return $a;
			
		}
		
		// pin作成
		private function create_pin(){
			$flag = true;
			$pin = 0;
			while($flag){
				$pin = rand(10000,99999);
				$sql = sprintf("SELECT COUNT(*) AS cnt FROM %s WHERE pin=:pin",$this->table_name);
				$stmt = $this->db->prepare($sql);
				$stmt -> bindValue(':pin', $pin, PDO::PARAM_INT);
				$stmt -> execute();
				$table = $stmt -> fetch(PDO::FETCH_ASSOC);
				if($table['cnt'] ==0){$flag = false;}
			}
			return $pin;
		}
		
/* ------- tel --------- */
		public function get_projectDetailByPin($pin){
			$params = array("pin"=>$pin);
			$return = $this->select("*",$params);
			return $return[0];
		}
		public function checkProjectTobeExecuted(){
			
			$sql = 'SELECT t.phone, p.id  FROM MA10_projects p, MA10_targets t WHERE p.status=2 AND p.send_time<=NOW() AND p.target_id=t.id';
			$stmt = $this->db->query($sql);
			$return = $stmt -> fetchAll();
			return $return;

		}
		public function get_who_called(){
			$sql = 'SELECT m.name AS fromName, p.comp_voice  FROM MA10_projects p, MA10_members m 
				WHERE p.member_id=m.id AND p.id=:id';
			$stmt = $this->db->prepare($sql);
			$stmt -> bindValue(':id', $this->id, PDO::PARAM_INT);
			$stmt -> execute();
			$return = $stmt -> fetch();
			return $return;
		}
	}
?>