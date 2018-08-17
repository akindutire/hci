<?php
namespace CliqsStudio\service;
use \CliqsStudio\service\CQS_Logger;

class CQS_Sanitize{

	public function __construct(){

	}

	public static function cleanData($data=[],$acceptable_tags=''){

		if (is_array($data) && count($data)!=0) {
			
			//$log = new  CQS_Logger;

			$new_data_set = [];

			foreach ($data as $value) {

				$value = trim($value);
				
				if(is_bool($value)){
					$data_cleansed = $value;	
				}

				if(!is_null($value)){

					if(is_string($value)){

						$data_cleansed = strip_tags($value,$acceptable_tags);
						
					}

					
				}else{
					
					$data_cleansed = $value; 
				}


				if(is_int($value)){

					$data_cleansed = (int)filter_var($value,FILTER_SANITIZE_NUMBER_INT);
				
				}

				if (is_resource($value) === true) {
					
					$data_cleansed = filter_var($value,FILTER_SANITIZE_URL);
					$data_cleansed = filter_var($value,FILTER_SANITIZE_EMAIL);
					
				}
				
				//$log->checkLive($data_cleansed,true);
				//Queue
				array_push($new_data_set, $data_cleansed);
			}
			
			//CQS_Logger::checkLive($new_data_set);
			return $new_data_set;

		}else{

			$error = __CLASS__." / ".__METHOD__." Expected non-empty Array as parameter 1 on Line ".__LINE__;
			CQS_Logger::checkLive($error);

		}	
	}
}
?>