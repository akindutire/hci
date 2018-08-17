<?php
	
	namespace Apps\alarm\controller;
	
	use \CliqsStudio\controller\CQS_Controller;
	use \CliqsStudio\service\CQS_Database;
	use \CliqsStudio\service\CQS_BuildQuery;
	use \CliqsStudio\service\CQS_Logger;
	use \CliqsStudio\service\CQS_Session;
	use \CliqsStudio\service\CQS_Sanitize;
	use \CliqsStudio\service\CQS_Security;
	use \CliqsStudio\service\CQS_Mailer;
	use \CliqsStudio\service\CQS_Login;
	use \CliqsStudio\service\CQS_Logout;
	use \CliqsStudio\service\CQS_Redirect;
	
	
	use Apps\alarm\config\config;
	use Apps\alarm\model\alarm as alarm_model;

	class home extends CQS_Controller{

		
		public $AbsPath = null;
		public $CQSUserPath = null;
		

		public function __construct(){

			$parent = new parent;
			$cfg = new config;

			$this->CQSUserPath	=	$parent->CQSUserPath;
			$this->AbsPath	=	$cfg::$APP_ABSPATH;
			

		}

		public function index(){

			$cfg = new config;

			$alarm_model = new alarm_model;
			
			$days = $alarm_model->get_days();
			$alarm_list = $alarm_model->get_alarm_list();
			
			$Outputdata = [$this->AbsPath,'view/asset/img/icon.jpg',$cfg::$APP_ROOTPATH,$days,$alarm_list];

			parent::View('start/home.php',$Outputdata);


		}
				
	}

?>