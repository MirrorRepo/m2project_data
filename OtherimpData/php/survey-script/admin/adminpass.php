<table width=100% height=100% border=0 align=center><tr><td align=center>

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

<table align=center width=300 height=300>
<tr><td style="color: #aa2233; font-size: 15px;" align=center>
HIOX DB Installation Manager</td></tr>
<tr bgcolor=#aaddaa><td style="color: #000088; font-size: 14px; padding:10px; ">
Tables are created successfully.<br>
Now update your admin username and password.
<form name=setf method=POST action="<?php echo $PHP_SELF;?>" onsubmit="return check()">
<input name="type" type=hidden value="updateadmin"><br>
User Name - <input name="usern" type=text><br>
Pass Word - <input name="passw" type=password><br>
&nbsp; &nbsp; &nbsp; &nbsp;<input type=submit value="Next ->">
</form>
</td></tr></table>

</td></tr></table>
