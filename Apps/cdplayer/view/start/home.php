<?php
$absPath = $data[0];

$rootpath = $data[2];



?>


<!DOCTYPE html>
<html>
<head>

	<title>CliqStudio</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="icon" type="text/css" href="<?php echo "{$absPath}view/asset/img/u1.jpg"; ?>">

</head>


<body class="" ng-app="app" ng-controller="ctrl">



<div class="w3-col l3 w3-hide-small w3-hide-medium">.</div>

<div class="w3-col l6 m12 s12 w3-blue-grey" style="height: 550px; overflow-y: auto;">

	<header class="w3-col l6 m12 s12 w3-dark-grey w3-padding w3-top w3-xlarge" style="z-index: 1;">
	
		<span class="w3-col l11 m11 s11">CD Player</span>

	</header>

	
	<section id="player" class="w3-col" style="margin-top: 64px; display: none;">
			
			<p ng-bind-html=feedback class="w3-center w3-text-red"></p>

                <div ngf-select ngf-drop ngf-drag-over-class="'dragover'" ngf-change = process_file($file,$event) name="file" ng-model=file ng-accept="'video/*,audio/*'" ngf-max-size="1000MB" ngf-min-height=100 ngf-multiple='' class="w3-center w3-small w3-padding w3-margin" style="border: 1px dashed white; height: 200px;">
                    
                    <p class="w3-center"><i class="fa fa-film w3-xxxlarge w3-text-green"></i><br>Choose a File</p>

                </div>

	</section>


	<section id="video" class="w3-col w3-animate-fade" style="margin-top: 64px; display: none;">
		
		<video class="w3-col l12 m12 s12" id="video_f" src='<?php echo "{$absPath}storage/uncommitted_context/v.mp4"; ?>'  controls></video>

	</section>

	<section id="audio" class="w3-col w3-animate-fade" style="margin-top: 64px; display: block;">
		<p class="w3-padding">Wizkid - maloma</p>
		<p class="w3-center"><img width="20%" src="<?php echo "{$absPath}storage/uncommitted_context/a.png"; ?>"></p>
		<audio class="w3-col l12 m12 s12" id="audio_f" src='<?php echo "{$absPath}storage/uncommitted_context/a.mp3"; ?>'  controls></audio>
		
	</section>

	
</div>

<div class="w3-col l3 w3-hide-small w3-hide-medium">.</div>



</body>

<style type="text/css">
		
		@import "<?php echo "{$absPath}view/asset/css/w3.css" ?>";
		@import "<?php echo "{$absPath}view/asset/css/font-awesome/css/font-awesome.min.css" ?>";

</style>

<script type="text/javascript" src="<?php echo "{$absPath}view/asset/js/angular/angular.min.js" ?>"></script>
<script type="text/javascript" src="<?php echo "{$absPath}view/asset/js/dependency/angular-sanitize/angular-sanitize.min.js" ?>"></script>
<script type="text/javascript" src="<?php echo "{$absPath}view/asset/js/dependency/ng-file-upload/ng-file-upload.min.js" ?>"></script>
<script type="text/javascript" src="<?php echo "{$absPath}view/asset/js/dependency/ng-file-upload/ng-file-upload-shim.min.js" ?>"></script>


<script type="text/javascript" src="<?php echo "{$absPath}view/asset/js/angularApp/cdplayer.js" ?>"></script>


</html>