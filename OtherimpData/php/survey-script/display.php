<title>Employee Satisfaction Survey in Php Script</title>
<link href="<?php echo $hm2;?>/style.css" rel="stylesheet" type="text/css">
<script src='<?php echo $hm2;?>/jquery.js'></script>
<script type='text/javascript'>
	function questions()
	{
		$('#maindiv').fadeOut('fast', function(){
			$('#second_div').fadeIn('slow');
		});     
	}
	function questions1()
	{
		$('#second_div').fadeOut('fast', function(){
			$('#third_div').fadeIn('slow');
		}); 
	}
	function question3()
	{
		$('#third_div').fadeOut('fast', function(){
			$('#maindiv').fadeIn('slow');
		});
	}
	
	

</script>

<?php
error_reporting(0);
session_start();
if($hm=="")
 $hm=".";
if($hm2=="") 
 $hm2=".";
require_once "$hm/admin/auth/config.php";
if(($hostname == "" || $dbname == "" || $username == "") )
{
		     
  echo "<div align='center' style='margin-top:20%;color:red;'><b>Installation process is not completed.kindly follow the read me file instruction.</b></div>";
}
else{
$link = mysql_connect("$hostname","$username","$password");
if($link)
{
	$dbcon = mysql_select_db("$dbname",$link);
}
?>


<div class='resp_code'>
			<div style="text-align:left;padding-left:20px;" id='maindiv'>
			<div align='center'>
				<h4>Employee Satisfaction Survey Script</h4>
				<input type='submit' onclick='questions()' value='Rate this'>
			</div>
			</div>
			
			<div id='second_div' style='display:none;' align='center'>
				<h5>Thank you. Please fill this short survey to build a positive and productive work environment.</h5><br>
				<input type='submit' onclick='questions1()' value='Click Here To Rate'>
			</div>
			
			
			<div id='third_div' style='display:none;'>
				<div align='left'>
					<div class="frms noborders" align='left'>
					<label>Your Name : </label>
					<input type="text" maxlength="20" value="" name="uname" id='name'>
					</div>
					<?php
					$ipadd = $_SERVER['REMOTE_ADDR'];
					$ser=$_SERVER['HTTP_HOST'];
					$ref=$_SERVER['HTTP_REFERER'];
					$host= parse_url($ref);
					$vall='';
					$idd='';
					$rd='';
					$radio;
					$ques='';
					
					  $query = "SELECT * FROM survey WHERE status='Yes' order by id desc";
					  $result2 = mysql_query($query) or die($query."<br/><br/>".mysql_error());
					  while($row = mysql_fetch_array($result2))
					   {   
											$id = $row['id'];
								$qns = $row['question'];
								$des = $row['description'];
								$opt1 = $row['opt1'];
								$opt2 = $row['opt2'];
								$opt3 = $row['opt3'];
								$opt4 = $row['opt4'];
								$opt5 = $row['opt5'];
												$idd = $idd.','.$id;
												$str = substr($idd, 1);
												$res  = mysql_query("select * from rating where id='$id'");   
												$dd = mysql_fetch_array($res,MYSQL_BOTH);
												$vall = $dd[1];
					   $ques=$ques.",".$qns;
					   
					   echo "<input type='hidden' id='ipckh' value='$vall'>";
											echo "<div class='news_poling'>";
											echo "<input type='hidden' id='hid' value='xx-$id'>";
											echo "<div class='news_poling_top'>$qns</div>";
											echo "<div class='news_poling_select'><form id='polingForm' method='post' action='survey-script/polling-result.php'>";
											echo "<div>
										   
											<fieldset class='radios' id='$id'>
								<input type='radio' value='$opt1' name='options' id='opt1'>
								$opt1<br>
								<input type='radio' value='$opt2' name='options' id='opt3'>
								$opt2 <br>"; 
											if($opt3!='')
											{echo "<input type='radio' value='$opt3' name='options' id='opt3'>
								$opt3";}echo"<br>";
											if($opt4!='')
											{echo "<input type='radio' value='$opt4' name='options' id='opt4'>
								$opt4";}echo"<br>";
											if($opt5!='')
											{echo "<input type='radio' value='$opt5' name='options' id='opt5'>
								$opt5";}
											echo "</fieldset>
											</div>";                       
											echo "</div>             
											</form>";
							   echo "</div>"; 
					   }									  					   
				 echo "</div>";
					?>
				<div align='center'>
					<input type='button' onclick='validatePoll()' alt='vote' name='vote' value='Submit'>
					<input type='button' onclick='question3()'  value='Cancel'>
					</div>
			</div>
					
		<div align=center style=" font-size: 10px;color: #dadada;" id="dumdiv">
						<a href="http://www.hscripts.com" id="dum" style="text-decoration:none;color: #DADADA;">&copy;h</a>
		</div>
</div>
<script>
function getChecklistItems() {
    var result = $(".radios > input:radio:checked").get();
    
    var columns = $.map(result, function(element) {
        return $(element).attr("id");
    });

    return columns.join(",");
}

function getChecklistItemval() {
    var result1 = 
    $(".radios > input:radio:checked").get();
    
    var columns1 = $.map(result1, function(element) {
        return $(element).attr("value");
    });

    return columns1.join(",");
}

function validatePoll(){
  var question = "<?php echo $ques; ?>";
  var name=$("#name").val();
    var the_value;
    the_value = getChecklistItems();
    var optval = getChecklistItemval();
    var val1="<?php echo $str; ?>";
    var ip = "<?php echo $ipadd; ?>";
    var value= $("input[name='options']:checked").val();
    if (name=='') {
      alert("Please Fill Your Name!!");
    }
    else
    {
    if (value) {
    $.ajax({//Make the Ajax Request
		  type: "POST",
		  url: "<?php echo $hm2;?>/ajx-addrating.php",
		  data:{name:name,val:the_value,id:val1,ip:ip,ques:question,option:optval},
		  success: function(data){
		  alert(data);
		  window.location.reload(); 
                }
            })
    }
    
    else
	{
		alert("Please select any option to vote");
	}
    }
}
</script>
<?php
}
?>


