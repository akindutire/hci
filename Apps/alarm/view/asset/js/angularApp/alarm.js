var app = angular.module("app",["ngSanitize"]);

app.controller("ctrl",function($scope,$http,$location,$sce,$compile){
	
	$scope.day = 0;
	

	$scope.open_set_view = function(e){

		$scope.day=e.target.getAttribute('data-day-id');
		$scope.dayt = e.target.getAttribute('data-day-text');

		document.getElementById('day_list').style.display='none';
		document.getElementById('set_alarm').style.display='block';

	};


	$scope.set_alarm = function(e){

		e.preventDefault();
		

		if($scope.hour >= 0 && $scope.minute >= 0){

			$scope.url = e.target.parentElement.parentElement.getAttribute('action');
		
			$scope.data = {};
			
			$scope.data.hour = $scope.hour;
			$scope.data.minute = $scope.minute;
			$scope.data.note = $scope.note;
			$scope.data.day = $scope.day;
			
			$scope.data = JSON.stringify($scope.data);
	       

	        $scope.config = { 'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'};
		    
			$http.post($scope.url,$scope.data,$scope.config)
			.then(
				function(response){

					
					if (response.data.sx == 1) {
						
						$scope.h = $scope.hour;
						if($scope.hour < 10){
							$scope.h = "0"+$scope.hour;
						}

						$scope.m = $scope.minute;
						if($scope.minute < 10){
							$scope.m = "0"+$scope.minute;
						}	

						template = "<li class='w3-col' ng-click=open_alarm_details(\$event) data-alarm-id="+response.data.key+" data-alarm-hh="+$scope.h+" data-alarm-mm="+$scope.m+" data-alarm-nt="+$scope.note+" data-alarm-day="+$scope.dayt+">";
						template += "<span class='w3-col l11 m11 s11'>"+$scope.dayt+" <br>"+$scope.h+":"+$scope.m+"<br><a class='w3-small'>"+$scope.note+"</a></span>"; 
						template += "<span class='w3-col l1 m1 s1' style='vertical-align: center;'><i ng-click=remove_alarm(\$event) class='fa fa-minus' data-alarm-id="+response.data.key+"></i></span>";
						template += "</li>";

						document.querySelector('#alarm_list ul').insertAdjacentHTML('afterbegin',template);
						document.getElementById('set_alarm').style.display = 'none';
						document.getElementById('schedule').style.display='none';
						document.getElementById('new').style.display='block';
						
						$compile(document.querySelector('#alarm_list ul'))($scope);
						document.getElementById('alarm_list').style.display = 'block';


					}else{

						alert("Opeartion failed, retry");
						
					}
				},
				function(response){

					//console.log(response.statusText);

				}
			);

		}else{
			alert("No time selected");
		}

	};


	$scope.open_alarm_details = function(e){

		$scope.alarm_id = e.target.parentElement.getAttribute('data-alarm-id');
		$scope.hh = e.target.parentElement.getAttribute('data-alarm-hh');
		$scope.mm = e.target.parentElement.getAttribute('data-alarm-mm');
		$scope.nt = e.target.parentElement.getAttribute('data-alarm-nt');
		$scope.dayw = e.target.parentElement.getAttribute('data-alarm-day');

		document.querySelector('#alarm_list').style.display='none';
		document.querySelector('#alarm_view').style.display='block';
		
	};

	$scope.remove_alarm = function(e){

		e.stopImmediatePropagation();
		
		$scope.alarm_id = e.target.getAttribute('data-alarm-id');

		$scope.url = "/hci/Apps/alarm/process/proc1/remove_alarm.php";
		
		$scope.data = {};

		$scope.data.alarm_id = $scope.alarm_id;
		
		$scope.data = JSON.stringify($scope.data);
		
		$http.post($scope.url,$scope.data)
			.then(
				function(response){

					console.log(response.data);
					
					if (response.data.sx == 1) {
						
						e.target.parentElement.parentElement.remove();


					}else{

						alert("Opeartion failed, retry");
						
					}
				},
				function(response){

					console.log(response.statusText);

				}
			);

	};

	$scope.check_alarm = function(){

			var date=new Date();

			var hh = date.getHours();
			var mm = date.getMinutes();
			var dd = (date.getDay())+1;

			
			$scope.data = {};
			$scope.url = "/hci/Apps/alarm/process/proc1/check_alarm.php";
		
			$scope.data.hour = hh;
			$scope.data.minute = mm;
			$scope.data.day = dd;
			
			$scope.data = JSON.stringify($scope.data);
	       

	        $scope.config = { 'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'};
		    
			$http.post($scope.url,$scope.data,$scope.config)
			.then(
				function(response){
					
					console.log(response.data);

					if (response.data.sx == 1) {
						
						$scope.hh = hh;
						$scope.mm = mm;
						$scope.nt = response.data.note;
						$scope.dayw = response.data.alarm_day;
						
						document.querySelector('#alarm_sound').play();
						document.querySelector('#alarm_alert').style.display = 'block';

					}else{
						
						
					}
				},
				function(response){

					console.log(response.statusText);

				}
			);

	};

	$scope.monitor_alarm = function(){

		setInterval(function(){$scope.check_alarm()},60000);

	};

	$scope.monitor_alarm();
	
});