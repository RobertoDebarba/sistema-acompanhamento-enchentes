<?php

    $texto=$_POST['texto']; //Pegando dados passados por AJAX

    $client = new SoapClient("http://ec2-54-207-68-21.sa-east-1.compute.amazonaws.com:8080/axis2/services/helloworld?wsdl");

    $result = $client->sayHello(array("args0" => $texto) );
 
    print_r($result);
?>
