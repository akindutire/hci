<?php
namespace Apps\test\config;

/*A PERSONAL FILE FOR EASY MAINTENANCE*/


class config{

	public static $DB_DRIVER 			= 'mysql';
	public static $DB_HOST 				= 'localhost';
	public static $DB_USER 				= 'root';
	public static $DB_PASSWORD 			= '';
	public static $DB_NAME 				= '';
	public static $DB_PORT 				= 3306;
	
	public static $APP_PATH 		 	= 'Apps/test/';
	public static $APP_ABSPATH 		 	= '/CliqsStudio/Apps/test/';
	public static $APP_ROOTPATH 	 	= '/CliqsStudio/';
	public static $FRAMEWORK_PATH	 	= 'System/CliqsStudio/';
	
	public static $MAIL_USER 			= null;
	public static $MAIL_SERVER 			= null;
	public static $MAIL_PORT 			= null;
	public static $MAIL_PASSWORD 		= null;
	public static $MAIL_ADDRESS 		= null;
	public static $MAIL_NAME 			= null;
	

	public function __construct(){

		
	}
}	
	
?>