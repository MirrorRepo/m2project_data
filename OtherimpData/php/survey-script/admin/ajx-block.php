<?php
error_reporting(0);
include './auth/config.php';
$link = mysql_connect($hostname, $username,$password);
if($link)
{
 $dbcon = mysql_select_db($dbname,$link);
} 
if(isset($_POST['idd']))
  {
   $id = $_POST['idd'];
   $delquery=mysql_query("UPDATE survey SET status='No' where id=$id") or die(mysql_error());  
  }
  
  