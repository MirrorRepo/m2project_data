<!DOCTYPE html>
 <html>
 <head>
 	<title>registration form</title>
 	<link rel="stylesheet" href="form.css" type="text/css">
 </head>
 <body style="background-image:url('../assignment/uploads/Blue-Wallpaper.jpg'); ">
 	<div style="background-image:url('../assignment/uploads/Blue-Wallpaper.jpg');"> 
 <form action=" " method="POST" >
 	
 	<h1 align="center">Registration Form</h1>
 	<p style="color: black"><u>Please fill in this form to Register</u>.</p>
 	 
      <table align="center">  
     <tr>
    <td><label for="name"><b>Name</b></label></td>
    <td><input type="text" placeholder="Enter Name" name="name"  id="name" required></td>
     </tr>
<tr></tr><tr></tr>
   <tr>
    <td><label for="email"><b>Email</b></label></td>
    <td><input type="email" placeholder="Enter Email" name="email" id="email"required></td>
    </tr>
 <tr></tr><tr></tr>
   <tr>
    <td><label for="gender"><b>Gender</b></label></td>
    <td><input type="radio" name="gender" id="gender"value="male" checked> Male
    <input type="radio" name="gender" id="gender"value="female"> Female</td>
   </tr>
<tr></tr><tr></tr>   
   <tr> 
    <td><label for="des"><b>Designation</b></label></td>
    <td><select name="des" id="des">
     <option value="">CEO</option>
     <option value="">Manager</option>
     <option value="emp">Employee</option>
    </select></td>
   </tr>
<tr></tr><tr></tr> 
  <tr>
   <td><label for="pass" ><b>Password</b></label></td>
    <td><input type="Password" placeholder="Enter Password" name="pass"  id="pas" required></td>
   </tr>
<tr></tr><tr></tr>
   <tr>
       <td><label for="con_pass"><b> Confirm Password</b></label></td>   
      <td><input type="Password" placeholder="Confirm Password" name="con_pass"  id="con_pas" required></td>
  </tr>
    <tr></tr><tr></tr> 
    <tr>
    	<td>
    		 <button  align="center" type="submit" id="submit" name="submit" value="Submit"  style="color: black ; background-color:aqua;" >Register</button>
    	</td>
    	<td>
    		<p><u>Already registered?</u> <a href="http://127.0.0.1/php/assignment/registration.php">LogIn</a></p>

    	</td>
      </table><br>

     &nbsp&nbsp&nbsp


     
  </form>
  </div>			
 </body>


 <?php
if(!empty($_POST))
{

	$host="127.0.0.1";
	$username = "root";
	$password = "root";
	$dbname = "Employee_Details";

	$conn = new mysqli($host, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	} 

	    $name=$_POST["name"];
		$email=$_POST["email"];
		$gender=$_POST["gender"];
		$des=$_POST["des"];
		$pass=$_POST["pass"];
		$con_pass=$_POST["con_pass"];
        

//check duplicate values of email of user
 $myquery="select * from person where Email='$email' and Ename='$name'";
 $res=$conn->query($myquery);
 if ($res->num_rows>0) {
 	echo "user with same name & email already exist";
    }
 /*else if($pass!=$con_pass)
    {
    	alert "please reconfirm password if()";
    }*/
    else if($pass===$con_pass)
    {

    $sql = "INSERT INTO RelforEmployee(  
           EName,Email,Gender,Designation,Password)
	       VALUES ('$name','$email','$gender','$des','$pass')";

        //check value insert properly
	    if ($conn->query($sql) === TRUE) {
	      
	      header('Location:/php/assignment/login.php');
	       } 
	  else {
	    echo "Error: " . $sql . "<br>" . $conn->error;
	      }
     
      $conn->close();

	}


}
?>