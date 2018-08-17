<?php
	
	namespace CliqsStudio\service;	

	use \PDO;
	use \CliqsStudio\service\CQS_Logger;
	use \CliqsStudio\config\CQS_Config;
	
	class CQS_Database extends CQS_Config{

		public $LINK = null;
		public $ConStatus = null;
		public $con_params = [];


		public function __construct(){
			
			$parent = new parent;
			$this->con_params = $parent->dbParams;

		}

		private function databaseDriverDigest($DatabaseType){

			try{

				$supportedDriversArray	=	PDO::getAvailableDrivers();
				
				if (in_array($DatabaseType, $supportedDriversArray)) {
				
					$this->driver 	=	$DatabaseType;
				
				}else{

					throw new Exception("Database Driver for {$DatabaseType} is not Enabled on this Server, Suggest try Installing it");
					
				}

			}catch(Exception $e){
				$Logger = new CQS_Logger($this->CQSUserPath);

				$Logger->checkLive($e->getMessage());
				$this->ConStatus 	= 	$e->getMessage();

			}
		}


		private function Connection($con_params){
			
			/****
			*	More Development is Needed in Future -Supported Database , [Mysql,Sqlite,PgSql]
			*/

			
			if (sizeof($con_params) != 0) {

				$con_params = array_merge($this->con_params,$con_params);
			
			}else{

				$con_params = $this->con_params;
			}
			
			$this->databaseDriverDigest($con_params['driver']);


		
			try {
				
				if ($con_params['driver'] == 'mysql') {

					$DatabaseType 		= 	$con_params['driver'];
					$Host 		 		=	$con_params['host'];
					$DatabaseName 		=	$con_params['database'];
					$DatabaseUsername	=	$con_params['user'];
					$DatabasePassword	=	$con_params['password'];
					$Port 				=	$con_params['port'];

					$connect_handle = new PDO("$DatabaseType:host=$Host;port=$Port;dbname=$DatabaseName", "$DatabaseUsername", "$DatabasePassword");

				}else if ($con_params['driver'] == 'sqlite') {
					
					$DatabaseType 		= 	$con_params['driver'];
					$DbPath 			= 	$con_params['file'];

					$connect_handle = new PDO("$this->driver:$DbPath");
				
				}else if ($con_params['driver'] == 'pgsql') {
					
					$DatabaseType 		= 	$con_params['driver'];
					$Host 		 		=	$con_params['host'];
					$DatabaseName 		=	$con_params['database'];
					$DatabaseUsername	=	$con_params['user'];
					$DatabasePassword	=	$con_params['password'];
					$Port 				=	$con_params['port'];
					
					$connect_handle = new PDO("$DatabaseType:host=$Host port=$Port dbname=$DatabaseName user=$DatabaseUsername password=$DatabasePassword");

				}
				
				if ($connect_handle != null) {
					
					$connect_handle->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
					$connect_handle->setAttribute(PDO::ATTR_PERSISTENT,TRUE);
				
					return $connect_handle;

				}else{

					throw new \PDOException("Couldn't Establish a Database Connection", 1);
					
				}
			} catch (PDOException $e) {
				
				$Logger = new CQS_Logger;
				$Logger->checkLive($e->getMessage());
				$this->ConStatus 	= 	$e->getMessage();
			}
		}

		public final function addConnection($con_params = []){
			
			$conn = new self();

			$link = $conn->Connection($con_params);
			
			$this->ConStatus 	=	"<pre>Connection Established</pre>";

			return $link;

		}


		public final function getConStatus(){

			return $this->ConStatus;
		}

		public static function closeConnection(){
			
			$Logger = new CQS_Logger($this->CQSUserPath);
			$Logger->checkLive('Connection Closed');
			
			$this->link->close();
		
		}
	}
?>