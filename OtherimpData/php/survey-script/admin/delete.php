<?php
error_reporting(0);
include './auth/config.php';
$link = mysql_connect($hostname, $username,$password);
if($link)
{
 $dbcon = mysql_select_db($dbname,$link);
} 
?>
<?php
$per_page = 10;
$page = $_REQUEST['page'];
$start = ($page-1)*10;
$id = $_GET['id'];
$sub = $_POST['delete'];
             $res2 = mysql_query("SELECT * FROM survey ORDER BY id DESC limit $start,10");
      
        if($id =='')
        {
		echo '<div class="admin_table"><table border="0" cellspacing="0" cellpadding="0" id="del-poll">
        
        <tr>
          
          <th>Question</th>
          <th>Description</th>
          <th>Options</th>
	  <th>From</th>
	  <th>To</th>
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
			echo "<tr>";
			
			echo "<td>$qns</td><td>$des</td>
			<td>$opt1,$opt2,$opt3,$opt4,$opt5</td>
			<td>$date</td>
			<td>$date1</td>
			<td><b><a id='$id' style=\"text-decoration: none;\" onclick='deletepoll(this.id)'>Delete</a></b></td>
			</tr>";
			$xx++;
			$d++;
		}
		
		
      echo  "</table></div>";
        }
       
     
	?>
<script>
   function deletepoll(id)
    {
        var confirmMsg=confirm("Are you sure you want to delete this poll");
        if (confirmMsg==true)
        {
            $.ajax({//Make the Ajax Request
                    type: "POST",
                    url: "ajax-delete.php",
                    data:{idd:id},
                    success: function(data){
                    alert(data);
                   // clearform();
                     window.location.reload(); 
                    }
                    
                })   
        }
    }
   
</script>
<style>
    a{
        cursor: pointer;
    }
</style>