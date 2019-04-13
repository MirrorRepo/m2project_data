<?php
include "authheader.php";

if($block != true)
{
 include "heade.php";
?>
<h1>Change Password :</h1>
<?php
if(isset($_POST['submit']))
{
$un = $_POST['usern'];
$pw = $_POST['oldpwd'];
$npw = $_POST['newpwd'];

$pw1=md5("$pw");
$result = mysql_query("select * from hioxpm where username='$un'",$link);
	
	if($cha = mysql_fetch_row($result)){
	$usr = $cha[0];
	$pwd = $cha[1];
	md5($pwd);

	   if($usr == $un && $pwd == $pw1 && $npw != ""){
		$npw = md5($npw);
		$result1 = mysql_query("update hioxpm set password='$npw' where username='$un'",$link);
		if($result1)
                        echo "<div align='center'><font color=Green><b>Password Changed Successfully</b></font></div>";
                else
                        echo "<div align='center'><font color=red><b>Password Not Changed</b></font></div>";
			
	   }
	   else{
                 echo "<div align='center'><font color=red><b>Invalid User Name or PassWord.</b></font></div> ";
	   }
	}

	else{
           echo "<div align='center'><font color=red><b>Invalid User Name or PassWord.</b></font></div>";
        }


}

?>
<div class="form">
	<form name=admail method=post <?php echo "PHP_SELF"?>>
	
	 <div class="form_con">
    <div class="form_element lable">User Name:</div>
    <div class="form_element"><input name="usern" type=text value="" class="textbox"  ></div>
    </div>
    <div class="form_con">
    <div class="form_element lable">Old Password:</div>
    <div class="form_element"><input name="oldpwd" type=password class="textbox"></div>
    </div>
    <div class="form_con">
    <div class="form_element lable">New Password:</div>
    <div class="form_element"><input name="newpwd" type=password class="textbox"></div>
    </div>
	 <div class="form_con" style='float:left;'>
    <div class="form_element"><input type=submit name="submit" value=Change class="form_button"></div>
    </div>
        <input name=todo type=hidden value=change>
    
    </form><br><br>

<?php
include './footer.php';
?>
<?php
}
?>
