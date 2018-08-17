var app = angular.module("app",["ngFileUpload","ngSanitize"]);

app.controller("ctrl",function($scope,$http,$location,$sce,$compile){
	
$scope.process_file = function(file,e){

		e.preventDefault();

		
		if ( $scope.file.size > 0 ){

			

			if($scope.file.type == 'audio/mp3' || $scope.file.type == 'audio/ogg' || $scope.file.type == 'audio/aac' || $scope.file.type == 'audio/x-flac'){

				document.querySelector('#player').style.display = 'none';
				document.querySelector('#audio').style.display = 'block';
				document.querySelector('#audio_f') = $scope.file;

			}else if($scope.file.type == 'video/mp4' || $scope.file.type == 'video/mkv' || $scope.file.type == 'video/mp3' || $scope.file.type == 'video/flv' || $scope.file.type == 'videoo/webm'){

				document.querySelector('#player').style.display = 'none';
				document.querySelector('#video').style.display = 'block';
				document.querySelector('#video_f') = $scope.file;

			}else{

				alert("Unsupported Media file");
			}
		
		}else{
			//$scope.feedback = "Error processing file";
		}

	};	
	
});