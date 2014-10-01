<?php
	include './Mobile_Detect.php';
	
	$detect = new Mobile_Detect();

	#Conecta ao MongoDB
	$m = new MongoClient();
	$db = $m -> mydb;
	$collection = $db -> leituras;
	
	if($detect->isMobile()){ //se for acesso movel
		include "./App/index.php";
	}
	else {//se for acesso web desktop
		include "./Web/index.php";
	}	
?>