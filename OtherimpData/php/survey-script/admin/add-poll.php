<?php
error_reporting(0);
include './auth/config.php';
$link = mysql_connect($hostname, $username,$password);
if($link)
{
 $dbcon = mysql_select_db($dbname,$link);
} 
include "heade.php";
?>
<script type='text/javascript'>
var pp=1;
 $('#m3').html("<span class='curr_mnu'>Add Poll</span>")
 function parseDate(id) {			
             var str=$("#"+id).val();
	     var m = str.match(/^(\d{4})-(\d{1,2})-(\d{1,2})$/);
             if(!m) {
				alert("Date format should be(yyyy-mm-dd)")
				$("#"+id).val("");				
              }
           }	
</script>
<?php
$sub = $_POST['submit'];
$dat = date('y-m-d');   
			echo '<div class="form">';         	    
			echo "<div class='form_con'> <div class='form_element lable'>Question</div><div class='form_element'><textarea name=question value='' class='textbox' id='qns'/></textarea></div></div>";
			echo "<div class='form_con'> <div class='form_element lable'>Description</div><div class='form_element'><textarea name=description value='' class='textbox' id='des'></textarea></div></div>";
			echo "<div class='form_con'> <div class='form_element lable'>Option1</div><div class='form_element'><input type=text name=opt1 value=''  class='textbox' id='op1'></div></div>";
                        echo "<div class='form_con'> <div class='form_element lable'>Option2</div><div class='form_element'><input type=text name=opt2 value=''  class='textbox' id='op2'></div></div>";
                        echo "<div class='form_con'> <div class='form_element lable'>Option3</div><div class='form_element'><input type=text name=opt3 value=''  class='textbox' id='op3'></div></div>";
                        echo "<div class='form_con'> <div class='form_element lable'>Option4</div><div class='form_element'><input type=text name=opt4 value=''  class='textbox' id='op4'></div></div>";
                        echo "<div class='form_con'> <div class='form_element lable'>Option5</div><div class='form_element'><input type=text name=opt5 value=''  class='textbox' id='op5'></div></div>";
			echo "<div class='form_con'> <div class='form_element lable'>From Date</div><div class='form_element'><input type=text name=date value=''  onblur='parseDate(this.id)' class='textbox' id='scriptdate'></div></div>";
			echo "<div class='form_con'> <div class='form_element lable'>To Date</div><div class='form_element'><input type=text name=date1 value=''  onblur='parseDate(this.id)' class='textbox' id='scriptdate1'></div></div>";
			echo " 
			<input name=id type=hidden value=$id>			
                        <span class='form_element' style='float:left;'><a href='./index.php' style='text-decoration:none;'>
                        <input  type=button value='Back' class='form_button'> </a></span>
                        <span style='float:left;'>
                        <input name=submit type=submit value=submit class='form_button' onclick='addpoll()'>
                        </span>
			";
			echo "</div>";                     
	?>

<script>
 function addpoll()
 {
  var qns=$('#qns').val();
            var des=$('#des').val();
            var opt1=$('#op1').val();
            var opt2=$('#op2').val();
            var opt3=$('#op3').val();
            var opt4=$('#op4').val();
            var opt5=$('#op5').val();
            var date=$('#scriptdate').val();
            var date1=$('#scriptdate1').val();
   //alert(des)
  $.ajax({//Make the Ajax Request
                    type: "POST",
                    url: "ajx-addpoll.php",
                    data:{qes:qns,des:des,op1:opt1,op2:opt2,op3:opt3,op4:opt4,op5:opt5,date:date,date1:date1},
                    success: function(data){
                 alert(data);
		 var qns=$('#qns').val();
            var des=$('#des').val('');
            var opt1=$('#op1').val('');
            var opt2=$('#op2').val('');
            var opt3=$('#op3').val('');
            var opt4=$('#op4').val('');
            var opt5=$('#op5').val('');
            var date=$('#scriptdate').val('');
            var date1=$('#scriptdate1').val('');
                  window.location.reload();
                    }
                })
 }
</script>
