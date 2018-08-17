<?php
	
	include_once 'System/vendor/autoload.php';
	include_once 'System/CliqsStudio/init.php';
	
	//Autoload App Classes
	include_once 'vendor/autoload.php';
	include_once 'error.php';

	use CliqsStudio\CQS_App as CQS_App;

	
	use Apps\alarm\config\config as config;

	$config = new config;
	
	$driver 	= $config::$DB_DRIVER;
	$host	 	= $config::$DB_HOST;
	$user 	 	= $config::$DB_USER;
	$password 	= $config::$DB_PASSWORD;
	$name 		= $config::$DB_NAME;
	$port 	 	= $config::$DB_PORT;

	$app_path 	= "{$_SERVER['DOCUMENT_ROOT']}{$config::$APP_ABSPATH}";
	$framework 	= $config::$FRAMEWORK_PATH;
	
	
	class CQS_WorkSpace extends CQS_App{
	
	}
	
	/*@params FrameWorkRelativePath, WorkSpaceFolder, Database Parameters, Default Namespace -WorkSpace, Debug,appToken*/

	$dbParams = ['driver'=>$driver,'host'=>$host,'user'=>$user,'password'=>$password,'database'=>$name,'port'=>$port];
	$CQS_WorkSpace = new CQS_WorkSpace($framework,$app_path,$dbParams,false);

	
	/*error class reads the 3rd param of CQS_WorkSpace*/

	
	set_error_handler("error_handler",E_ALL);


	$CQS_WorkSpace->start(1);
	
	
?>