<?php
error_reporting(0);
require_once "auth/config.php";
$uidd  = $_SERVER['REQUEST_URI'];
$host1 = $_SERVER['SERVER_NAME'];
$uidd = "http://$host1$uidd";
$link = mysql_connect($hostname, $username,$password);
if($link)
{
 $dbcon = mysql_select_db($dbname,$link);
} 
$status='';
$com_id='';
$date='';
$date1='';
$dat = date('Y-m-d');
$qry = mysql_query("SELECT * FROM user_survey order by uid desc");
 while($row = mysql_fetch_assoc($qry))
	{
			$id = $row['id'];
			$com_id=$com_id.",".$id;
			
	}
	
if($block != true)
{
?>
<script>
 function display_stat(val)
    {
	$("#maindiv").html('');      
        $.ajax({//Make the Ajax Request
                    type: "POST",
                    url: "statistics.php",
                    data:{val:val},
                    success: function(data){
                       $("#maindiv").html(data);             
                    }
                })
    }
</script>

	  
<?php
$per_page = 10;
$page = $_REQUEST['page'];
$start = ($page-1)*10;
echo "<div id='maindiv'>";

$res2 = mysql_query("SELECT * FROM user_survey order by uid desc limit $start,10");
                  
		echo '<div class="admin_table"><table border="0" cellspacing="0" cellpadding="0" >
        <tr>
		  <th>Name</th>
          <th>Question</th>
          <th>Option</th>
		  <th></th>
        </tr>';
	$xx=0;
	$d=0;
	
		 while($line = mysql_fetch_assoc($res2))
		 {
			$id = $line['uid'];
            $name = $line['name'];
			$qns = $line['question'];
            $options = $line['options'];
			$opt1 = $line['opt1'];
			$opt2 = $line['opt2'];
			$opt3 = $line['opt3'];
			$opt4 = $line['opt4'];
			$opt5 = $line['opt5'];
			
			//$status = $row['status'];
			
			echo "<tr>";
	
		$status = $line['status'];
			
			
			
			echo "<td>$name</td>
                        
                        <td>$qns</td>
			<td>$options</td>
			<td><input type='button' value='View Statistics' id='$id' onclick='display_stat(this.id)'></td>
			</tr>";
			$xx++;
			$d++;
		}
	
		echo "</table></div>";
		
?>

<script>
	function block(id,name)
    {
    $('#'+id).css("display","none");
    $('#u-'+id).css("display","inline");
    $.ajax({//Make the Ajax Request
                    type: "POST",
                    url: "ajx-unblock.php",
                    data:{id:name},
                    success: function(data){
                  
                  window.location.reload(); 
                    }
		    
                })
    }
       
    function unblock(id,name)
    {
    $('#'+id).css("display","none");
    $('#'+name).css("display","inline");
    $.ajax({//Make the Ajax Request
                    type: "POST",
                    url: "ajx-block.php",
                    data:{idd:name},
                    success: function(data){
                  
                  window.location.reload(); 
                    }
		    
                })
    }

</script>
<?php

}
include './footer.php';
?>
