<?php 

	namespace CliqsStudio\service;
	use \CliqsStudio\config\CQS_Config;
	use \CliqsStudio\service\CQS_BuildQuery;
	use \CliqsStudio\service\CQS_Database;
	use \CliqsStudio\controller\CQS_Controller;
	use \CliqsStudio\service\CQS_Logger;
	use \DateTime;
	use \DateInterval;

	class CQS_Trial extends CQS_Config{

			public $go_Flag = null;
			private $dataINIFile = null;

			public function __construct(){
				
				$parent = new parent;

				if($parent->trial == true){
					$this->RunTrial();
				}
			}


			private function RunTrial(){
				
				/****
				*	More Development is Needed in Future -Supported Database , Mysql
				*/

				$this->testIfAppRunOnce();

				if($this->go_Flag === 1){
					
					/*App Run For First Time*/
					$this->AppRunFirstTime();

				}else if ($this->go_Flag === 2) {
					
					/*App Once Run*/
					$this->AppOnceRun();
				
				}else {
				
					/*Dont Initialize*/
					$this->Stop_Sys();
				
				}

			}

			private function dataINIExists(){

				$parent = new parent;
				$FrameWorkRelativeRootPath = $parent->CQSPath;
				$FrameWorkdataPath = $parent->dataPath[0];

				$dataINIFile = $FrameWorkRelativeRootPath.''.$FrameWorkdataPath.'data.txt';
				 
				if (file_exists($dataINIFile) == true) {
					$this->dataINIFile = $dataINIFile;	
					return true;
				}
				
			}

			private function testIfAppRunOnce(){
				
				if ($this->dataINIExists() == true) {
					

					$lenOfData = strlen(file_get_contents($this->dataINIFile));

					if($lenOfData == 778){

						$this->go_Flag = 1;

					}elseif ($lenOfData == 729) {
						
						$this->go_Flag = 2;						

					}else{

						$this->go_Flag = null;

						
					}
				
				}else{

					$this->go_Flag = null;
				}

			}


			private function AppRunFirstTime(){

				$parent = new parent;
				
				$FrameWorkRelativeRootPath = $parent->CQSPath;
				$FrameWorkdataPath = $parent->dataPath[0];
				
				
				$CBMPdataPath = $FrameWorkRelativeRootPath.''.$FrameWorkdataPath;


				if (is_dir($CBMPdataPath) === true) {
					
					$DataTXTFile = $CBMPdataPath.'data.txt';

					$string=file_get_contents($DataTXTFile);
					$sub = substr($string, 558,49);

					$string = str_replace($sub, "", $string);
				

					if(file_put_contents($DataTXTFile, $string) ==  729){
						
						CQS_Logger::checkLive("App Data Directory Set");
						
					
					}else{

						$this->AppRunFirstTime();
					}

				}else{

					CQS_Logger::checkLive("App Data Directory Not Set");
					
				}

				$CBMPdataPathFile = $CBMPdataPath.'c.bmp';

				/*Trial Period*/

				$trialPeriod = $parent->trialDuration;
				

				/*DATE OBJECTS*/
									
				$future = new DateTime();	
				$future->add(new DateInterval('P'.$trialPeriod.'D'));

				$now = new DateTime();
				$now = $now->getTimestamp();

				$future = $future->getTimestamp();


				if(file_put_contents($CBMPdataPathFile, $future) != 0){
					/*Contain TimeStamp To Stop App*/			
					$PlaceCBMPDataInDatabase = file_get_contents($CBMPdataPathFile);
								
				}else{

					$this->AppRunFirstTime();			
				}




				$Database = new CQS_Database;
				
				$DefaultdatabaseParam = ['mysql','localhost', 'test', 'root', ''];
				$connection1 = $Database->addConnection($DefaultdatabaseParam);

				$connection1->exec("CREATE DATABASE IF NOT EXISTS CliqsStudioxc_trial");
				

				$newCliqsStudio = ['mysql','localhost', 'CliqsStudioxc_trial', 'root', ''];
				$connection1 = $Database->addConnection($newCliqsStudio);
				
				$sql = new CQS_BuildQuery;


				$connection1->exec("CREATE TABLE IF NOT EXISTS CliqsStudioxc_trial.trial(id int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,start int(11) NOT NULL,stop int(11) NOT NULL,last_seen int(11) NOT NULL)");
				
				$rs = $sql->truncate($connection1,'trial');
				$rs = $sql->create($connection1,'trial',['null',$now,$PlaceCBMPDataInDatabase,$now]);

				if ($rs == false) {
					
					CQS_Logger::checkLive("Couldn't Initialize Trial System");
					$this->AppRunFirstTime();

				}


				$FrameWorkservicePath = $parent->servicePath[0];				
				

				if (is_dir($FrameWorkRelativeRootPath.''.$FrameWorkservicePath) === true) {
					
					file_put_contents($FrameWorkRelativeRootPath.''.$FrameWorkservicePath.'service.ini', '[DEBUG]');
					CQS_Logger::checkLive("Service  Directory Set");
				
				}else{

					CQS_Logger::checkLive("Service Directory Not Set");
					$this->AppRunFirstTime();
				}


			}


			private function AppOnceRun(){

				$parent = new parent;
				
				$FrameWorkRelativeRootPath = $parent->CQSPath;
				$FrameWorkdataPath = $parent->dataPath[0];
				
				
				$CBMPdataPath = $FrameWorkRelativeRootPath.''.$FrameWorkdataPath;

				if (file_exists($CBMPdataPath.'c.bmp') == false) {
					
					$this->kill_Sys();

				}else{

					$Database = new CQS_Database;
					
					$newCliqsStudio = ['mysql','localhost', 'CliqsStudioxc_trial', 'root', ''];
					$connection1 = $Database->addConnection($newCliqsStudio);
					
					$sql = new CQS_BuildQuery;
					$rs = $sql->readEx($connection1,'trial',[['id','=',1]],['last_seen']);

					$FrameWorkservicePath = $parent->servicePath[0];				
					
					/*CBMPFILE -Contain TimeStamp To Stop App*/
					$CBMPdata=file_get_contents($CBMPdataPath.'c.bmp');

					if ((file_exists($FrameWorkRelativeRootPath.''.$FrameWorkservicePath.'service.ini') != true) || $rs->rowCount() != 1) {
						
						/*Repair Trial System*/

						$DefaultdatabaseParam = ['mysql','localhost', 'test', 'root', ''];
						$connection1 = $Database->addConnection($DefaultdatabaseParam);
						$connection1->exec("CREATE DATABASE IF NOT EXISTS CliqsStudioxc_trial");

						$newCliqsStudio = ['mysql','localhost', 'CliqsStudioxc_trial', 'root', ''];
						$connection1 = $Database->addConnection($newCliqsStudio);
						
						$connection1->exec("CREATE TABLE IF NOT EXISTS CliqsStudioxc_trial.trial(id int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,start int(11) NOT NULL,stop int(11) NOT NULL,last_seen int(11) NOT NULL)");
						
						$now = new DateTime();
						$now = $now->getTimestamp();

						$rs = $sql->truncate($connection1,'trial');
						$rs = $sql->create($connection1,'trial',['null',$now,$CBMPdata,$now]);
						if ($rs == false) {
							
							CQS_Logger::checkLive("Couldn't Repair Trial System");
							$this->AppOnceRun();

						}

						$FrameWorkservicePath = $parent->servicePath[0];				

						if (is_dir($FrameWorkRelativeRootPath.''.$FrameWorkservicePath) === true) {
							
							file_put_contents($FrameWorkRelativeRootPath.''.$FrameWorkservicePath.'service.ini', '[DEBUG]');
							CQS_Logger::checkLive("Service  Directory Set");
						
						}else{

							CQS_Logger::checkLive("Service Directory Not Set");
							$this->AppOnceRun();
						}	

					}else if ((file_exists($FrameWorkRelativeRootPath.''.$FrameWorkservicePath.'service.ini') == true) && $rs->rowCount() == 1) {


						/*Update Last Minute*/
						
						$now = new DateTime();
						$now = $now->getTimestamp();

						
						/*CBMPdata Contain TimeStamp To Stop App*/
						if ($CBMPdata < $now) {
							
							$this->Kill_Sys();

						}else{

							/*Check If System Back Dated*/
							$last_seen = $rs->fetch();
							$last_seen = $last_seen['last_seen'];

							if($last_seen < $now){

								$rs = $sql->updateEx($connection1,'trial',[['id','=',1]],[['last_seen',$now]]);

							}else{

								$this->Stop_Sys_For_BackDate();
							}


						}

					}

					/*Repair or Update Logic End*/

				}

			}

			private function kill_Sys(){

				die("<b>Fatal Error:</b> Contact App Provider, CQS::TanyunChi");

			}

			private function Stop_Sys(){

				die("<b>Catchable Error:</b> Contact App Provider, CQS::DiscursEnvyBag");

			}

			private function Stop_Sys_For_BackDate(){

				die("<b>Catchable Error:</b> Machine Date/Time Incorrect -Adjust Date/Time, CQS::MachineEnvyBag");
			}
				
				
	}
?>