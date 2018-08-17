<?php
$absPath = $data[0];

$rootpath = $data[2];

$days = $data[3];

$alarm_list = $data[4];

?>


<!DOCTYPE html>
<html>
<head>

	<title>CliqStudio</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="icon" type="text/css" href="<?php echo "{$absPath}view/asset/img/ui1.jpg"; ?>">

</head>


<body class="" ng-app="app" ng-init=" day='0'; " ng-controller="ctrl">

<div class="w3-modal w3-animate-zoom" style="display: none; height: 100%;" id="alarm_alert">
	<div class="w3-modal-content w3-transparent" onclick="document.getElementById('alarm_alert').style.display='none'; document.getElementById('alarm_sound').load();">

			
			<div class="w3-display-container" style="height: 100%; padding-top: 150px;">	
				<a class="w3-display-middle w3-text-white w3-animate-fading"><i class="fa fa-bell w3-xxxlarge"></i></a>
				<p class="w3-xxlarge w3-text-white w3-center">{{hh}}:{{mm}}</p>
				<p class="w3-medium w3-text-white w3-center">{{dayw}} - {{nt}}</p>
				<audio style="visibility: hidden;" src="<?php echo "{$absPath}view/asset/sound/alarm.mp3"; ?>" id="alarm_sound"></audio>
			</div>

		</div>
</div>


<div class="w3-col l3 w3-hide-small w3-hide-medium">.</div>

<div class="w3-col l6 m12 s12 w3-blue-grey" style="height: 550px; overflow-y: auto;">

	<header class="w3-col l6 m12 s12 w3-dark-grey w3-padding w3-top w3-xlarge" style="z-index: 1;">
	
		<span class="w3-col l11 m11 s11">Alarm</span>
		<span class="w3-col l1 m1 s1" id="new"><a onclick="document.getElementById('new').style.display='none'; document.getElementById('alarm_list').style.display='none'; document.getElementById('alarm_view').style.display='none'; document.getElementById('day_list').style.display='block'; document.getElementById('schedule').style.display='block';"><i class="fa fa-plus"></i></a></span>

		<span class="w3-col l1 m1 s1" id="schedule" style="display: none;"><a onclick="document.getElementById('schedule').style.display='none'; document.getElementById('set_alarm').style.display='none'; document.getElementById('alarm_list').style.display='block'; document.getElementById('day_list').style.display='none'; document.getElementById('alarm_view').style.display='none'; document.getElementById('new').style.display='block';"><i class="fa fa-clock-o"></i></a></span>

	</header>

	
	<section id="alarm_list" class="w3-col" style="margin-top: 64px; display: block;">
		
		<ul class="w3-ul">
		
			<?php

				foreach ($alarm_list as $alarm_id => $alarm_param) {

					if($alarm_param[1] < 10){
						$alarm_param[1] = "0{$alarm_param[1]}";
					}

					if($alarm_param[2] < 10){
						$alarm_param[2] = "0{$alarm_param[2]}";
					}

					echo "<li class='w3-col' ng-click=open_alarm_details(\$event) data-alarm-id='{$alarm_id}' data-alarm-hh='{$alarm_param[1]}' data-alarm-mm='{$alarm_param[2]}' data-alarm-nt='{$alarm_param[3]}' data-alarm-day='{$alarm_param[0]}'>
					<span class='w3-col l11 m11 s11'>{$alarm_param[0]} <br>{$alarm_param[1]}:{$alarm_param[2]}<br><a class='w3-small'>{$alarm_param[3]}</a></span>
					<span class='w3-col l1 m1 s1' style='vertical-align: center;'><i class='fa fa-minus w3-large' ng-click=remove_alarm(\$event) data-alarm-id='{$alarm_id}'></i></span>
					</li>
					";

				}
			?>
			

		
		</ul>

	</section>


	<section id="day_list" class="w3-col w3-animate-fade" style="margin-top: 64px; display: none;">
		
		<ul class="w3-ul w3-center">
			
			<?php

				foreach ($days as $id => $day) {
					echo "<li ng-click=open_set_view(\$event) class='w3-col l12 m12 s12 w3-large' data-day-id={$day[0]} data-day-text={$day[1]}>{$day[1]}</li>";
				}
			?>
			
					
		</ul>

	</section>

	<section id="set_alarm" class="w3-col w3-animate-fade" style="margin-top: 64px; display: none;">
		

		<div class="w3-container">
			
			<a class="w3-right" onclick="document.getElementById('set_alarm').style.display='none'; document.getElementById('day_list').style.display='block';">
					<i class="fa fa-chevron-up w3-large"></i>
			</a>

			<elon class="w3-clear"></elon>

			<form class="w3-container" action="<?php echo "{$absPath}process/proc1/set_alarm.php" ?>" method="post" class="w3-form w3-col l9 m12 s12">
				
				<e class="w3-col l3 m6 s6 w3-padding" ><select class="w3-input w3-transparent w3-xlarge w3-col l12 s12 m12" ng-model="hour" autofocus="true">
					
					<?php

						for ($i=0; $i < 24 ; $i++) { 

							if($i < 10)
								$c = "0{$i}";
							else
								$c = $i;

							echo "<option value='$i'>$c</option>";
						}
					?>

				</select></e>

				<e class="w3-col l3 m6 s6 w3-padding" ><select class="w3-input w3-transparent w3-xlarge w3-col l12 s12 m12" ng-model="minute">
					
					<?php

						for ($i=0; $i < 60 ; $i++) { 

							if($i < 10)
								$c = "0{$i}";
							else
								$c = $i;

							echo "<option value='$i'>$c</option>";
						}
					?>

				</select></e><br>

				<e class="w3-padding"><textarea maxlength="20" class="w3-input l6 s12 m12 w3-round w3-small" style="resize: vertical;" ng-model="note">Note</textarea></e>

				<p class="w3-center"><button class="w3-btn w3-round w3-white w3-padding" ng-click=set_alarm($event)>Set</button></p>

			</form>


		</div>

	</section>

	<section id="alarm_view" class="w3-col w3-animate-fade" style="margin-top: 64px; display: none;">
		

		<div class="w3-container">
			
			<a class="w3-right" onclick="document.getElementById('alarm_view').style.display='none'; document.getElementById('alarm_list').style.display='block';">
					<i class="fa fa-chevron-up w3-large"></i>
			</a>


			<elon class="w3-clear"></elon>

			<p class="w3-xxlarge w3-center">{{hh}}:{{mm}}</p>
			<p class="w3-medium w3-center">{{dayw}} - {{nt}}</p>
			
		</div>

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

<script type="text/javascript" src="<?php echo "{$absPath}view/asset/js/angularApp/alarm.js" ?>"></script>


</html>