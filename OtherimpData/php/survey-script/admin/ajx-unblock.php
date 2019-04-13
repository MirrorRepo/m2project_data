<?php
error_reporting(0);
include './auth/config.php';
$link = mysql_connect($hostname, $username,$password);
if($link)
{
 $dbcon = mysql_select_db($dbname,$link);
} 
if(isset($_POST['id']))
  {
   $id = $_POST['id'];
   $delquery=mysql_query("UPDATE survey SET status='Yes' where id=$id") or die(mysql_error());
  }
  
  