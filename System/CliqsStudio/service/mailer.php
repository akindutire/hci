<?php
namespace CliqsStudio\service;
use \CliqsStudio\config\CQS_Config;
use \CliqsStudio\service\CQS_Logger;


class CQS_Mailer extends CQS_Config{

		private $username = null;
		private $password = null;
		private $host = null;
		private $port = null;

 		
 		public function __construct(){
			
			$parent = new parent;

			require $parent->CQSPath.'lib/PHPMailer/PHPMailerAutoload.php';

		}

		public function connectMail($username,$password,$host='smtp.gmail.com',$port=587){

			$this->username = $username;
			$this->password = $password;
			$this->host = $host;
			$this->port = $port;

		}

		public function sendProtocolMail($senderName,$senderAddress,$to=[],$subject,$body){

			$Logger = new CQS_Logger;
			if(!empty($this->username) && !empty($this->password)){
				
				$string_all = null;
				foreach ($to as $mailTo) {

					$string_all .= $mailTo.',';
			
				}
				$string_all=rtrim($string_all,',');
			
				$mail = new \PHPMailer();
				$mail->isSMTP();
				$mail->SMTPDebug = 0;
				$mail->SMTPAuth = true;
				$mail->SMTPSecure = 'tls';		
				$mail->Host = $this->host;
				$mail->Port = $this->port;
				$mail->Username = $this->username;
				$mail->Password = $this->password;
				$mail->From = $senderAddress;
				$mail->FromName = $senderName;
				$mail->Subject= $subject;
				$mail->Body = $body;
				$mail->isHTML(true);
				$mail->addAddress($string_all);
				//$mail->Debugoutput = 'html';


				try{
		
					if($mail->Send()){
						$Logger->checkLive("Mail Successfully Sent to $string_all");
					}else{
						throw new \phpmailerException($mail->ErrorInfo);
					}
			
				}catch(\phpmailerException $e){
					
					$Logger->checkLive($e->getMessage());

				}

			}else{

				$Logger->checkLive("Incorrect Mail Login Credentials");
		
			}

		}


		public function sendLocalMail($senderName,$to=[],$subject,$body){

			$string_all = null;
			
			foreach ($to as $mailTo) {

				$string_all .= $mailTo.',';
			
			}
			
			$string_all=rtrim($string_all,',');
			

			$mail = new \PHPMailer();
		 
			$mail->isMail();
			$mail->From = 'no-reply';
			$mail->FromName = $senderName;
			$mail->Subject= $subject;
			$mail->Body = $body;
			$mail->addAddress($string_all);
			$mail->Debugoutput = 'html';

			try{
		
				if($mail->Send())
					echo "Mail Successfully Sent to $string_all";
				else
					throw new \Exception($mail->ErrorInfo);
		
			}catch(Exception $e){
				
				
				$Logger = new CQS_Logger;

				$Logger->checkLive($e->getMessage());
			
			}

		}


		public function readMail($mailserver,$username,$password,$port=null){


		}

		public function getMailMessage($id){

			
		}


		
}
	
?>