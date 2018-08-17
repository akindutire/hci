<?php
namespace CliqsStudio\service;

class CQS_Redirect{

	public function __construct($url){
		header("location:$url");
	}
}

?>