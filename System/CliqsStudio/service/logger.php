<?php
	
	namespace CliqsStudio\service;
	use \CliqsStudio\Config\CQS_Config;


	class CQS_Logger extends CQS_Config{

		public $go_Flag = null;
		public $CQSUserPath = null;
		public $debug = null;

		public function __construct(){
			
			$parent  =  new parent;
			$this->CQSUserPath = $parent->CQSUserPath;
			$this->debug = $parent->debug;			
		}
	
		public function syslogger($msg){

				$parent = new parent;
				$self = new self;

				$LOGPATH 	=		$parent->logPath[0];
				
				$realPath = $self->CQSUserPath.$LOGPATH;
				
				
				if (is_dir($realPath) == true) {
					
					dateentrypoint:
					$now = date('F-d-Y',time());
					$file = $realPath.''.$now.".log";

					$file = file_exists($file)?$file:fopen($file, 'w+');

					if($file === false){

						goto dateentrypoint;
					}

					try{

						if (is_readable($file)) {

							
							$time = date('h:i:s a',time());
							$msg= $time." ---> $msg\n";

							try {
					
								error_log($msg,3,$file);
					
							} catch (\Exception $e) {
								
								$e->getMessage();

							}

						}else{
							
							throw new \Exception("CQS Major Concern: Sys Log File Missing", 1);
							
						}

					}catch(\Exception $e){

						//trigger_error($e->getMessage());
					}

				}
		}

	
		public static function checkLive($error,$debug=false){

			$self = new self;

			if ($self->debug == true || $debug == true) {
			
				$self->syslogger($error);
				
			}
				
				/*echo "<pre>$error</pre>"; */
			
		}
	}



?>