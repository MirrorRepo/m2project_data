<?php
error_reporting(0);
include './auth/config.php';
$un = $_POST['usern'];
$pw = $_POST['passw'];


$pw1=md5($pw);

$link = mysql_connect($hostname, $username,$password);
//echo $dbname."######";
if($link)
{

 	$dbcon = mysql_select_db($dbname,$link);
	if($dbcon)
	{	//echo $un."###";	
	    	$result = mysql_query("select password from hioxpm where username='$un'",$link);

	 	if (!$result)
		{
		    echo(" <table width=100% height=100% align=center><tr><td>
				<table bgcolor=#aaddaa align=center width=300 height=300><tr>
				<td style=\"color: #aa2233; font-size: 15px;\" align=center>
				 Unable to get authentication values. <br>.");
		    echo(" </td></tr></table> </td></tr></table>");
		    $block = true;
		}
		else
		{
			if($pas=mysql_fetch_row($result))
			{
				$dbpas = $pas[0];
			}	
			@mysql_free_result($pas);

	
			if($pw1 == $dbpas)
			{
			   session_start();
			   //session_register("auth");
			   $_SESSION['HRS'] = "passed";
			   $block = false;
			}
			else
			{
				 echo "<div align=center class=rad>Authentication Failed - ENTER correct username and password.<br><br>
				 To reset the password - delete the table hioxpm in your database and 
				reinstall using install.php</div>";
				 include "authlogin.php";
				 $block = true;
			}
		}
	}
	else
	{
		$vv = false;	
	}
}
else
{
	$vv = false;
}

if($vv === false)
{
 echo	"<table width=100% height=100% align=center><tr><td>
		<table bgcolor=#aaddaa align=center width=300 height=300><tr>
			<td style=\"color: #aa2233; font-size: 15px;\" align=center>";
 echo "<form method=POST action=$PHP_SELF>";
 echo "<input type=hidden name=type value=changedb>";
 echo "<br><br><br>Unable to connect to the database. <br>
	Please check your database entries <br><input type=submit value=dbentries>";
 echo "</form>";
echo(" </td></tr></table> </td></tr></table>");
$block = true;
}

?>
