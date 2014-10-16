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

}
?>