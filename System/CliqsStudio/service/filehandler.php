<?php 

	namespace CliqsStudio\service;
	use \CliqsStudio\config\CQS_Config;
	use \CliqsStudio\service\CQS_BuildQuery;
	use \CliqsStudio\service\CQS_Database;
	use \CliqsStudio\controller\CQS_Controller;
	use \CliqsStudio\service\CQS_Logger;
	use \DateTime;
	use \DateInterval;

	class CQS_Filehandler extends CQS_Config{

			public function __construct(){
				
				$this->init();

			}

			private function init(){
				
				
			}


			/*------------------------------
			|
			|	Directory Methods
			|
			|-----------------------------*/


			public function isDir($pathdir){

				if (is_dir($pathdir)) {
					return true;
				}else{
					return 0;
				}
			
			}

			public function createDir($path){
			
				return mkdir($path);
			
			}

			public function removeDir($pathdir){
			
				return rmdir($pathdir);
			
			}

			public function renameDir($old_dir, $new_dir){
			
				return rename($old_dir, $new_dir);
			
			}

			public function openFile($directory,$filename,$type,$width='200px',$height='auto'){

				if($type == 'image/jpeg' || $type == 'image/gif' || $type == 'image/bmp' || $type == 'image/png' || $type == 'image/webp' || $type == 'image/jpg'){

					$string = "<img style='' src='$directory/$filename' width='$width' height='$height'>";

				}else if ($type == 'video/3gpp' || $type == 'video/jpm' || $type=='video/jpeg' || $type=='video/mp4' || $type=='video/mpeg' || $type=='video/x-matroska' || $type=='video/quicktime' || $type=='video/ogg' || $type=='video/webm') {

					$string = "<video style='' width='$width' height='$height' controls> <source style='' src='$directory/$filename' type='$type'></video>";
					
				}else if($type == 'audio/vnd.dts' || $type == 'audio/mpeg' || $type=='audio/mp4' || $type=='audio/ogg' || $type=='audio/x-pn-realaudio' || $type=='audio/wav' || $type=='audio/mp3'){

					if ($type == 'audio/mp3') {
					
						$type = 'audio/mpeg';
					
					}

					$string = "<audio controls style=''>	<source style='' src='$directory/$filename' type='$type'> </audio>";

				}else if($type == 'application/msword' || $type == 'application/vnd.ms-word.document.macroenabled.12' || $type == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'){


					$string = "<a style='' class='w3-btn' href='$directory/$filename' style='border:none;'>Open File</a>";

				}else if($type == 'application/vnd.ms-powerpoint' || $type =='application/vnd.ms-powerpoint.template.macroenabled.12' || $type =='application/vnd.openxmlformats-officedocument.presentationml.template' || $type == 'application/vnd.ms-powerpoint.addin.macroenabled.12' || $type == 'application/vnd.cups-ppd' || $type == 'image/x-portable-pixmap' || $type == 'application/vnd.ms-powerpoint' || $type == 'application/vnd.ms-powerpoint.slideshow.macroenabled.12' || $type == 'application/vnd.openxmlformats-officedocument.presentationml.slideshow' || $type == 'application/vnd.ms-powerpoint' || $type == 'application/vnd.ms-powerpoint.presentation.macroenabled.12' || $type == 'application/vnd.openxmlformats-officedocument.presentationml.presentation'){

						$string = "<a style='' class='w3-btn' href='$directory/$filename' style='border:none;'>Open File</a>";

				}else if ($type == 'application/pdf') {
					
					$string = "<iframe style='' width='$width' height='$height' src='$directory/$filename' style='border:none;'></iframe>";

				}

				return $string;
				
			}

	}
?>