<?php
	include './Mobile_Detect.php';
	
	$detect = new Mobile_Detect();
	
	//se for acesso movel
	if($detect->isMobile()){
		header('Location: App/index.php');
	}
	//se for acesso web desktop
	else {
		header('Location: Web/index.php');
	}	
?>