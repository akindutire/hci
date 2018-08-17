<?php

$absPath = '/korapo/Nodes/kphotadmin/';
?>

<!DOCTYPE html>
<html>
<head>
	
	<link rel="icon" type="text/css" href=<?php echo "{$absPath}view/resource/img/kp.jpg"; ?>>
	<title>404</title>
	<style type="text/css">
		
		@import "<?php echo "{$absPath}view/resource/css/w3.css" ?>";
		@import "<?php echo "{$absPath}view/resource/css/cqs.css" ?>";

	</style>

</head>
<body style="height: 635px; ">
	
	<header class="w3-text-white w3-container" style="background: #333390; margin: 0px !important; padding: 0px !important;">
		
		<?php 	$data[1]	= 	$absPath.'view/resource/img/kp.jpg'; ?>
		<p><img src="<?php echo $data[1]; ?>" height="50px" width="auto" class="w3-margin-left  w3-margin-right"><span class="w3-xxlarge w3-cqs-amble">Korapo</span></p>

	</header>


	<div class="w3-container">

		<div style="display: flex; justify-content: center; height: 100%; " class="w3-container w3-white">
			
			<div style="margin-top:5%;">


				<p class="w3-xxlarge w3-text-red">404 Error<br> !Page Not Found</p>

				<p>
					
					<form class="w3-form">
						
						<p class="w3-bar"><input type="text" name="searchSite" class="w3-input w3-border w3-bar-item" placeholder="Search Content"><button class="w3-bar-item w3-btn w3-text-white" style="background: #333390;">Search</button>
					
					</form>
				</p>
				
					
				

				
			</div>

		</div>

	</div>



	<footer class="w3-text-white w3-container w3-bottom" style="background: #333390; margin: 0px !important; padding: 0px !important;">
		
		
		<p class="w3-center w3-text-white">&copy&nbsp;Korapo.com</p>

	</footer>

</body>
</html>