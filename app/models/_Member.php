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
			return $this->insert($params);
		}
		public function isNewUserName($userName){
			$params = array("username"=>$userName);
			$return = $this->select("*",$params);
			if(!empty($return)){return true;}else{return false;}
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
}
?>