<?php

$un = $_POST['usern'];
$pw = $_POST['passw'];

$pw=md5($pw);

$link = mysql_connect($hostname, $username,$password);

if($link)
{

 	$dbcon = mysql_select_db($dbname,$link);

	if($dbcon)
	{
	    	$result = mysql_query("insert into hioxpm values( '$un', '$pw')",$link);

	 	if (!$result)
		{
		    echo(" <table width=100% height=100% align=center><tr><td>
				<table bgcolor=#aaddaa align=center width=300 height=300><tr>
				<td style=\"color: #aa2233; font-size: 15px;\" align=center>
				 Unable to add / edit admin user. <br>.");
		    echo(" </td></tr></table> </td></tr></table>");

		    //echo(mysql_error());
		}
		else
		{
		   include "message2.php";
		}
	}
	else
	{
		$vv =false;
	}
}
else
{
	$vv =false;
}

if($vv === false)
{
 echo	"<div class='form' style='margin:25px;border:1px solid #ddd;padding:10px;'>";
 echo "<form method=POST action=$PHP_SELF>";
 echo "<input type=hidden name=type value=changedb>";
 echo "<div class='errortext'>Unable to connect to the database.<br>
	Please check your database entries  </div><br><input type=submit value='dbentries' class='form_button' style='float:left;'><div style='clear:both;'></div>";
 echo "</form>";
echo(" </div>");

}

?>
