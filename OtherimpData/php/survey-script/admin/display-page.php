<?php
error_reporting(0);
include './auth/config.php';
$link = mysql_connect($hostname, $username,$password);
if($link)
{
 $dbcon = mysql_select_db($dbname,$link);
} 
$action=$_POST['ck_id'];

$query1=mysql_query("UPDATE survey set status='No'");
if(isset($_POST['ck_id']))
  {
   $id = $_POST['ck_id'];
   $id = mysql_escape_String($id); 
   $query="UPDATE survey set status='Yes' WHERE id IN($id)";
   $result = mysql_query($query);
   if($query && $query1)
   {
    echo "Updated Sccesfully";
   }
   
  }
  ?>
  
  
 