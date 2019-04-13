<?php
error_reporting(0);
include "config.php";
include "heade.php";
?>
<script type='text/javascript'>
$(document).ready(function(){
     $('#m2').html("<span class='curr_mnu'>Edit Poll Questions</span>")    
	
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

		$("#content").load("edit-page.php?page=" + this.id, hideLoader);
		
		return false;
	});
	
	$("#1").css({'background-color' : '#006699'});
	showLoader();
	$("#content").load("edit-page.php?page=1", hideLoader);
	
});


function parseDate() {			
             var str=$("#scriptdate").val();
             //var m = str.match(/^(\d{1,2})-(\d{1,2})-(\d{4})$/);
	     var m = str.match(/^(\d{4})-(\d{1,2})-(\d{1,2})$/);
            // return (m) ? new Date(m[3], m[2]-1, m[1]) : null;
             if(!m) {
				alert("Date format should be(yyyy-mm-dd)")
				$("#scriptdate").val("");				
              }
           }	
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
