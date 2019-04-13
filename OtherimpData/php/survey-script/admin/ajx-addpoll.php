<?php
error_reporting(0);
include './auth/config.php';
$link = mysql_connect($hostname, $username,$password);
if($link)
{
 $dbcon = mysql_select_db($dbname,$link);
} 
if(isset($_POST['qes']))
  {
            $qn = $_POST['qes'];
            $de = $_POST['des'];
            $op1 = $_POST['op1'];
            $op2 = $_POST['op2'];
            $op3 = $_POST['op3'];
            $op4 = $_POST['op4'];
            $op5 = $_POST['op5'];
	    $date = $_POST['date'];
	    $date1 = $_POST['date1'];
            if($qn!='' && $de!='' && $op1 && $op2 || $op3 ||$op4 || $op5)
           {
	    if($date=='')
	    {
            $query =  mysql_query("INSERT into survey set question='$qn',description='$de',opt1='$op1',opt2='$op2',opt3='$op3',opt4='$op4',opt5='$op5',dat='$date'",$link);
	    }
	    else if($date!='' && $date1!='')
	    {
            $query =  mysql_query("INSERT into survey set question='$qn',description='$de',opt1='$op1',opt2='$op2',opt3='$op3',opt4='$op4',opt5='$op5',dat='$date',todate='$date1',status=2",$link);
	    }
            //echo "INSERT into survey set question='$qn',description='$de',opt1='$op1',opt2='$op2',opt3='$op3',opt4='$op4',opt5='$op5',date='$date',todate='$date1'";
            $rat_id =  mysql_insert_id();
	  
	   
	    $query1 = mysql_query("INSERT into rating SET id='$rat_id'",$link);
           }
           
	    
	    if($query)
            {
                echo "Added Successfully";
            }
            else{
                echo "Add datas properly!";
            }
        
  }
  ?>
 