<?php

$currentDate = (int) date("d");

/**
* for loop to get date interval
*/

switch ($currentDate) {
	case ($currentDate <= 5 ):
		echo "1";
		break;

    case ($currentDate >5 && $currentDate <= 10 ):
		echo 2;
		break;

   
    case ($currentDate >10 && $currentDate <= 15 ):
	     echo 3;
		break;

   
    case ($currentDate >15 && $currentDate <= 20 ):
		echo 4;
		break;

	case ($currentDate >20 && $currentDate <= 25 ):
		echo 5;
		break;


    case ($currentDate >25 && $currentDate <= 31 ):
		echo 6;
		break;
	
}

try {
  $request = new HttpRequest();
} catch (HttpException $ex) {
  echo $ex->getMessage();
}

$request->setUrl('https://www.in2detailing.co.uk/api/xmlrpc');
$request->setMethod(HTTP_METH_POST);

$request->setHeaders(array(
  'user-agent' => 'XML-RPC.NET',
  'content-type' => 'application/xml'
));

$request->setBody('<?xml version="1.0"?>
<methodCall>
	<methodName>login</methodName>
	<params>
		<param>
			<value>
				<string>apiuser</string>
			</value>
		</param>
		<param>
			<value>
				<string>apipass</string>
			</value>
		</param>
	</params>
</methodCall>');

try {
  $response = $request->send();

  echo $response->getBody();
} catch (HttpException $ex) {
  echo $ex;
}