<?php
error_reporting(0);
include './auth/config.php';
$link = mysql_connect($hostname, $username,$password);
if($link)
{
 $dbcon = mysql_select_db($dbname,$link);
} 
$action=$_POST['idd']; 
if(isset($_POST['idd']))
  {
   $id = $_POST['idd'];
   $id = mysql_escape_String($id);
   $delquery=mysql_query("delete from survey where id=$id") or die(mysql_error());
   $qry = mysql_query("delete from rating where id=$id") or die(mysql_error());
   echo "Record deleted";
  }