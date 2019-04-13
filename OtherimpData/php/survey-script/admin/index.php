<?php
include "authheader.php";
error_reporting(0);
if($block != true)
{
?>
<?php include "heade.php" ?>
<script type="text/javascript">
 var chk_id='';

 $(document).ready(function(){
     $('#m1').html("<span class='curr_mnu'>Added Poll Questions</span>");   
	
	function showLoader(){
	
		$('.search-background').fadeIn(200);
	}
	
	function hideLoader(){
	
		$('.search-background').fadeOut(200);
	};
	
	$("#paging_button li").click(function(){
		
		showLoader();
		
		$("#paging_button li").css({'background-color' : ''});
		$(this).css({'background-color' : '#006699'});

		$("#content").load("surveydata.php?page=" + this.id, hideLoader);
		
		return false;
	});
	
	$("#1").css({'background-color' : '#006699'});
	showLoader();
	$("#content").load("surveydata.php?page=1", hideLoader);
	
});


function ckbox() { 
  var abc = document.getElementById('ckt');
  var aa = document.getElementById('check');
  $cnt=$('#tcount').val();
    for (var i =0; i < $cnt; i++)
    {
      if (abc.checked){
		 
	          $('#xx'+i).attr('checked',true);
		  $('#xx1'+i).attr('checked',true); 
         }
      else{
	$('#xx'+i).attr('checked',false);
	$('#xx1'+i).attr('checked',false);
 
	}
	//alert($('#xx'+i));
    var ddd=document.getElementById('xx'+i);
    row(ddd,'');  
    }	
}

 function display_stat(val)
    {
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
$per_page = 10;  //Display Images or Content
$count=mysql_query("select count(*) from survey WHERE status='No'");

while ($row2 = mysql_fetch_row($count)) 
{
   $total=$row2[0];
}
$pages = ceil($total/$per_page);

?>
		<h1>View Polls</h1>
<div class="search-background" style='margin-left:250px;'>
			<label><img src="./images/load.gif" alt="" /></label>
		</div>
		<div id="content">
		&nbsp;
		</div>
<div id="paging_button" style="margin: 0 40%;" align='center'>

		<ul>
		<?php
			
		for($i=1; $i<=$pages; $i++)
		{
		 if($pages>1)
		 {
			echo '<li id="'.$i.'">'.$i.'</li>';
		 }
		}
		
    ?>
		</ul>
	</div>
  <?php
//include './footer.php';
}
?>
