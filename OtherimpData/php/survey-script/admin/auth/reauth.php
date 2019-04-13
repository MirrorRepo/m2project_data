
<?php
$file = "auth/config.php"; 
if(!is_readable($file) or !is_writeable($file))
{
    echo " <span class=\"errortext\">Incorrect file permissions for config.php! <br>
		Must be in read,write mode during installaton</span>";
}
?>
<div class='form' style='margin:25px;border:1px solid #ddd'>

 <h4>Change Database Details </h4>
<p>
Your product might have been already installed.<br>
This will help to install the product in a different database.<br>
<p>


<form name=setf method=POST action="<?php echo $PHP_SELF;?>">
	
	<div class='form_con'> <div class='form_element lable'>HOST NAME</div><div class='form_element'><input  name="hostname"  class='textbox' type=text value='<?php echo "$hostname";?>'></div></div>
	<div class='form_con'> <div class='form_element lable'>DB NAME</div><div class='form_element'><input  name="dbname"  type=text class='textbox' value='<?php echo "$dbname";?>' ></div></div>
	<div class='form_con'> <div class='form_element lable'>User NAME </div><div class='form_element'><input  name="username"  type=text class='textbox' value='<?php echo "$username";?>' ></div></div>
	<div class='form_con'> <div class='form_element lable'>Password </div><div class='form_element'><input  name="pass"  type=text  class='textbox' value='<?php echo "$password";?>' ></div></div>
	<input name="type" type=hidden value="updatedb">
	<input type=submit value="Install" class='form_button' style='float:left;'>
	
 </form>
</div>