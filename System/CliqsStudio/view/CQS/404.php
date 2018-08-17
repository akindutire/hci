<?php
use \CliqsStudio\config\CQS_Config as CQS_Config;

$cfg = new CQS_Config;

$absPath = $cfg->CQSPath;
?>

<!DOCTYPE html>
<html>
<head>
	
	<link rel="icon" type="text/css" href=<?php echo "{$absPath}view/CQS/Asset/img/U1.jpg"; ?>>
	<title>CQS</title>
	<style type="text/css">
		
		@import "<?php echo "{$absPath}/view/CQS/Asset/css/w3.css" ?>";
		@import "<?php echo "{$absPath}/view/CQS/Asset/css/cqs.css" ?>";

	</style>

</head>
<body style="height: 635px; ">
	
	<div class="w3-container">

		<div style="display: flex; justify-content: center; height: 100%; " class="w3-container w3-white">
			
			<div style="margin-top:5%;">

				<p class="w3-center w3-cqs-primel w3-xxxlarge w3-text-grey">Ooops, Page Not Found!</p>

			
			</div>

		</div>

	</div>

</body>
</html>