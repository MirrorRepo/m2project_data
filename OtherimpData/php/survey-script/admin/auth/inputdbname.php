

<?php
$file = "auth/config.php"; 
if(!is_readable($file) or !is_writeable($file))
{
    echo " <span class=\"errortext\">Incorrect file permissions for config.php! <br>
		Must be in read,write mode during installaton</span>";
}
?>

<div class='form' style='margin:25px;border:1px solid #ddd;padding:10px;'>
<h4> Enter Database Details </h4>
 <form name=setf method=POST action="<?php echo $PHP_SELF;?>">
	
	<div class='form_con'> <div class='form_element lable'>HOST NAME</div><div class='form_element'><input  name="hostname"  class='textbox' type=text value='<?php echo "$hostname";?>'></div></div>
	<div class='form_con'> <div class='form_element lable'>DB NAME</div><div class='form_element'><input  name="dbname"  type=text class='textbox' value='<?php echo "$dbname";?>' ></div></div>
	<div class='form_con'> <div class='form_element lable'>User NAME </div><div class='form_element'><input  name="username"  type=text class='textbox' value='<?php echo "$username";?>' ></div></div>
	<div class='form_con'> <div class='form_element lable'>Password </div><div class='form_element'><input  name="pass"  type=text  class='textbox' value='<?php echo "$password";?>' ></div></div>
	<input name="type" type=hidden value="updatedb">
	<input type=submit value="Install" class='form_button' style='float:left;'><div style='clear:both;'></div>
	
 </form>
</div>
