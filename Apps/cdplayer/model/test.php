<?php
	
	namespace Apps\test\model;

	use \CliqsStudio\model\CQS_Model;
	use \CliqsStudio\service\CQS_Database;
	use \CliqsStudio\service\CQS_BuildQuery;
	use \CliqsStudio\config\CQS_Config;
	use \CliqsStudio\service\CQS_Security;
	use \CliqsStudio\service\CQS_Session;
	use \CliqsStudio\service\CQS_Mailer;
	use \CliqsStudio\service\CQS_Redirect;

		
	use Apps\test\config\config as config;
	
	class test extends CQS_Model{

		private $con_handle_details_to_general_users = null;

		public $CQSPath = null;

		public function __construct(){

			$parent = new parent;
			$cfg = new config;


			$this->con_handle_details_to_general_users = ['database'=>$cfg::$DB_NAME];
			$this->CQSUserPath	=	$parent->CQSUserPath;
		
		}

		

	} 

?>