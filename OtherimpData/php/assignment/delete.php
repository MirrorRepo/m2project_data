<?php

$host="127.0.0.1";
$username = "root";
$password = "root";
$dbname = "Employee_Details";

$conn = new mysqli($host, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

    $date=$_POST["date1"];
    $task=$_POST["task1"];
    $Id=$_POST["id1"];

  
  $result = $conn->query("SELECT * FROM TimeSheet where Id='$Id'");

  $sql = "DELETE FROM TimeSheet WHERE Id='$Id'";

if ($conn->query($sql) === TRUE) {

    if($result->num_rows>0)
    {
      
      $row=$result->fetch_assoc();
     
   echo json_encode($row);
   exit;
  }

  
     $conn->close();

} 
else {
     }
?>

