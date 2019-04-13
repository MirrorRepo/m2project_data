<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

if(!empty($_POST))
{

    $host="127.0.0.1";
    $username = "root";
    $password = "root";
    $dbname = "Employee_Details";

    $conn = new mysqli($host, $username, $password, $dbname);

        $name=$_POST["name"];
        $pass=$_POST["pass"];

   $sql = "select * from RelforEmployee where Ename='$name' and Password='$pass'";
    $result=$conn->query($sql);
    
       if ($result->num_rows>0)
        {
        setcookie('Name',$name,time()+3600,'/');
          header('Location: /php/assignment/TimeSheet1.php');
        } 
       /* else
         {
            alert "wrong Password!! please retry";
         }*/
     
      $conn->close();

    }

?>



<!DOCTYPE html>
<html>
<head>
    <title>LogIn</title>
    <link rel="stylesheet" href="bootstrap.min.css" />
    <link rel="stylesheet" href="bootstrap-theme.min.css" />
    <script src="jquery-3.3.1.min.js"></script>
    <script src="bootstrap.min.js"></script>
    
</head>
<body style="background-image:url('../assignment/uploads/Blue-Wallpaper.jpg'); ">
    <form id="form" name="form" action="" method="POST">
   
    <!-- center div heading------------------- -->
        <div class="jumbotron text-center" style="background-image:url('../assignment/uploads/Blue-Wallpaper.jpg'); "></div>

    <!-- forming the left division  responsive -->
    <div class="row">
        <!-- Personal Details Table -->
            <div class="col-sm-4">
                  
            </div>
    
            <!-- Professional Details Table -->
            <div class="col-sm-4">
                    <div class="table-responsive">
                            <h1 align="center" style="color: red"><u><b>LogIn Form</b></u></h1>
                            <table class="table table-bordered">
                                    <tr>
            <td>
              <label for="name" style="color: black"><b>Name</b></label></td>
    <td><input type="text"  value="kush" placeholder="Enter Name" name="name"  id="name" required></td>
        </tr>
        <tr>
            <td>
             <label for="pass" style="color: black"st><b>Password</b></label></td>
            <td><input type="text" value="admin123" placeholder="Enter Password" name="pass"  id="pas" required></td>
        </tr>

        <tr>
            <td></td>
            <td> <button type="submit" id="submit" name="submit" value="Submit" align="center" style="color: black ; background-color:orange;" >LogIn</button><u>New User?</u> <a href="http://127.0.0.1/php/assignment/registration.php">Register</a></td>
             
         </tr>
                            </table>
                    </div>
            </div>
             <div class="col-sm-4">
                  
            </div>

    </div>
</body>
</html>