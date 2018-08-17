<?php

	namespace CliqsStudio;

	use CliqsStudio\config\CQS_Config as CQS_Config;
	use CliqsStudio\service\CQS_Trial as CQS_Trial;
	use CliqsStudio\service\CQS_Database as CQS_Database;
	use CliqsStudio\service\CQS_BuildQuery as CQS_BuildQuery;
	use CliqsStudio\service\CQS_Logger as CQS_Logger;
			

	class CQS_App{


		public $defaultcontroller 	=		'home';
		public $defaultview 		= 		'index';
		public $pageparams 			= 		[];
		public $urlParams 			= 		[];


		public static $CQSPathe 	 			= 		'CliqsStudio/';
		public static $CQSUserPathe 			= 		'test';
		public static $CQSAbsPathe	 			= 		'//CliqsStudio/';
		public static $CQSDebug		 			= 		null;
		
		public static $dbdriver					=		null;
		public static $dbhost					=		null;
		public static $dbuser					=		null;
		public static $dbpassword				=		null;
		public static $dbname 					=		null;
		public static $dbport					=		null;


		public $controllerPath 					=		'controller/'; 
		
		public $go_Flag = 0;
		public $appkey = "&+7624='+!!'##4)Z!!^!8VVUUSuTUU";
		



		public function __construct($path0 , $path1 , $db = ['driver'=>'mysql','host'=>'localhost','user'=>'root','password'=>'','database'=>'test','port'=>3306], $debug = false, $appkey = null){


			
			$this->setCQSPath($path0);
			$this->setCQSUserPath($path1);
			
			$this->setDbParams($db['driver'],$db['host'],$db['user'],$db['password'],$db['database'],$db['port']);

			$this->setCQSDebugState($debug);
		
			$this->pareseUrlParams();

			$appkey = is_null($appkey)?$this->appkey:$appkey;

			$session_path = self::$CQSUserPathe."session/";	
			if(!is_dir($session_path)){
				
				$Logger = new CQS_Logger;
				$Logger->checkLive("Session Container not Valid");

			}


			session_name($appkey);

			session_save_path($session_path);
			session_start();

		}

		private function setCQSPath($CQSPathe){
			self::$CQSPathe = $CQSPathe;
		}

		private function setCQSUserPath($CQSUserPathe){
			self::$CQSUserPathe	=	$CQSUserPathe;
		}

		private function setDbParams($driver,$host,$user,$password,$database,$port){
		
			self::$dbdriver 	= $driver;
			self::$dbhost 		= $host;
			self::$dbuser 		= $user;
			self::$dbpassword 	= $password;
			self::$dbname 		= $database;
			self::$dbport 		= $port;
		
		}

		
		private function setCQSDebugState($boolState){
			self::$CQSDebug	=	$boolState;
		}

		
		
		public function View($view,$data = []){
			
			$vFile = self::$CQSUserPathe."view/$view";
			
			if(file_exists($vFile) === true){

				include_once($vFile);
			
			}
		
		}


		public function start($io = 1){

			if ($io == 0) {

				$vFile = self::$CQSPathe."view/CQS/maintenance.php";
				include_once($vFile);
				die();
			}

			$T = new CQS_Trial;
			
			$urlParams = $this->urlParams;
			
				if (empty($urlParams)) {
										
					$urlParams = [$this->defaultcontroller,$this->defaultview];	
				}
				

				$cPath = self::$CQSUserPathe.''.$this->controllerPath;
				
				

				if(file_exists($cPath.''.$urlParams[0].'.php') === true){

					$this->pagecontroller = $urlParams[0];	
					include_once($cPath.''.$urlParams[0].'.php');

					unset($urlParams[0]);


					/* Checking if method entered from URL*/
					$urlParams[1] = empty($urlParams[1])?$this->defaultview:$urlParams[1];
					
					$apps_pos_index = strpos(self::$CQSUserPathe, "Apps/");
					$back_namespace=substr(self::$CQSUserPathe, $apps_pos_index);

					$namespace=str_replace('/', '\\', $back_namespace);
					
					if (method_exists("\\{$namespace}controller\\{$this->pagecontroller}", $urlParams[1])) {
					
						

						$this->pageview = $urlParams[1];
						unset($urlParams[1]);
						
						$this->pageparams = $urlParams ? array_values($urlParams):[];
					
						/*Import CliqsStudio namespace*/
						
						$controller = "\\{$namespace}controller\\{$this->pagecontroller}";
						
						$this->pagecontroller = new $controller;


						call_user_func_array([$this->pagecontroller,$this->pageview], $this->pageparams);

					}else{
						
						if(file_exists(self::$CQSUserPathe."view/404/index.php") == false){

							$vFile = self::$CQSPathe."view/CQS/404.php";
							include_once($vFile);
							die();
						}else{

							include_once(self::$CQSUserPathe."view/404/index.php");
							die();

						}
					}

				}else{
					
					$this->View(self::$CQSUserPathe."404/index.php");
			
				}

				session_write_close();
		}

		public function close(){

			$this->__destruct();

		}


		private function sanitizeUrlParams($urlParams){

			//[a-zA-Z0-9]

			$pattern = '/^(\S+\/?)+$/';
			if (preg_match($pattern, $urlParams)===1) {
				
				return $urlParams;

			}else{

				$defaultUrlParams = "$this->defaultcontroller/$this->defaultview";
				return $defaultUrlParams;
			}
		}

		private function pareseUrlParams(){
			
			$urlParams = null;

			if (isset($_GET['url_parameters'])) {
				
				$urlParams = $_GET['url_parameters'];

				$urlParams = $this->sanitizeUrlParams($urlParams);

				$this->urlParams = explode('/',$urlParams);
			}

		}


		public function __destruct(){


		}

		public function stop(){

			$this->__destruct();
		}
		
	}

?>