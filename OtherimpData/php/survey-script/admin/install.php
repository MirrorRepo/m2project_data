<head>
<link href="./css/style.css" rel="stylesheet" type="text/css">
	<title>Installation Form - Employee-Satisfaction System</title>
</head>
<div align='center'></div><h1  style='text-align:center;margin:20px 20px 10px 20px;'>Installation Form - Employee-Satisfaction System</h1>
<?php
error_reporting(0);
$type = $_POST['type'];
$username = $_POST['username'];
	$password = $_POST['pass'];
	$hostname = $_POST['hostname'];
	$dbname = $_POST['dbname'];
require_once "auth/config.php";


if(($hostname == "" || $dbname == "" || $username == "") || $type=="changedb")
{
	if($type=="updatedb")
		 echo "<div align=center class=errortext>Invalid Data, Please give proper values</div>";
       if($type!="createdb")
	include "auth/inputdbname.php";
}
?>



<?php

if($type=="updatedb")
{
	

	//open config.php and write the data in to it.

	$file = "auth/config.php"; 
	$open = fopen($file, "w");
	fwrite($open,"<?php\n\n \$username = \"".$username."\";\n \$password = \"".$password."\";\n \$hostname = \"".$hostname."\";
		\n \$dbname = \"".$dbname."\";\n\n ?>");
	fclose($open);
}


if($type=="updatedb")
	include "auth/message.php";
else if($type=="createtables")
	include "auth/create.php";
else if($type=="updateadmin")
	include "auth/updateadmin.php";
else if(($hostname != "" || $dbname != "" || $username != ""))
	include "auth/reauth.php";
?>
