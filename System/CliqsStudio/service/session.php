<?php

	namespace CliqsStudio\service;
	use \CliqsStudio\config\CQS_Config;
	use \CliqsStudio\service\CQS_Logger;

	class CQS_Session extends CQS_Config{

			public function __construct(){

			}

			public function testSession(){
				


			}


			public static function buildSession0($id,$data){
				

				$_SESSION[$id] = $data;

				if (!empty($_SESSION[$id])) {
					
					CQS_Logger::checkLive("$id Session Saved");
					return true;
					
				
				}else {
					
					$error = "Server Error: Line ".__LINE__." on ".__METHOD__." / ". __CLASS__." ".__FILE__." Session Building Failed";
					CQS_Logger::checkLive($error);
						
					return false;
				
				}

			}

			public static function buildSession($data=[[]]){

				if (count($data) != 0) {
					
					/*Session Arrays*/
					foreach ($data as $as_array) {

						if (is_array($as_array) && count($as_array)==2) {
						
							$session_id = $as_array[0];		$session_val = $as_array[1];	
							
						}else{
						
							$error = "SQL Error: Line ".__LINE__." on ".__METHOD__." / ". __CLASS__." ".__FILE__." Enter Nested Array as Arguement or Nested data items Must be at least 2";
							Logger::checkLive($error);
						
						}

						$current = new self;
						
						$current->buildSession0($session_id,$session_val);
							
						
					}

					return true;
				
				}else{

					$error = "SQL Error: Line ".__LINE__." on ".__METHOD__." / ". __CLASS__." ".__FILE__." Enter Nested Array as Arguement or Nested items Must be at 2";
							
					Logger::checkLive($error);

					return false;

				}
							
			}

			public static function getSession($id){
				

				if ($data = $_SESSION[$id]){ 
				
					return $data;
				
				}else {
				
					$error = "Error Session Index $id Not Found";
					CQS_Logger::checkLive($error);
				
				}		
				
				
			}

			public static function deleteSession($id){
				
				$_SESSION[$id] = null;

			}

	}

?>