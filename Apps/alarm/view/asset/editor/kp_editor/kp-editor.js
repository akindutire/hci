(function(global,angular){

 		function kp(){

 		}


		kp.prototype = {

			
			kp_editor : function(){

			 	textareaElem = document.querySelector('#kp-editor');

			 	if (textareaElem.getAttribute('kp-maxword') != null) {
					kp.prototype.maximumWord = 	textareaElem.getAttribute('kp-maxword');		 		
			 	}else{
			 		kp.prototype.maximumWord = 	50000;
			 	}



			 	if (textareaElem.getAttribute('kp-height') != null) {
					kp.prototype.editorHeight = textareaElem.getAttribute('kp-height');		 		
			 	}else{
			 		kp.prototype.editorHeight = 	270;
			 	}



			 	if (textareaElem.getAttribute('kp-media') != null) {
					kp.prototype.editorMedia = (textareaElem.getAttribute('kp-media') == "true");		 		
			 	}else{
			 		kp.prototype.editorMedia = 	true;
			 	}



			 	if (textareaElem.getAttribute('kp-emoji') != null) {
					kp.prototype.editorEmoji = (textareaElem.getAttribute('kp-emoji') == "true");
	
			 	}else{
			 		kp.prototype.editorEmoji = 	true;
			 	}


			 	if (textareaElem.getAttribute('kpf-color') != null) {
					kp.prototype.editorForeColor = (textareaElem.getAttribute('kpf-color') == "true");		 		
				 }else{
			 		kp.prototype.editorForeColor = 	true;
			 	}

			
			 	editableDivElem = document.createElement("div");

			 	editableDivElem.setAttribute('ng-controller','kp_editor_controller');
			 	editableDivElem.setAttribute('ng-init','kp_editor_file_failed_response=false');


			 	topofdiv = document.createElement("div");
			 	editableDivElem.appendChild(topofdiv);
			 	topofdiv.setAttribute("id","kp-editor-header");
			 	topofdiv.setAttribute("height", "auto");
			 	topofdiv.setAttribute("background", "#ffffff");
			 	topofdiv.setAttribute("padding", "8px");
			 	topofdiv.setAttribute("width", "100%");
			 	topofdiv.setAttribute("border-bottom", "1px solid #ccc");


			 	topofdiv_acc = "<p style='margin:0px;'><span title='Bold text' id='kp_editor_bold' style='padding:8px;'><i class='fa fa-bold'></i></span>"; 
			 	topofdiv_acc += "<span id='kp_editor_italic' title='italic text' style='padding:8px;'><i class='fa fa-italic'></i></span>";
			 	topofdiv_acc += "<span id='kp_editor_underline' title='Underline text' style='padding:8px;'><i class='fa fa-underline'></i></span>";
			 	topofdiv_acc += "<span id='kp_editor_strikethrough' title='StrikeThrough text' class='w3-hide-small' style='padding:8px;'><i class='fa fa-strikethrough'></i></span>";
			 
			 	topofdiv_acc += "<span id='kp_editor_subscript' title='subscript' class='w3-hide-small' style='padding:8px;'><i class='fa fa-subscript'></i></span>";
			 	topofdiv_acc += "<span id='kp_editor_superscript' title='superscript' class='w3-hide-small' style='padding:8px;'><i class='fa fa-superscript'></i></span>";
			 	
			 	topofdiv_acc += "<span id='kp_editor_undo' title='Undo' style='padding:8px;'><i class='fa fa-undo'></i></span>";
			 	topofdiv_acc += "<span id='kp_editor_redo' title='Redo' style='padding:8px;'><i class='fa fa-repeat'></i></span>";
			 	topofdiv_acc += "<span id='kp_editor_link' title='Insert Link' style='padding:8px;'><i class='fa fa-link'></i></span>";
			 	
			 	topofdiv_acc += "<span id='kp_editor_align_left' title='Align left' class='w3-hide-small' style='padding:8px;'><i class='fa fa-align-left'></i></span>";
			 	topofdiv_acc += "<span id='kp_editor_align_center' title='Align center' class='w3-hide-small' style='padding:8px;'><i class='fa fa-align-center'></i></span>";
			 	topofdiv_acc += "<span id='kp_editor_align_right' title='Align right' class='w3-hide-small' style='padding:8px;'><i class='fa fa-align-right'></i></span>";
			 	topofdiv_acc += "<span id='kp_editor_justify' title='Justify' class='w3-hide-small' style='padding:8px;'><i class='fa fa-align-justify'></i></span>";

			 	topofdiv_acc += "<span id='kp_editor_unlink' title='Remove link' class='w3-hide-small' style='padding:8px;'><i class='fa fa-unlink'></i></span>";
			 	
			 	if(KPEDITOR.editorForeColor == true){
			 		topofdiv_acc += "<span style='padding:8px;'><a id='kp_editor_fore_color' title='Font color'><i class='fa fa-font' style='color:#333366;'></i></a><input id='kp_editor_colorpicker' type='color' style='padding:0px; width:0px; height:0px;'></span>";
			 	}

			 	if(KPEDITOR.editorMedia == true){

				 	topofdiv_acc += "<span id='kp_editor_picture' title='Insert photo/video' style='padding:8px;'><i class='fa fa-picture-o'></i></span>";
				}

				if(KPEDITOR.editorEmoji == true){ 	
			 		topofdiv_acc += "<span emoji-picker='kp_editor_text_emoji' title='Emoji' placement='left' title='Emoji' recent-limit='15' output-format='unicode' id='emoji_pack' on-change-func='insert_emoji' style='position: relative;'></span>";
			 	}
				 	         
			 	topofdiv.innerHTML = topofdiv_acc;


			 	editableDivElem0 = document.createElement("iframe");

			 	editableDivElem.appendChild(editableDivElem0);


			 	
			 	editableDivElem0.setAttribute("frameborder",0);
			 	editableDivElem0.setAttribute("id","kp-editor-body");
			 	editableDivElem0.setAttribute("name","kp_context");
			 	editableDivElem0.setAttribute("width","100%");
			 	editableDivElem0.setAttribute("height", KPEDITOR.editorHeight+"px");
				editableDivElem.setAttribute('ng-change','monitor_editor_empty()');
				editableDivElem.setAttribute('ng-model','iskisk');
				editableDivElem0.setAttribute("background", "white");
				editableDivElem0.style.border = "1px solid #ccc";
				


			 	bottomofdiv = document.createElement("div");
			 	editableDivElem.appendChild(bottomofdiv);
			 	bottomofdiv.setAttribute("id","kp-editor-footer");
			 	bottomofdiv.setAttribute("height", "auto");
				bottomofdiv.setAttribute("background", "#fffddd");
				bottomofdiv.setAttribute("width", "100%");

		
			 	bottomofdiv.innerHTML = "<p style='margin:0px; padding:0px; width:100%;' class='w3-small w3-text-gray'> <span class='w3-col l3 m3 s4' id='typed_words'>...</span> <span style=' ' class='w3-col l6 m6 s4 w3-center'> <a id='kp_editor_clear_context' ng-click=kp_gabage_collector() class='w3-btn w3-round w3-gray w3-small' style='padding:4px; visibility:hidden; '>Clear All</a> </span> <span id='max_word' class='w3-col l3 m3 s4' style='text-align:right;'></span></p>";

			 	editableDivElem.setAttribute("id","kp-editor");
			 	editableDivElem.setAttribute("width","100%");
			 	editableDivElem.setAttribute("border-radius","2px");
			 	editableDivElem.setAttribute("border","1px solid gray");
			 	editableDivElem.setAttribute("padding","0px");
			 	editableDivElem.setAttribute("margin","0px");
			 	editableDivElem.setAttribute("height","auto");

			 	if(document.querySelector('script#kp-editor') != null){

			 		textareaElem.parentNode.replaceChild(editableDivElem,textareaElem);
			 		
			 		if(angular != 'undefined'){

					 	imageModalOfMediaDiv = document.createElement("div");
					 	
					 	firstChildOfBody = document.querySelector('body').firstChild;
					 	document.querySelector('body').insertBefore(imageModalOfMediaDiv,firstChildOfBody);

					 	imageModalOfMediaDiv.setAttribute("id","Dialog_kp_editor_picture_video");
					 	imageModalOfMediaDiv.setAttribute("class", "w3-modal");
					 	imageModalOfMediaDiv.setAttribute("style", "display:none;");
						
						pictureDialog = "<div ng-controller='kp_editor_media_controller' ng-init='kp_editor_file_failed_response=false;' class='w3-modal-content w3-round' style='margin:;'>";
						pictureDialog += "<p style='padding:4px; margin:0px; border-radius:4px 4px 0px 0px;' class='w3-gray'> <span class='w3-small w3-text-white'>Image / Video</span> <span class='w3-right w3-large'><a w3-text-white' onclick=KPEDITOR.hide_media_box()><i class='fa fa-close'></i></a></span> </p>";
						
						pictureDialog += "<div class='w3-padding w3-container' style='position:relative; height:auto; margin:0px; border: 0px;'>";
						
						pictureDialog += "<a id='media_preview_dialog_loading_space' style='position:absolute; top:40%; left:45%; display: none; z-index:1;'><i class='w3-text-green fa fa-circle-o-notch fa-spin fa-3x fa-fw'></i></a>";
						
						
						pictureDialog += "<div class='w3-center w3-display-container w3-margin-top' id='media_preview_canvas_px' class='w3-col l12 m12 s12 w3-round w3-card-4 w3-border w3-padding' style='height: 100px; width: 100%; display: none;'>";
							
						//pictureDialog += "<a class='w3-display-topmiddle w3-small' style='width:50%;'><form>Size:<input type='date'>%</form></a>";
								
						pictureDialog += "<a class='w3-display-topleft w3-small w3-white'>Preview</a>";
						pictureDialog += "<a class='w3-display-topright w3-small w3-white w3-text-red' ng-click=close_preview('px')><i class='fa fa-times'></i> Close</a>";
						pictureDialog += "<br><hr>";
						
						
						pictureDialog += "<div class='CropArea' style='background: #E4E4E4; height: 300px; width: 100%; position: relative;'>";
									
						pictureDialog += "<p class='w3-center' height='' width='auto' style='overflow-x:auto;'><img ngf-src='kp_editor_uploadedfileURL' width='auto' height='300px'></p>";
						pictureDialog += "<p class='w3-center w3-col l12 m12 s12' id='btnInsertMedia'><button class='w3-btn kp-usr-btn w3-round w3-small' type='button' ng-click=upload_processed_file('px')>Insert</button></p>";
						pictureDialog += "<p class='w3-center w3-col l12 m12 s12' id='btnInsertMediathroughLink'><button class='w3-btn kp-usr-btn w3-round w3-small' type='button' ng-click=insert_media_through_link()>Insert</button></p>";
					
						pictureDialog += "</div>";

						pictureDialog += "</div>";



						pictureDialog += "<div class='w3-center w3-display-container w3-margin-top' id='media_preview_canvas_vid' class='w3-col l12 m12 s12 w3-round w3-card-4 w3-border w3-padding' style='height: 100px; width: 100%; display: none;'>";
												
						pictureDialog += "<a class='w3-display-topleft w3-small w3-white'>Preview</a>";
						pictureDialog += "<a class='w3-display-topright w3-small w3-white w3-text-red' ng-click=close_preview('vid')><i class='fa fa-times'></i> Close</a>";
						pictureDialog += "<br>";
						
						//pictureDialog += "<p class='w3-container w3-center w3-col l12 s12 m12' style='width:50%;'>Size:<input type='number' min=10 max=100 value=100></p>";


						pictureDialog += "<div class='CropArea' style='background: #E4E4E4; height: 300px; width: 100%; position: relative;'>";
						
						pictureDialog += "<p class='w3-center' style='overflow-x:auto;'><video style='position:relative;' height='300px' width='auto' ngf-src='kp_editor_file' ngf-accept=\"'video/*'\" controls autoplay> </video></p>";					
						pictureDialog += "<p class='w3-center w3-col l12 m12 s12' id='btnInsertMedia'><button class='w3-btn kp-usr-btn w3-round w3-small' type='button' ng-click=upload_processed_file('vid')>Insert</button></p>";
					
						pictureDialog += "</div>";

						pictureDialog += "</div>";

						

						pictureDialog += "<div class='w3-col l12 m12 s12 w3-round w3-card-4 w3-border w3-padding' id='media_selection_container'>";

						pictureDialog += "<p class='w3-center w3-text-red w3-small' ng-if=kp_editor_file_failed_response><i class='fa fa-exclamation-triangle'></i> File too large/Not Supported</p>";
						pictureDialog += "<div class='w3-center w3-padding-32' style='border:1px dashed grey' name='kp_editor_file' ngf-drop ngf-drag-over-class=\"'dragover'\" ngf-select ngf-change=process_media('local') ng-model='kp_editor_file' ngf-max-size='25MB' ngf-min-height=100 ngf-multiple='false' ngf-accept=\"'image/*,video/*'\" ngf-pattern=\"'image/*,video/*'\" style='height: 100px; width: 100%; position: relative; cursor: pointer;'>";					
						pictureDialog += "<i class='fa fa-plus w3-xxlarge w3-text-gray' style=''></i> <br> <span class='w3-small'>Choose Photo (5MiB) / Video (20MiB)</span> </div>";
						
						pictureDialog += "<hr><p class='w3-center'><a class='w3-small'>OR Enter Image Url</a><br>";
						pictureDialog += "<p class='w3-center w3-bar'><form name='kp_editorFrm'><input type='url' ng-model=kp_editor_file_path name='kp_editor_file_path' required height='40px' class='w3-input w3-small w3-border w3-round w3-margin-bottom w3-col l8 m6 s12 w3-bar-item'> <elon style='text-align : center;'> <button type='button' ng-disabled='!(kp_editorFrm.kp_editor_file_path.$valid)' class='w3-btn w3-gray w3-small w3-round w3-margin-left w3-col l2 m3 s5 w3-bar-item' id='kp_editor_preview_media' ng-click=process_media('remote')>Preview</button><button type='button' ng-disabled='!(kp_editorFrm.kp_editor_file_path.$valid)' class='w3-btn w3-green w3-small w3-margin-left w3-round w3-col l1 m2 s5 w3-bar-item' id='kp_editor_insert_media' ng-click=insert_media_through_link()>Insert</button></elon> </form> </p></p>";
						//pictureDialog += "<p class='w3-center w3-blue' style='height: 1px; width: 0%; padding: 0px;margin: 0px;' id='loading_space'></p>";						
						
						pictureDialog += "</div>";

						
						pictureDialog += "</div>";

						 	
					 	
					 	imageModalOfMediaDiv.innerHTML=pictureDialog;

					 }else{

					 	console.log("Angular Reference Missing");
					 }


					kp_context.document.designMode = "on";
					kp_context.document.body.focus();

					
					document.querySelector('#kp-editor-footer p span#max_word').innerHTML = 'Max word: '+KPEDITOR.maximumWord;
					

			 	}else{
			 		console.log("Missing param: Script inclusion expect id=kp-editor");
			 	}

			 	kp_context.document.body.style = "padding:16px 8px;";

				kp_editor_bold.addEventListener("click",function(){ kp_context.document.execCommand('bold'); kp_context.document.body.focus(); },false);
				kp_editor_italic.addEventListener("click",function(){ kp_context.document.execCommand('italic'); kp_context.document.body.focus(); },false);
				kp_editor_underline.addEventListener("click",function(){ kp_context.document.execCommand('underline'); kp_context.document.body.focus(); },false);
				kp_editor_strikethrough.addEventListener("click",function(){ kp_context.document.execCommand('strikeThrough'); kp_context.document.body.focus(); },false);
				kp_editor_undo.addEventListener("click",function(){ kp_context.document.execCommand('undo'); kp_context.document.body.focus(); },false);
				kp_editor_redo.addEventListener("click",function(){ kp_context.document.execCommand('redo'); kp_context.document.body.focus(); },false);
				kp_editor_superscript.addEventListener("click",function(){ kp_context.document.execCommand('Superscript'); kp_context.document.body.focus(); },false);
				kp_editor_subscript.addEventListener("click",function(){ kp_context.document.execCommand('Subscript'); kp_context.document.body.focus(); },false);
				kp_editor_link.addEventListener("click",function(){ kp_context.document.execCommand('CreateLink',false,prompt("Enter Url","http://")); kp_context.document.body.focus(); },false);
				kp_editor_unlink.addEventListener("click",function(){ kp_context.document.execCommand('Unlink'); kp_context.document.body.focus(); },false);
				
				kp_editor_align_left.addEventListener("click",function(){ kp_context.document.execCommand('justifyLeft'); kp_context.document.body.focus(); },false);
				kp_editor_align_center.addEventListener("click",function(){ kp_context.document.execCommand('justifyCenter'); kp_context.document.body.focus(); },false);
				kp_editor_align_right.addEventListener("click",function(){ kp_context.document.execCommand('justifyRight'); kp_context.document.body.focus(); },false);
				kp_editor_justify.addEventListener("click",function(){ kp_context.document.execCommand('justifyFull'); kp_context.document.body.focus(); },false);
				
				if(KPEDITOR.editorForeColor == true){

					kp_editor_fore_color.addEventListener("click",function(event){ 
							
						//document.querySelector('span input#kp_editor_colorpicker').removeAttribute('hidden');
						document.querySelector('span input#kp_editor_colorpicker').click();
					
						
					},false);


					kp_editor_colorpicker.addEventListener("change",function(){

						col = document.querySelector('span input#kp_editor_colorpicker').value;

						if (kp_context.document.execCommand('foreColor',false,col)) {

							document.querySelector('span a#kp_editor_fore_color i').style.color = col;

						}else{
							console.log("Fore Color not changed");
						}


						kp_context.document.body.focus();
							

					},false);

				}
				
				if(KPEDITOR.editorMedia == true){
				
					kp_editor_picture.addEventListener("click",function(){

							
						document.querySelector('div#Dialog_kp_editor_picture_video').style.display="block";
						document.querySelector('#media_preview_canvas_px p#btnInsertMedia button').removeAttribute('disabled');
						document.querySelector('#media_preview_canvas_vid p#btnInsertMedia button').removeAttribute('disabled');
						document.querySelector('#media_preview_canvas_px p#btnInsertMediathroughLink button').removeAttribute('disabled');

						
					},false);

				}
				
				/*Context Limiter*/

				kp_context.document.body.addEventListener("keydown",function(e){
					
					no_of_words = kp_context.document.body.innerHTML.split(' ').length;

					if(no_of_words >= KPEDITOR.maximumWord && e.which != 8){
					
						e.preventDefault();
						
					}

				});
				
				kp_context.document.body.addEventListener("input",function(e){
					
					no_of_words = kp_context.document.body.innerHTML.split(' ').length;

					if(kp_context.document.body.innerHTML.length > 0){
						
						document.querySelector('span a#kp_editor_clear_context').style.visibility = 'visible';						

					}else{

						document.querySelector('span a#kp_editor_clear_context').style.visibility = 'hidden';	
					}


					if(no_of_words == 1){
						document.querySelector('#kp-editor-footer p span#typed_words').innerHTML = no_of_words+' word | ';						
					}else{
						document.querySelector('#kp-editor-footer p span#typed_words').innerHTML = no_of_words+' words | ';
					}

				});


			},

			hide_media_box : function(){

				document.getElementById('Dialog_kp_editor_picture_video').style.display='none';
			},

			setContext : function(context){

				kp_context.document.execCommand('inserthtml',false,context);
				kp_context.document.body.focus();
			},

			getContext : function(){

				return kp_context.document.body.innerHTML;

			},

			clearContext : function(){

				kp_context.document.body.innerHTML = '';
				kp_context.document.body.focus();
				document.querySelector('#kp-editor-footer p span#typed_words').innerHTML = ' ... ';	
				document.querySelector('span a#kp_editor_clear_context').style.visibility = 'hidden';					
				
			}	

		};

		
		kp.prototype.init = function(module_reference,media_storage_path){

			if(typeof(module_reference) != 'undefined'){
				
				kp.prototype.angular_app = module_reference;
				KPEDITOR.kp_editor();

				
				/*Angular Code -Controller 1*/
				KPEDITOR.angular_app.controller('kp_editor_controller',function($rootScope,$scope,$http,$location,$sce){ 


					$scope.insert_emoji = function(){
						
						if(window.kp_context.document.execCommand('insertText',false,$scope.kp_editor_text_emoji)){
							
							window.kp_context.document.body.focus();
							
						}else{

							window.kp_context.document.body.focus();
							console.log('something went wrong, Editor freeze');
						
						}

					};


					$scope.kp_gabage_collector = function(){

						if(confirm("Clear all context") == true){

							thisScriptSrc = document.querySelector('script#kp-editor').src;
							thisScriptPath = thisScriptSrc.split('/').slice(0, -1).join('/')+'/';
							$scope.url = thisScriptPath+'kp_editor_gabage_collector.php';

							$scope.data = {};
							$scope.data.fileSrc = [];

							
							childOfiframe = window.kp_context.document.body.childNodes;
							
							if(childOfiframe.length != 0){

								childOfiframe.forEach (function(element,index,childOfiframe){

									if(element.src != null){
										$scope.data.fileSrc.push(element.src);									
									}

								});
							}
							
							$http.post($scope.url,$scope.data)
							.then(function(response){

								//console.log(response.data);

								if (response.data.sx == 1) {

									console.log("references cleared");
								}else{

									console.log('An unresolved request');
								}
							},
							function(status){

								console.log(status.statusText);
							});

							window.kp_context.document.body.innerHTML = '';
							window.kp_context.document.body.focus();
							document.querySelector('#kp-editor-footer p span#typed_words').innerHTML = ' ... ';
							document.querySelector('span a#kp_editor_clear_context').style.visibility = 'hidden';
							
							

							
						}else{

							window.kp_context.document.body.focus();
						}	
					
					};



				 });



				/*Angular Code -Controller 2*/
				KPEDITOR.angular_app.controller('kp_editor_media_controller',function($rootScope,$scope,Upload,$http,$location,$sce){


					if (typeof(Upload) != 'undefined') {

						

						$scope.process_media = function(means){

							
							document.getElementById('media_preview_dialog_loading_space').style.display='block';
							
							if($scope.kp_editor_file != null){

								$scope.kp_editor_file_failed_response = false;

								if(means == 'local'){

									if ( $scope.kp_editor_file ){
										
										$scope.kp_editor_uploadedfileURL = $scope.kp_editor_file;
										document.getElementById('media_preview_dialog_loading_space').style.display='none';
							
										
										if ($scope.kp_editor_file.type == 'image/jpeg' || $scope.kp_editor_file.type == 'image/png' || $scope.kp_editor_file.type == 'image/gif' || $scope.kp_editor_file.type == 'image/jpg' || $scope.kp_editor_file.type == 'image/bmp') {
											
											document.querySelector('#media_preview_canvas_px p#btnInsertMedia').style.display = 'block';
											document.querySelector('#media_preview_canvas_px p#btnInsertMedia button').focus();
											document.getElementById('btnInsertMediathroughLink').style.display = 'none';								
											document.getElementById('media_selection_container').style.display = 'none';
											document.getElementById('media_preview_canvas_vid').style.display = 'none';
											document.getElementById('media_preview_canvas_px').style.display = 'block';
											
										
										}else if($scope.kp_editor_file.type == 'video/mp4' || $scope.kp_editor_file.type == 'video/ogg' || $scope.kp_editor_file.type == 'video/3gp' || $scope.kp_editor_file.type == 'video/3gpp' || $scope.kp_editor_file.type == 'video/x-flv' || $scope.kp_editor_file.type == 'video/jpg' || $scope.kp_editor_file.type == 'video/jpm' || $scope.kp_editor_file.type == 'video/mpeg' || $scope.kp_editor_file.type == 'video/webm' || $scope.kp_editor_file.type == 'video/webp'){

											document.querySelector('#media_preview_canvas_vid p#btnInsertMedia').style.display = 'block';
											document.querySelector('#media_preview_canvas_vid p#btnInsertMedia button').focus();
											document.getElementById('media_selection_container').style.display = 'none';
											document.getElementById('media_preview_canvas_px').style.display = 'none';
											document.getElementById('media_preview_canvas_vid').style.display = 'block';
										
										}else{

											alert('Unsupported Media');
										}

									}else{
										console.log("Error processing file");
									}

								}else if(means == 'remote'){
									
									$scope.kp_editor_uploadedfileURL = $scope.kp_editor_file_path;

									document.querySelector('#media_preview_canvas_px p#btnInsertMedia').style.display = 'none';
									document.getElementById('btnInsertMediathroughLink').style.display = 'block';
									document.getElementById('btnInsertMediathroughLink').focus();
									document.getElementById('media_selection_container').style.display = 'none';
									document.getElementById('media_preview_canvas_vid').style.display = 'none';
									document.getElementById('media_preview_canvas_px').style.display = 'block';

								}

							}else{

								$scope.kp_editor_file_failed_response = true;
								document.getElementById('media_preview_dialog_loading_space').style.display='none';
							}

						};

						$scope.close_preview = function(type){

							if (type == 'px') {

								document.getElementById('media_preview_canvas_px').style.display='none'; 
								$scope.kp_editor_file = null;
								document.getElementById('media_selection_container').style.display='block';

							
							}else if(type == 'vid'){

								document.getElementById('media_preview_canvas_vid').style.display='none'; 
								document.querySelector('#media_preview_canvas_vid video').pause();
								document.getElementById('media_selection_container').style.display='block';
							
							}else{

								console.log("Unknown Media Box");
							}

							document.getElementById('media_preview_dialog_loading_space').style.display='none';
							document.querySelector('#media_preview_canvas_px #btnInsertMedia').removeAttribute('disabled');
							document.querySelector('#media_preview_canvas_vid #btnInsertMedia').removeAttribute('disabled');
							document.querySelector('#media_preview_canvas_px #btnInsertMediathroughLink').removeAttribute('disabled');

						};

						$scope.upload_processed_file = function(type){
		
							$scope.data = {};

							$scope.data.file = $scope.kp_editor_file;
													
							$scope.data.storage = media_storage_path;
							
							document.getElementById('media_preview_dialog_loading_space').style.display='block';
							
							document.querySelector('#media_preview_canvas_px #btnInsertMedia button').disabled = 'disabled';
							document.querySelector('#media_preview_canvas_vid #btnInsertMedia button').disabled = 'disabled';
							document.querySelector('#media_preview_canvas_px #btnInsertMediathroughLink button').disabled = 'disabled';

							thisScriptSrc = document.querySelector('script#kp-editor').src;
							thisScriptPath = thisScriptSrc.split('/').slice(0, -1).join('/')+'/';
							$scope.url = thisScriptPath+'kp_editor_media_processor.php';

							Upload.upload({url:$scope.url,data:$scope.data })
							.then(
								function(response){
																											
									if(response.data.success == 1){
										
										if(response.data.file_type == 'px'){
										
											if($scope.kp_editor_file.$ngfWidth < 500 && window.screen.availWidth < 500){
											
												$scope.resized = '100%';
											
											}else if($scope.kp_editor_file.$ngfWidth < 500 && window.screen.availWidth > 500){
												
												$scope.resized = 'auto';
											
											}else{

												$scope.resized = '70%';

											}	

											$scope.embed = "<img width='"+$scope.resized+"' src='"+response.data.photosource+"'/><br><br>";
											
											if(window.kp_context.document.execCommand('inserthtml',false,$scope.embed)){
												
												document.getElementById('media_preview_dialog_loading_space').style.display='none';
												document.getElementById('media_preview_canvas_px').style.display = 'none';
												document.getElementById('media_selection_container').style.display = 'block';
												document.getElementById('Dialog_kp_editor_picture_video').style.display='none';

											}else{
												console.log("Something went wrong, Editor freeze");
											}	
										
										}else if (response.data.file_type == 'vid'){

											if(window.screen.availWidth < 500){
											
												$scope.resized = '100%';
											
											}else{
											
												$scope.resized = '70%';
											
											}	
											
											$scope.embed = "<video width='"+$scope.resized+"' src='"+response.data.photosource+"' controls> </video><br><br>";
											
											if(window.kp_context.document.execCommand('inserthtml',false,$scope.embed)){


												document.getElementById('media_preview_dialog_loading_space').style.display='none';
												document.querySelector('#media_preview_canvas_vid video').pause();
												document.getElementById('media_preview_canvas_vid').style.display = 'none';
												document.getElementById('media_selection_container').style.display = 'block';
												document.getElementById('Dialog_kp_editor_picture_video').style.display='none';

											}else{
												console.log("Something went wrong, Editor freeze");
											}	
										}

										window.kp_context.document.body.focus();
										

								 	}else{
								 		
								 		document.getElementById('media_preview_dialog_loading_space').style.display='none';
								 		console.log(response.data.msg);
								 	
								 	}

								 	

								},function(response){ 

								 	console.log(response.statusText);

								},function(evt){

								 	$scope.progress = parseInt(100* evt.total/evt.loaded);
								 	//console.log($scope.progress+" % Uploaded");

								}
							);
						
							
					};

					$scope.insert_media_through_link = function(){

						if(window.kp_context.document.execCommand('insertImage',false,$scope.kp_editor_file_path)){
							
							$scope.kp_editor_file_path = null;

							document.getElementById('media_preview_dialog_loading_space').style.display='none';
							document.getElementById('media_preview_canvas_px').style.display = 'none';
							document.getElementById('media_selection_container').style.display = 'block';		
							document.getElementById('Dialog_kp_editor_picture_video').style.display='none';

						}else{
							console.log("Something went wrong, Editor freeze");
						}
					};

					}else{

						console.log("Upload Service is Missing in your Angular Module");
					}

				});


			}else{

				console.log("Angular Module Missing");
			}
			
			
		}

	global.KPEDITOR = new kp();
	return 0;

})(window,angular);