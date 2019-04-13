<?php
error_reporting(0);
include "config.php";
include "heade.php";
?>
<?php
error_reporting(0);
include './auth/config.php';
$link = mysql_connect($hostname, $username,$password);
if($link)
{
 $dbcon = mysql_select_db($dbname,$link);
} 
?>
<script type='text/javascript'>
    $('#m2').html("<span class='curr_mnu'>Edit Poll</span>")    
	
function parseDate(id) {			
             var str=$("#"+id).val();
             //var m = str.match(/^(\d{1,2})-(\d{1,2})-(\d{4})$/);
	     var m = str.match(/^(\d{4})-(\d{1,2})-(\d{1,2})$/);
            // return (m) ? new Date(m[3], m[2]-1, m[1]) : null;
             if(!m) {
				alert("Date format should be(yyyy-mm-dd)")
				$("#"+id).val("");				
              }
           }	
</script>
<?php

$id = $_GET['id'];
$sub = $_POST['submit'];
             $res2 = mysql_query("SELECT * FROM survey ORDER BY id DESC limit $start,10");
      
       
         if($id != "" )	
	{
              
                $query = mysql_query("select * from survey where id like '$id'");
		if($line = mysql_fetch_array($query, MYSQL_ASSOC))
		{
			$id = $line['id'];
			$qns = $line['question'];
			$des = $line['description'];
			$opt1 = $line['opt1'];
			$opt2 = $line['opt2'];
			$opt3 = $line['opt3'];
			$opt4 = $line['opt4'];
			$opt5 = $line['opt5'];
			$date = $line['dat'];
                        $date1 = $line['todate'];
   
			echo '<div class="form">';
         		echo "<form name=de method='post' action=''>";
			echo "<div class='form_con'> <div class='form_element lable'>Question</div><div class='form_element'><textarea name=question class='textbox'/>$qns</textarea></div></div>";
			echo "<div class='form_con'> <div class='form_element lable'>Description</div><div class='form_element'><textarea name=description class='textbox'>$des</textarea></div></div>";
			echo "<div class='form_con'> <div class='form_element lable'>Option1</div><div class='form_element'><input type=text name=opt1 value='$opt1'  class='textbox'></div></div>";
                        echo "<div class='form_con'> <div class='form_element lable'>Option2</div><div class='form_element'><input type=text name=opt2 value='$opt2'  class='textbox'></div></div>";
                        echo "<div class='form_con'> <div class='form_element lable'>Option3</div><div class='form_element'><input type=text name=opt3 value='$opt3'  class='textbox'></div></div>";
                        echo "<div class='form_con'> <div class='form_element lable'>Option4</div><div class='form_element'><input type=text name=opt4 value='$opt4'  class='textbox'></div></div>";
                        echo "<div class='form_con'> <div class='form_element lable'>Option5</div><div class='form_element'><input type=text name=opt5 value='$opt5'  class='textbox'></div></div>";
			echo "<div class='form_con'> <div class='form_element lable'>Date</div><div class='form_element'><input type=text name=date value='$date'  onblur='parseDate(this.id)' class='textbox' id='scriptdate'></div></div>";
			echo "<div class='form_con'> <div class='form_element lable'>Date</div><div class='form_element'><input type=text name=date1 value='$date1'  onblur='parseDate(this.id)' class='textbox' id='scriptdate1'></div></div>";

			echo " 
			<input name=id type=hidden value=$id>
			
			<input name=submit type=submit value=submit class='form_button' onclick='updatee()'>
<div class='form_element' style='float:left;'><a href='./index.php' style='text-decoration:none;'> <input  type=button value='Back' class='form_button'> </a></div>						
			";
			echo "</form></div>";
                        
		
        }
        }
        if($sub == "submit"){
            $qn = $_POST['question'];
            $de = $_POST['description'];
            $op1 = $_POST['opt1'];
            $op2 = $_POST['opt2'];
            $op3 = $_POST['opt3'];
            $op4 = $_POST['opt4'];
            $op5 = $_POST['opt5'];
	    $date = $_POST['date'];
            $date1 = $_POST['date1'];
	    
            $query =  mysql_query("update survey set question='$qn',description='$de',opt1='$op1',opt2='$op2',opt3='$op3',opt4='$op4',opt5='$op5',dat='$date',todate='$date1' where id like '$id'");
           // echo "update survey set question='$qn',description='$de',opt1='$op1',opt2='$op2',opt3='$op3',opt4='$op4',opt5='$op5' where id like '$id'";
            if($query)
            {
			echo "<div align='center' style='color:green'><b>Review has been updated.</b></div>";
                        if(isset($_POST['edit-poll']))
			 {
				echo "<script type='text/javascript'>
		 setTimeout(function(){
     	            window.location.href='./edit-poll.php'
                          },1000);
		 
		 </script>";
				
			 }
			else
			 {
			echo "<script type='text/javascript'>
		 setTimeout(function(){
     	            window.location.href='./edit-poll.php'
                          },1000);
		 
		 </script>";
			 }
            }
            else{
                echo "<div align='center' style='color:red'><b>Review not updated.</b></div>";
            }
			
		}
	?>


