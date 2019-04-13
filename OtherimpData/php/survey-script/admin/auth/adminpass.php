<script language=javascript>
function check()
{
var un = document.setf.usern.value;
var pw = document.setf.passw.value;

	if(un.length<5)
	{
		alert("Enter a proper username of atleast 5 character inlength")
		return false;
	}
	if(pw.length<5)
	{
		alert("Enter a proper password of atleast 5 character inlength")
		return false;
	}
return true;
}
</script>
<div class='form' style='margin:25px;border:1px solid #ddd;padding:10px;'>
<h4>HIOX DB Installation Manager</h4>
<p style='color:green'>
Tables are created successfully.<br>
Now update your admin username and password.</p>
<form name=setf method=POST action="<?php echo $PHP_SELF;?>" onsubmit="return check()">
<input name="type" type=hidden value="updateadmin"><br>
<div class='form_con'> <div class='form_element lable'>User Name</div><div class='form_element'><input name="usern" type=text class='textbox'></div></div>
<div class='form_con'> <div class='form_element lable'>Pass Word </div><div class='form_element'> <input name="passw" type=password class='textbox'></div></div>
&nbsp; &nbsp; &nbsp; &nbsp;<input type=submit value="Next" class='form_button' style='float:left;'><div style='clear:both;'></div>
</form>
</div>
