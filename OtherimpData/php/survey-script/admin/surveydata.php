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
$qry = mysql_query("SELECT * FROM survey WHERE status='Yes' order by id desc");
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

$res2 = mysql_query("SELECT * FROM survey WHERE status='No' order by id desc limit $start,10");
                  
		echo '<div class="admin_table"><table border="0" cellspacing="0" cellpadding="0" >
        <tr>
          <th>Question</th>
          <th>Description</th>
          <th>Options</th>
	  <th>From</th>
	  <th>To</th>
	  <th>IP</th>
	  <th>Rates</th>
	  <th></th>
	  <th></th>
        </tr>';
	$xx=0;
	$d=0;
	
		 while($line = mysql_fetch_assoc($res2))
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
			//$status = $row['status'];
			
			echo "<tr>";
	
		$status = $line['status'];
			
			
			
			echo "<td>$qns</td><td>$des</td>
			<td>$opt1,$opt2,$opt3,$opt4,$opt5</td>
			<td>$date</td>
			<td>$date1</td>
			<td><input type='button' value='Block' id='$id' name=$id onclick='block(this.id,this.name)' class='block'>
                        <input type='button' value='Unblock' id='u-$id' name=$id onclick='unblock(this.id,this.name)' class='unblock' style='display:none;'></td>
			<td><input type='button' value='View Statistics' id='$id' onclick='display_stat(this.id)'></td>
			</tr>";
			$xx++;
			$d++;
			echo "<tr><td><input type='hidden' value='$date' id='x-$id' name='date'>
			<input type='hidden' value='$date1' id='y-$id' name='date1'></td></tr>";
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
include './footer.php';
}
?>
