

<?php

$crmname = "Same name";
$orderCreatedDate = "kush@yahoo.com";


$xml =
'<?xml version="1.0" encoding="UTF-8"?>
<CustomModule4>
<row no="1">
<FL val="Same name having Birthday Name">kushssh</FL>

<FL val="Sender First Name">'.$crmname.'</FL>

<FL val="Sender Last Name">'.$crmname.'</FL>

<FL val="Receiver First Name">'.$crmname.'</FL>

<FL val="Receiver Last Namee">'.$crmname.'</FL>

<FL val="Occasion Name">'.$crmname.'</FL>

<FL val="Email">'.$orderCreatedDate.'</FL>

<FL val="Phone">9090909090</FL>

<FL val="Dob">2016-09-01</FL>
</row>
</CustomModule4>';


?>


<?php 

$auth="1fa4433713fa2836bd98199d34fe76ab";
$url ="https://crm.zoho.com/crm/private/xml/CustomModule4/insertRecords";
$query="authtoken=".$auth."&scope=crmapi&newFormat=1&xmlData=".$xml;
$ch = curl_init();
/* set url to send post request */
curl_setopt($ch, CURLOPT_URL, $url);
/* allow redirects */
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
/* return a response into a variable */
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
/* times out after 30s */
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
/* set POST method */
curl_setopt($ch, CURLOPT_POST, 1);
/* add POST fields parameters */
curl_setopt($ch, CURLOPT_POSTFIELDS, $query);// Set the request as a POST FIELD for curl.

//Execute cUrl session
$response = curl_exec($ch);
curl_close($ch);
echo $response;
?>
<?php

die;
$accemail =  "testbakeway@gmail.com";
$firstname= "testbakeway";
$Lastname= "Zoholocalapitest";

$xml =
'<?xml version="1.0" encoding="UTF-8"?>
<Accounts>
<row no="1">

<FL val="Account Name">' .$accemail. '</FL>

<FL val="First Name">' .$firstname. '</FL>
<FL val="Last Name">' .$Lastname. '</FL>
</row>
</Accounts>';
?>


<?php 

$auth="1fa4433713fa2836bd98199d34fe76ab";
$url ="https://crm.zoho.com/crm/private/xml/Accounts/insertRecords";
$query="authtoken=".$auth."&scope=crmapi&newFormat=1&xmlData=".$xml;
$ch = curl_init();

/* set url to send post request */
curl_setopt($ch, CURLOPT_URL, $url);
/* allow redirects */
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
/* return a response into a variable */
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
/* times out after 30s */
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
/* set POST method */
curl_setopt($ch, CURLOPT_POST, 1);
/* add POST fields parameters */
curl_setopt($ch, CURLOPT_POSTFIELDS, $query);// Set the request as a POST FIELD for curl.

//Execute cUrl session
$response = curl_exec($ch);
curl_close($ch);
echo $response;



?>
