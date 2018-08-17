<?php
	
	namespace CliqsStudio\model;

	use \CliqsStudio\service\CQS_Database;
	use \CliqsStudio\config\CQS_Config;

	class CQS_Model extends CQS_Config{

		private $con_handle_details = ['database'=>'cliqsstudio_db'];
		
		public $CQSUserPath = null;
		public $CQSAbsPath = null;
		public $CQSPath = null;

		public function __construct(){

			$parent = new parent;

			$this->CQSPath		=	$parent->CQSPath;
			$this->CQSUserPath	=	$parent->CQSUserPath;
			$this->CQSAbsPath	=	$parent->CQSAbsUserPath;
		
		}

		public function connect($con_handle_details = []){
			
			$parent = new parent;

			if (sizeof($con_handle_details) != 0) {
				$this->con_handle_details = $con_handle_details;
			}

			$connectionStack 	=	new CQS_Database();
			$StackResource		=	$connectionStack->addConnection($this->con_handle_details);
			$StackResource		=	[$StackResource,$connectionStack->ConStatus];
			

			return $StackResource;

		}


	}
?>
