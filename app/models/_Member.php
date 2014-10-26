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
		public function addMember($params){
			
			$this->insert($params);
			// id 取得　（autoIncreamentなので）
			$stmt = $this->db->query("SELECT LAST_INSERT_ID()");
			$result = $stmt -> fetch(PDO::FETCH_ASSOC);
			$id = $result['LAST_INSERT_ID()'];
			
			//ログイン
			$_SESSION['MA10_id'] = $id;
			$_SESSION['MA10_time'] = time();


		}
		public function isNewUserName($userName){
			$params = array("username"=>$userName);
			$return = $this->select("*",$params);
			if(empty($return)){return true;}else{return false;}
		}
		public function isNewEmail($email){
			$params = array("email"=>$email);
			$return = $this->select("*",$params);
			if(empty($return)){return true;}else{return false;}
		}
		public function login ($username,$password){
			$params = array("username"=>$username,'password'=>$password);
			$return = $this->select("*",$params);
			if(!empty($return)){	
				//ログイン成功
				$_SESSION['MA10_id'] = $return[0]['id'];
				$_SESSION['MA10_time'] = time();
				return true;
			}else{
				$_SESSION = array();
				session_destroy();
				return false;
			}
		}
		public function getMember(){
			$params = array("id"=>$this->id);
			$return = $this->select("*",$params);
			return $return[0];
		}
		public function is_member(){
			$params = array("id"=>$this->id);
			$return = $this->select("*",$params);
			if(!empty($return)){return true;}else{return false;}
		}
/* ------- DELETE DATA --------- */
		public function delete_member(){
			$params = array("id"=>$this->id);
			$this->delete($params);			
		}
}
?>