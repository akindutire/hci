<?php
	
	namespace CliqsStudio\controller;

	use \CliqsStudio\service\CQS_Database;
	use \CliqsStudio\config\CQS_Config;
	use \CliqsStudio\model\CQS_Model;

	class CQS_Controller extends CQS_Config{

		public $CQSUserPath = null;
		public $CQSAbsPath = null;

		public function __construct(){

			$parent = new parent;

			$this->CQSUserPath	=	$parent->CQSUserPath;
			$this->CQSAbsPath	=	$parent->CQSAbsUserPath;
		
		}

		public static function Model(){

			$model = new CQS_Model();
			return $model;

		}

		public function View($view,$data = []){
			
			/*OutPut data 	-data[]*/
			
			$parent = new parent;

			foreach ($parent->viewPath as  $vPath) {
				

				if(file_exists($this->CQSUserPath.''.$vPath.''.$view) === true){
					
					include_once("{$this->CQSUserPath}{$vPath}{$view}");
					break;
				}
			
			}
		}


	}
?>
