<?php
	
	namespace Apps\alarm\model;

	use \CliqsStudio\model\CQS_Model;
	use \CliqsStudio\service\CQS_Database;
	use \CliqsStudio\service\CQS_BuildQuery;
	use \CliqsStudio\config\CQS_Config;
	use \CliqsStudio\service\CQS_Security;
	use \CliqsStudio\service\CQS_Session;
	use \CliqsStudio\service\CQS_Mailer;
	use \CliqsStudio\service\CQS_Redirect;

		
	use Apps\alarm\config\config as config;
	
	class alarm extends CQS_Model{

		private $con_handle_details_to_general_users = null;

		public $CQSPath = null;

		public $msg = null;

		public function __construct(){

			$parent = new parent;
			$cfg = new config;


			$this->con_handle_details_to_general_users = ['database'=>$cfg::$DB_NAME];
			$this->CQSUserPath	=	$parent->CQSUserPath;
		
		}

		public function get_days(){

			$connect = new CQS_Database();
			$connect = $connect->addConnection($this->con_handle_details_to_general_users);

			$sql = new CQS_BuildQuery;

			$rs = $sql->readEx($connect,"day",[ ['id','!=',0] ],['id','day']);
			return $rs->fetchAll();

		}

		public function get_alarm_list(){

			$connect = new CQS_Database();
			$connect = $connect->addConnection($this->con_handle_details_to_general_users);

			$sql = new CQS_BuildQuery;

			$data = [];

			$rs = $sql->readEx($connect,"timer",[ ['id','!=',0] ],['id','day_id','hour','minute','note','active'],['ORDER BY id DESC']);
			while(list($id,$day_id,$h,$m,$nt,$ac) = $rs->fetch()){

				$rs_d = $sql->readEx($connect,"day",[ ['id','=',$day_id] ],['day']);
				list($day) = $rs_d->fetch();

				$data[$id] = [$day,$h,$m,$nt,$ac];

			}

			return $data;

		}


		public function set_alarm($hour,$minute,$note,$day){

			$connect = new CQS_Database();
			$connect = $connect->addConnection($this->con_handle_details_to_general_users);

			$sql = new CQS_BuildQuery;

			$rs=$sql->readEx($connect,'timer',[	['day_id',$day],['hour',$hour],['minute',$minute] ]);
			if($rs->rowCount() == 1){

				$this->msg = "Alarm already set";			
				return true;

			}else{

				$rs = $sql->create($connect,'timer',['null',$day,$hour,$minute,$note,1]);
				$this->msg = $connect->lastInsertId();
				
				if($rs == 1){

					return true;
					
				}else{

					$this->msg = 0;
					return false;
					
				}

			}
		}

		public function check_alarm($h,$m,$d){

			$connect = new CQS_Database();
			$connect = $connect->addConnection($this->con_handle_details_to_general_users);

			$sql = new CQS_BuildQuery;

			$rs=$sql->readEx($connect,'timer',[	['day_id',$d],['hour',$h],['minute',$m] ],['note']);
			if($rs->rowCount() == 1){
				
				list($note) = $rs->fetch();

				$rs_d = $sql->readEx($connect,"day",[ ['id','=',$d] ],['day']);
				list($day) = $rs_d->fetch();

				$this->msg = [$note,$day];			
				return true;

			}else{
				return false;
			}
		}

		
		public function remove_alarm($alarm_id){

			$connect = new CQS_Database();
			$connect = $connect->addConnection($this->con_handle_details_to_general_users);

			$sql = new CQS_BuildQuery;

			$rs = $sql->delete($connect,"timer",[ ['id','=',$alarm_id] ]);
			if($rs->rowCount() == 1){
				$this->msg="removed";
				return true;
			}else{
				$this->msg="not removed";
				return false;
			}

		}

	} 

?>