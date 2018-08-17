<?php

	namespace CliqsStudio\service;
	
	use \CliqsStudio\service\CQS_Logger;
	use \CliqsStudio\Config\CQS_Config;

	class CQS_BuildQuery extends CQS_Config{

		public $CQSPath = null;
		public $CQSUserPath = null;

		
		public $lastLogicalOfConditionString = null;

		public $ConditionString = null;
		public $ConditionValue = [];


		public function __construct(){
			
			$parent = new parent;
			$this->CQSPath  = $parent->CQSPath;

		}

		public static function create($connect_handle,$table,$data=[]){
			
			$Logger = new CQS_Logger;
			
			try {

				$length = count($data);		
			
			} catch (Exception $e) {
				$Logger->checkLive($e->getMessage());	
			}

			
			$i=1; $variable_space = null;
			
			while ($i <= $length) {
			
				$variable_space.='?,';
				$i++;
			}

			$variable_space = rtrim($variable_space,',');

			$query = "INSERT INTO $table VALUES($variable_space)";
			
			try {

				$Logger->checkLive($query);
				$rs = $connect_handle->prepare($query);
				
				if ($rs->execute($data)) {
				
					return true;
				
				}
				
			} catch (\PDOException $e) {

				$Logger->checkLive($e->getMessage());
				return false;
			}
			
		}

		
		public static function readEx($connect_handle,$table,$data=[[[]]],$data_field_selected=[],$extra=[]){

			$datasize = count($data);
			$length =  $datasize!=0?$datasize:null; 	
			$conditions = null;
			
			$extrasize = count($extra);
			$extralength =  $extrasize!=0?$extrasize:null;
			
			$Logger = new CQS_Logger;

			try{

				/*Selected Field*/

				if (count($data_field_selected) == 0) {
				
					$field_to_select = '*';
				
				}else{

					$field_to_select = null;

					foreach ($data_field_selected as $field_to_selecting) {
						
						$field_to_select.= "$field_to_selecting,";
						
					}
					$field_to_select = rtrim($field_to_select,',');
					
				}

				if ($extralength != null) {
					
					$extra_query = $extra[0];
				
				}else{

					$extra_query = null;
				}


				if ($length != null) {
					
					$self = new self;

					$self->extractCondition($data);
					
					$condition = $self->ConditionString;

					$query = "SELECT $field_to_select FROM $table WHERE $condition $extra_query";

				}else{	
				
					$query = "SELECT $field_to_select FROM $table $extra_query";
			
				}

				try {

					
					
					$Logger->checkLive("{$query}");
					
					$rs = $connect_handle->prepare($query);
					if ($rs->execute($self->ConditionValue) != false){
					
						return $rs;

					}else{
						
						$Logger->checkLive("Query Error!");
						return false;

					}

				} catch (\PDOException $e) {
					$Logger->checkLive($e->getMessage());
					return false;
				}
			}catch(\Exception $e){
				
				$Logger->checkLive($e->getMessage());
				
			}
				
		}

		public static function updateEx($connect_handle,$table,$data=[[[]]],$data_field_updated=[[]],$extra=[]){

			$datasize = count($data);
			$length =  $datasize!=0?$datasize:null; 	$conditions = null;
			
			$extrasize = count($extra);
			$extralength =  $extrasize!=0?$extrasize:null;

			$Logger = new CQS_Logger;
			$self = new self;

			try{

				/*Updated Field*/

				foreach ($data_field_updated as $as_update_array) {

					$field_to_update = null;

					if (is_array($as_update_array) && count($as_update_array)==2) {
					
						$field = $as_update_array[0];		$field_val = $as_update_array[1];	
					
					}else{
					
						$error = "SQL Error: Line ".__LINE__." on ".__METHOD__." / ". __CLASS__." ".__FILE__." Expecting Nested Array as Arguement, Expecting two(2) parameters";
						$Logger->checkLive($error);
					
					}

					$field_to_update.=	"$field = '$field_val',";

					
				}

				$field_to_update = rtrim($field_to_update,",");

				if ($extralength != null) {
					
					$extra_query = $extra[0];
				
				}else{

					$extra_query = null;
				}



				if ($length != null) {
									
					$self = new self;

					$self->extractCondition($data);
					
					$condition = $self->ConditionString;

					$query = "UPDATE $table SET $field_to_update  WHERE $condition $extra_query";

				}else{	
				
					$query = "UPDATE $table SET $field_to_update $extra_query";

				}


				try {

					/*foreach ($self->ConditionValue as &$value) {
						$Logger->checkLive($value);
					}*/

					$Logger->checkLive("{$query}");

					$rs = $connect_handle->prepare($query);
					if ($rs->execute($self->ConditionValue) != false){
					
						return $rs;

					}else{
						
						$Logger->checkLive("Query Error!");
						return false;

					}

				} catch (\PDOException $e) {
					$Logger->checkLive($e->getMessage());
					return false;
				}

			}catch(\Exception $e){
				$Logger->checkLive($e->getMessage());
			}

		}

		public static function delete($connect_handle,$table,$data=[[[]]],$extra=[]){

			$datasize = count($data);
			$length =  $datasize!=0?$datasize:null; 	$conditions = null;
			
			$extrasize = count($extra);
			$extralength =  $extrasize!=0?$extrasize:null;

			$Logger = new CQS_Logger;


			try{

				if ($extralength != null) {
					
					$extra_query = $extra[0];
				
				}else{

					$extra_query = null;
				}


				if ($length != null) {
									
					$self = new self;

					$self->extractCondition($data);
					
					$condition = $self->ConditionString;

					$query = "DELETE FROM $table WHERE $condition $extra_query";

				}else{	
				
					$query = "DELETE FROM $table $extra_query";
			
				}


				try {
					
					$rs = $connect_handle->prepare($query);
					if ($rs->execute($self->ConditionValue) != false){
					
						$Logger->checkLive("{$query} {$condition}");
						return $rs;

					}else{
						
						$Logger->checkLive("Query Error!");
						return false;

					}

				} catch (\PDOException $e) {
					$Logger->checkLive($e->getMessage());
					return false;
				}

			}catch(\Exception $e){
				$Logger->checkLive($e->getMessage());
			}

			
		}

		public static function truncate($connect_handle,$table){

			$query = "TRUNCATE $table";
			
			$Logger = new CQS_Logger;

			try{

				$Logger->checkLive($query);
				$rs = $connect_handle->execute($query);
				
				if ($rs != false){
				
					return $rs;
				
				}

			}catch (\PDOException $e) {
					$Logger->checkLive($e->getMessage());
					return false;
			}
		}

		private function extractConditionEx($array,$index = 0){

			if(count($array) != 0){

				
				$defaultLogicalOperator = "AND";


				while($index < count($array)){

					
				
					if(is_array($array[$index]) && count($array[$index]) != 0){

						$sub_array = $this->checkArray($array[$index]);

						/*Sub Arrays must be more than 2 otherwise it is Ignored*/


						if ($sub_array != false) {
							
							$this->ConditionString .= " (";

							$this->extractConditionEx($sub_array,0);
							
						}else{

							if (count($array) == 1) {
							
				
								if (count($array[$index])  ==  2) {

									$this->ConditionString .= "{$array[$index][0]} = ? ";
									array_push($this->ConditionValue, $array[$index][1]);
								
								}else if (count($array[$index]) > 2) {
								
									$this->ConditionString .= "{$array[$index][0]} {$array[$index][1]} ? ";
									array_push($this->ConditionValue, $array[$index][2]);

								}else{
									
									//Trigger Array Content must be at leastr 2								
									$this->ConditionString .= null;
								
								}
							}else{

								$logicalOperatorsArray = ["OR","AND","NOT","XOR","NAND"];

								if (count($array[$index])  ==  2) {

									$this->ConditionString .= "{$array[$index][0]} = ? AND ";
									array_push($this->ConditionValue, $array[$index][1]);

									$this->lastLogicalOfConditionString = $defaultLogicalOperator;
								
								}else if (count($array[$index]) == 3) {
									
									if ($index != count($array)) {
										
										if (!in_array($array[$index][2], $logicalOperatorsArray) ) {
											

											$this->ConditionString .= "{$array[$index][0]} {$array[$index][1]} ? $defaultLogicalOperator ";
											
											array_push($this->ConditionValue, $array[$index][2]);

											$this->lastLogicalOfConditionString = $defaultLogicalOperator;

										}else{

											$this->ConditionString .= "{$array[$index][0]} = ? {$array[$index][2]} ";
											
											array_push($this->ConditionValue, $array[$index][1]);
											
											$this->lastLogicalOfConditionString = $array[$index][2];

										}
									}else{

										if (in_array($array[$index][2], $logicalOperatorsArray) === true) {
											
											$this->ConditionString .= "{$array[$index][0]} = ? ";
											array_push($this->ConditionValue, $array[$index][1]);

											$this->lastLogicalOfConditionString = $array[$index][2];



										}else{
											
											$this->ConditionString = "{$array[$index][0]} ? {$array[$index][2]} ";
											array_push($this->ConditionValue, $array[$index][1]);

											$this->lastLogicalOfConditionString = $defaultLogicalOperator;


										}
									}
								}else if (count($array[$index]) > 3) {
									
									if ($index != count($array)) {
										
										$this->ConditionString .= "{$array[$index][0]} {$array[$index][1]} ? {$array[$index][3]} ";
	
										array_push($this->ConditionValue, $array[$index][2]);
										
										$this->lastLogicalOfConditionString = $array[$index][3];

									}else{

										$this->ConditionString .= "{$array[$index][0]} {$array[$index][1]} ? ";
										array_push($this->ConditionValue, $array[$index][2]);

										$this->lastLogicalOfConditionString = $defaultLogicalOperator;

									}
								}else{

									$this->ConditionString .= null;
									//Trigger Array content must be at least 2
								}

							}/*Endif*/					
						}/*Endif*/	

					}/*Endif*/
					
					/* #increment index*/
					$index += 1;

				}/*Endwhile*/
				
				
				$this->ConditionString = rtrim(trim($this->ConditionString),$this->lastLogicalOfConditionString);
				
				
				$this->ConditionString .= ") {$this->lastLogicalOfConditionString} ";
				
			
			}/*Endif*/

				
		}/*EndextractCondition*/ 

		private function extractCondition($array,$index=0){

			$this->extractConditionEx($array,$index);

			$this->ConditionString = trim(rtrim(trim($this->ConditionString),"{$this->lastLogicalOfConditionString}"));
			$this->ConditionString[strlen($this->ConditionString)-1] = ' ';
		}

		private function checkArray($array){

			if (is_array($array) and count($array) > 1) {

				$flag = 0;
				foreach($array as $in_array){

					if (is_array($in_array)) {
						$flag = 1;
						break;
					}
				}

				if ($flag == 1) {
					return $array;
				}else{
					return false;
				}
			}else{
				return false;
			}
		}

	}

	
?>