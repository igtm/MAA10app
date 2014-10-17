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
}
?>