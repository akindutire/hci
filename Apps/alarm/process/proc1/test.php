<?php

namespace Apps\test\process;
/*
	@params include  - File inclusion is not relative to Node init i.e korapo/index.php
*/


include_once ("../../../../System/vendor/autoload.php");
include_once ("../../../../System/CliqsStudio/init.php");

include_once ("../../../../vendor/autoload.php");
include_once ("../../../../error.php");

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
	use \CliqsStudio\service\CQS_Fileuploader;
	use \CliqsStudio\service\CQS_Filehandler;
	use \CliqsStudio\config\CQS_Config;
	use \CliqsStudio\CQS_App as CQS_App;
	

	use \Apps\test\config\config as config;
	

	$config = new config;
	
	$driver 	= $config::$DB_DRIVER;
	$host	 	= $config::$DB_HOST;
	$user 	 	= $config::$DB_USER;
	$password 	= $config::$DB_PASSWORD;
	$name 		= $config::$DB_NAME;
	$port 	 	= $config::$DB_PORT;

	$app_path 	= "{$_SERVER['DOCUMENT_ROOT']}{$config::$APP_ABSPATH}";
	$framework 	= $config::$FRAMEWORK_PATH;

	$dbParams = ['driver'=>$driver,'host'=>$host,'user'=>$user,'password'=>$password,'database'=>$name,'port'=>$port];

	class InApp extends CQS_App{

	}


	$InApp = new InApp($framework,$app_path,$dbParams,true);


	set_error_handler("error_handler",E_ALL);

	$Logger = new CQS_Logger;
	
	$InApp->close();

?>