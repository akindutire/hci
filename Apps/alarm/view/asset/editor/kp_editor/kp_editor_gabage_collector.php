<?php

	$data = json_decode(file_get_contents("php://input"));
	$file_urls = $data->fileSrc;

	foreach ($file_urls as $src) {
		$src=str_replace("http://{$_SERVER['HTTP_HOST']}", $_SERVER['DOCUMENT_ROOT'], $src);
		try{

			chmod($src, 0777);
			unlink($src);
		
		}catch(Exeption $e){

		}
	}

	if (!file_exists($file_urls[0]) && !file_exists($file_urls[count($file_urls)-1])) {

		echo json_encode(["msg"=>"All files CLEARED","sx"=>1]);
	
	}else{

		echo json_encode(["msg"=>"Some files were not cleared","sx"=>0]);

	}
	
	
	
	

?>