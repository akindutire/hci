<?php 

	namespace CliqsStudio\service;
	use \CliqsStudio\config\CQS_Config;
	use \CliqsStudio\service\CQS_BuildQuery;
	use \CliqsStudio\service\CQS_Database;
	use \CliqsStudio\controller\CQS_Controller;
	use \CliqsStudio\service\CQS_Logger;
	use \DateTime;
	use \DateInterval;
	use \finfo;

	class CQS_Fileuploader extends CQS_Config{

			public function __construct(){
				
				$this->init();

			}

			private function init(){

				
				
			}

			private function checkFileValid($file){
				
				if(is_file($file))
					return true;
				else
					return 0;
			
			}


			public function checkFileType($file,$data_accept_type=[]){

				$finfo = new finfo(FILEINFO_MIME_TYPE);
				$mime_type = mime_content_type($file);
				$result = array_search($mime_type,$data_accept_type);

				if(is_int($result)){

					return true;

				}else{
					return 0;
				}
				
			}

			public function checkFileSize($file,$maximum_size){
				
				if($maximum_size >= filesize($file))
					
					return true;
				
				else
					return 0;
			}

			public function compressImg($file, $destination, $quality){
				
				if($this->checkFileType($file,['image/jpeg','image/png','image/gif'])){

					try {
						

						$IMG_INFO =getimagesize($file);
						
						if ($IMG_INFO['mime'] = 'image/jpeg'){
						
							$image = imagecreatefromjpeg($file);

						}else if ($IMG_INFO['mime'] = 'image/gif'){

							$image = imagecreatefromgif($file);
						
						}else if($IMG_INFO['mime'] = 'image/png'){

							$image = imagecreatefrompng($file);

						}

						if(imagejpeg($image, $destination, $quality)){

							return true;
						}else{
							return false;
						}

					} catch (Exception $e) {
						
						CQS_Logger::checkLive("Error creating Image From Source in ".__CLASS__." ".__FILE__." On Line ".__LINE__." | ".$e->getMessage());

					}
				}
				

				return $destination;

				//$d = compress($source_img, $destination_img, 90);
			
			}

			public function compressToZip($file){

			}
			

			public function renameFile($file,$newfile){
			
				if (rename($file, $newfile))
					return true;
				else
					return 0;
			
			}
			
	}
?>