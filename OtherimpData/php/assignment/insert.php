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

    $date=$_POST["date"];
	$task=$_POST["task"];
	
	//print_r($task);

	$sql = "INSERT INTO TimeSheet(date1,Task)
VALUES ('$date','$task')";

if ($conn->query($sql) === TRUE) {

$result = $conn->query("SELECT * FROM TimeSheet where date1='$date'");

    
    
    if($result->num_rows>0)
    {
      
      $row=$result->fetch_assoc();
    // print_r($row);

   echo json_encode($row);
   exit;
  }

  
     $conn->close();

} 
else {
     }

?>