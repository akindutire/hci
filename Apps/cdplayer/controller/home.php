<?php
	
	namespace Apps\cdplayer\controller;
	
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
	

	use Apps\cdplayer\config\config;

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
			$Outputdata = [$this->AbsPath,'view/asset/img/kp.jpg',$cfg::$APP_ROOTPATH];

			parent::View('start/home.php',$Outputdata);


		}
				
	}

?>