<?php
error_reporting(0);
include "config.php";
include "heade.php";
?>
<script type='text/javascript'>
$(document).ready(function(){
     $('#m4').html("<span class='curr_mnu'>Delete Poll Questions</span>")    
	
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

		$("#content").load("delete.php?page=" + this.id, hideLoader);
		
		return false;
	});
	
	$("#1").css({'background-color' : '#006699'});
	showLoader();
	$("#content").load("delete.php?page=1", hideLoader);
	
});

	
</script>
<?php
$per_page = 10;  //Display Images or Content
$count=mysql_query("select count(*) from survey");
while ($row2 = mysql_fetch_row($count)) 
{
   $total=$row2[0];
}
$pages = ceil($total/$per_page);

?>
		
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

