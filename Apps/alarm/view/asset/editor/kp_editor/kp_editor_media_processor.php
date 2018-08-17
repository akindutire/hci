<?php


	$kp_editor_name=$_FILES['file']['name'];
	$kp_editor_size=$_FILES['file']['size'];
	$kp_editor_type=$_FILES['file']['type'];
	$kp_editor_tmp=$_FILES['file']['tmp_name'];

	$path = $_POST['storage'];
	$storage =  $_SERVER['DOCUMENT_ROOT']."/".$path;
	
	
	
	if (isset($kp_editor_name)) {
		
		$kp_editor_name=str_replace(' ', '', $kp_editor_name);
		
		if($kp_editor_type == 'video/mp4' || $kp_editor_type == 'video/ogg' || $kp_editor_type == 'video/3gp' || $kp_editor_type == 'video/3gpp' || $kp_editor_type == 'video/x-flv' || $kp_editor_type == 'video/jpg' || $kp_editor_type == 'video/jpm' || $kp_editor_type == 'video/mpeg' || $kp_editor_type == 'video/webm' || $kp_editor_type == 'video/webp'){


			//50MB
			if ($kp_editor_size <= (25 * 1058816)) {
				
			}else{
				echo json_encode(["msg"=>"File too large, Expect 25MB","success"=>0]);
				goto end;
			}

		}else if ($kp_editor_type == 'image/png' || $kp_editor_type == 'image/jpeg' || $kp_editor_type == 'image/gif') {
			//20MB
			if ($kp_editor_size <= (10 * 1058816)) {
				
			}else{
				echo json_encode(["msg"=>"File too large, Expect 10MB","success"=>0]);
				goto end;
			}
		}
		
			
		$ext = (explode('.', $kp_editor_name));
		$ext = $ext[count($ext)-1];

		$f=preg_replace('/\W/',"", $kp_editor_name);

		$kp_editor_name = sha1(time().$f).".{$ext}";

		if ($kp_editor_type == 'image/png' || $kp_editor_type == 'image/jpeg' || $kp_editor_type == 'image/gif'){
			
			if ($kp_editor_type == 'image/jpeg') {
			
				$image = imagecreatefromjpeg($kp_editor_tmp);
				
			}elseif ($kp_editor_type == 'image/png') {
				
				$image = imagecreatefrompng($kp_editor_tmp);
				
			}elseif ($kp_editor_type == 'image/gif'){

				$image = imagecreatefromgif($kp_editor_tmp);
			
			}else{

				echo json_encode(["msg"=>"An error occur","success"=>0]);
			}
			
			try{
				if(imagejpeg($image, "{$storage}/{$kp_editor_name}", 60)){
			
					
					$fileSrc = "http://{$_SERVER['HTTP_HOST']}/$path/$kp_editor_name";
				
					echo json_encode(["photosource"=>$fileSrc,"success"=>1,"file_type"=>"px"]);	
				

				}else{

					throw new Exception(json_encode(["msg"=>"An error occur","success"=>0]));
				
				}
			}catch(Exception $e){
				echo $e->getMessage();
			}

		}else if ($kp_editor_type == 'video/mp4' || $kp_editor_type == 'video/ogg' || $kp_editor_type == 'video/3gp' || $kp_editor_type == 'video/3gpp' || $kp_editor_type == 'video/x-flv' || $kp_editor_type == 'video/jpg' || $kp_editor_type == 'video/jpm' || $kp_editor_type == 'video/mpeg' || $kp_editor_type == 'video/webm' || $kp_editor_type == 'video/webp') {
			
			try{

				if(move_uploaded_file($kp_editor_tmp, "{$storage}/{$kp_editor_name}")){
					$fileSrc = "http://{$_SERVER['HTTP_HOST']}/$path/$kp_editor_name";
				
					echo json_encode(["photosource"=>$fileSrc,"success"=>1,"file_type"=>"vid"]);	
			
				}else{
			
					throw new Exception(json_encode(["msg"=>"An error occur","success"=>0]), 1);
					
				}
			}catch(Exception $e){

				echo $e->getMessage();
			}
		}
					
					

				
	}
	end:

?>