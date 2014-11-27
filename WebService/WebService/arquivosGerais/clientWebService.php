<?php
$client = new SoapClient('http://localhost:8080/axis2/services/WebServiceLeituras?wsdl');
 
$function = 'leituras';
 
$arguments= array('ConvertTemp' => array(
                        'quantidadeRegistros'   => 15,
                        'dataHora'      => '2014-09-05T22:16:23.862Z'
                ));
 
$result = $client->__soapCall($function, $arguments);
 
echo 'Response: ';
print_r($result);
?>