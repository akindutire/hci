<?php 

	namespace CliqsStudio\service;
	use \CliqsStudio\config\CQS_Config;
	use \CliqsStudio\service\CQS_BuildQuery;
	use \CliqsStudio\service\CQS_Database;
	use \CliqsStudio\controller\CQS_Controller;
	use \CliqsStudio\service\CQS_Logger;
	use \DateTime;
	use \DateInterval;

	class CQS_Security extends CQS_Config{

		public function __construct(){

		}

		public function encryptData($data,$key){
			//USING SHA256
			
			$klen = strlen($key);
			if(strlen($key) > 16){

				for($i = (17); $i <= $klen; $i++){
					
					$key[$i] = null;

				}

				$key = '$5$rounds=5000$'.$key.'$';

				if (CRYPT_SHA256 == 1) {
	    		
	    			$hashed = crypt($data, $key);
				
				}else{

					CQS_Logger::checkLive("Encryption Algorithm Not Found at ".__CLASS__." in ".__FILE__." around ".__LINE__);
					$hashed = 0;
				
				}

			}else{

				CQS_Logger::checkLive("Encryption Key Must be At Least 16 ".__CLASS__." in ".__FILE__." around ".__LINE__);
				$hashed = 0;
			}


			
			return $hashed;
		
		}

		public function encryptPassword($data,$securitylevel=11){

			if ($securitylevel > 31){
			
				$securitylevel = 31;
			
			}else if ($securitylevel < 4) {
			
				$securitylevel = 4;
			
			}

			$option = ['cost' => $securitylevel ];

				if($hashed = password_hash($data,PASSWORD_BCRYPT,$option)){

					if (password_needs_rehash($hashed,PASSWORD_BCRYPT,$option)) {
						
						$new_result = password_hash($data,PASSWORD_BCRYPT,$option);						
						return $new_result;
					
					}else{
						
						return $hashed;
					
					}
				
				}else{
					
					return 0;
					CQS_Logger::checkLive("Encryption Fails at ".__CLASS__." in ".__FILE__." around ".__LINE__);
					
				}

		}

		private function primeSwitcher($string){
			$count = 0;
			
			$A = [1,1,1];

			for($j=$A[2]; $j < strlen($string); $j++){
				
				for ($i=$A[2]; $i < strlen($string); $i++) { 
					
					
					$is_prime = pow(2,($i-1)) % $i;

					if($is_prime == 1){

						if ($count <= 1) {

							$A[$count] = $i;
							
							/*echo "Sees $i as prime<br>";*/

							$count+=1;
						
						}else{

							/*echo "\n Prime Count Exceeded<br>";*/
							break;
						}

					}else{

						/*echo "Not Prime Skipped $i <br>";*/

						continue;
					}
			
				}
				
				if ($A[1] != null) {
					
					/*$A[1]."  Was saved as the Conjugate Prime to be last prime seen<br>";*/
					/*Next Iteration Start From lastPrime saved*/
					
					$tmp = $string[$A[0]];
					$string[$A[0]] = $string[$A[1]];
					$string[$A[1]] = $tmp;
					
					$A[2] = $A[1];
					$A[1] =  null;
					$A[0] = null;
					$count = 0;
					
				}else{

					/*echo "No Conjugate Prime Found, No Need for swaps";*/
					break;
				}

				
			}

			return $string;

		
		}

		private function primeDeSwitcher($string){

			/*In Progress*/

			$count = 0;
			
			$A = [1,strlen($string),strlen($string)];

			$j = $A[2]-1;
			while($j < 0){
				
				$i = $j;

				while($i < 0) { 
					
					
					$is_prime = pow(2,($i-1)) % $i;

					if($is_prime == 1){

						if ($count <= 1) {

							$A[$count] = $i;
							
							/*echo "Sees $i as prime<br>";*/

							$count+=1;
						
						}else{

							/*echo "\n Prime Count Exceeded<br>";*/
							break;
						}

					}else{

						/*echo "Not Prime Skipped $i <br>";*/

						continue;
					}

					$i -= 1; 
			
				}
				
					if ($A[0] != null) {
						
						/*$A[1]."  Was saved as the Conjugate Prime to be last prime seen<br>";*/
						//Next Iteration Start From lastPrime saved
						echo $A[1];

						$tmp = $string[$A[1]];
						$string[$A[1]] = $string[$A[0]];
						$string[$A[0]] = $tmp;
						
						$A[2] = $A[0];
						$A[1] =  null;
						$A[0] = null;
						$count = 0;
						
					}else{

						/*echo "No Conjugate Prime Found, No Need for swaps";*/
						break;
					}

				$j -= 1;
			}

			return $string;


		}


		public function Encode($data){
		
			$enc_table = 'AaBbCcDdEeFfGgHhIiJjKkLlMmNnOoPpQqRrSsTtUuVvWwXxYyZz0123456789 .,/!@#$%^&*()_-+=-\|?[]{}":;<>\'\\';
		
			$to_be_encoded = $data;

				$new_encoded = null;

				for($i=0; $i<strlen($data); $i++){
					
					if (strpos($enc_table,$to_be_encoded[$i]) != false || ($to_be_encoded[$i]===$enc_table[0])) {
						
						
						for($j=0; $j<strlen($enc_table); $j++){

							if($to_be_encoded[$i]===$enc_table[$j]){

								$pos = strlen($enc_table) - $j;

								if ($pos === 95) {
									$pos = 94;
								}else if($pos === 92){

									$pos = 93;
								}

								$new_encoded .=$enc_table[$pos];

								
							
							}else{

								continue;
							}
						}	
					
					}else{

						
						continue;
					}
					
				}
				
				if (empty($new_encoded)) {
					$new_encoded = $to_be_encoded;
				}

				$new_data = $this->primeSwitcher($new_encoded);

				return $new_data;

		}


		public function Decode($data){

			/*In Progress*/

			$enc_table = 'AaBbCcDdEeFfGgHhIiJjKkLlMmNnOoPpQqRrSsTtUuVvWwXxYyZz0123456789.,/!@#$%^&*()_-+=\|?[]{}":;<>\\ ';
		
			$to_be_decoded = $this->primeSwitcher($this->primeSwitcher($data));;

				$new_decoded = null;

				for($i=0; $i<strlen($data); $i++){
					
					if (strpos($enc_table,$to_be_decoded[$i]) != false) {
						
						for($j=0; $j<strlen($enc_table); $j++){

							if($to_be_decoded[$i]===$enc_table[$j]){

								$pos = strlen($enc_table) - $j;
								$new_decoded .=$enc_table[$pos];
							
							}
							
							continue;
						}	
					
					}else{
						$new_decoded = $to_be_decoded;
						break;
					}
					
				}
			
			return $new_decoded;
		}


		
		public function decrypt($ncrypted,$key){

			#future
		}


	}
?>