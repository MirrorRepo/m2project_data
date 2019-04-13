<?php
require_once "auth/config.php";
error_reporting(0);
$link = mysql_connect($hostname, $username,$password) or die ("Could not connect");
mysql_select_db($dbname,$link);
echo "<a href=''>Back</a>";
if(isset($_POST['val']))
{
$id = $_POST['val'];
$qry = "SELECT * FROM survey WHERE id='$id'";
$rst=mysql_query($qry);
$query = "SELECT * FROM rating WHERE id='$id'";
$result=mysql_query($query);

echo "<div class='polling_area' id='maindiv' align='left'>";
while($row1 = mysql_fetch_array($rst))
{
                        $qns = $row1['question'];
			$des = $row1['description'];
                        $op1 = $row1['opt1'];
			$op2 = $row1['opt2'];
			$op3 = $row1['opt3'];
			$op4 = $row1['opt4'];
			$op5 = $row1['opt5'];
                       // echo $qns;
 echo " <div><h2>$qns</h2></div>";                   
 

 while($row = mysql_fetch_array($result))
   {
                        $id = $row['id'];			
			$opt1 = $row['opt1'];
			$opt2 = $row['opt2'];
			$opt3 = $row['opt3'];
			$opt4 = $row['opt4'];
			$opt5 = $row['opt5'];
                        $total = $opt1+$opt2+$opt3+$opt4+$opt5;
                        $val1 = round(($opt1/$total)*100);
                        $val2 = round(($opt2/$total)*100);
                        $val3 = round(($opt3/$total)*100);
                        $val4 = round(($opt4/$total)*100);
                        $val5 = round(($opt5/$total)*100);
                        
                       echo"<div class='polling_content'>
                                <h3>$op1</h3>
                                <div class='polling_content_top clearfix'>
                                <div class='polling_button f_left'>$val1%</div>
                                <div class='f_right'>$opt1</div>
                                </div>
                                <div class='polling_bar pollig_blue'>
                                <div class='polling_bar_content pollig_blue_content' style='width:$val1%'></div>
                                </div>
                                </div>";
                         
                        echo"<div class='polling_content'>
                                <h3>$op2</h3>
                                <div class='polling_content_top clearfix'>
                                <div class='polling_button f_left'>$val2%</div>
                                <div class='f_right'>$opt2</div>
                                </div>
                                <div class='polling_bar pollig_yellow'>
                                <div class='polling_bar_content pollig_yellow_content' style='width:$val2%'></div>
                                </div>
                                </div>";                       
                        
                        
                        if($op3!='')
                        {
                        echo"<div class='polling_content'>
                                <h3>$op3</h3>
                                <div class='polling_content_top clearfix'>
                                <div class='polling_button f_left'>$val3%</div>
                                <div class='f_right'>$opt3</div>
                                </div>
                                <div class='polling_bar pollig_red'>
                                <div class='polling_bar_content pollig_red_content' style='width:$val3%'></div>
                                </div>
                                </div>";                       
                                              
                        }
                        
                        if($op4!='')
                        {
                         echo"<div class='polling_content'>
                                <h3>$op4</h3>
                                <div class='polling_content_top clearfix'>
                                <div class='polling_button f_left'>$val4%</div>
                                <div class='f_right'>$opt4</div>
                                </div>
                                <div class='polling_bar pollig_green'>
                                <div class='polling_bar_content pollig_green_content' style='width:$val4%'></div>
                                </div>
                                </div>";       
                        
                        }
                        if($op5!='')
                        {
                        echo"<div class='polling_content'>
                                <h3>$op5</h3>
                                <div class='polling_content_top clearfix'>
                                <div class='polling_button f_left'>$val5%</div>
                                <div class='f_right'>$opt5</div>
                                </div>
                                <div class='polling_bar pollig_violet'>
                                <div class='polling_bar_content pollig_violet_content' style='width:$val5%'></div>
                                </div>
                                </div>";       
                        
                        }
   }
}
echo "</div>";
}

?>

<style>
   .polling_area {
    box-sizing: border-box;
    padding: 10px 25px 0;
    word-wrap: break-word;
}
.polling_content h3 {
    font-size: 1em;
    padding-top: 10px;
}
.clearfix::after {
    clear: both;
    content: " ";
    display: block;
    font-size: 0;
    height: 0;
    visibility: hidden;
}
.clearfix {
    display: inline-block;
}
.clearfix {
    display: block;
}
.f_left {
    float: left;
}
.f_right {
    float: right;
}
.polling_button {
    background: linear-gradient(to bottom, #fdfdfd 0px, #f4f4f4 100%) repeat scroll 0 0 rgba(0, 0, 0, 0);
    border: 1px solid #cfcfcf;
    border-radius: 0.4em;
    color: #595959;
    font-family: Tahoma,Geneva,sans-serif;
    font-size: 0.8em;
    padding: 1px 3px;
}
.polling_button a {
    color: #595959;
    display: block;
    padding: 1px 3px;
    text-decoration: none;
}
.polling_button a:hover {
    color: #595959;
    display: block;
    padding: 1px 3px;
    text-decoration: none;
}
.pollig_blue {
    background: none repeat scroll 0 0 #dce7f8;
}
.polling_bar {
    height: 25px;
    margin: 0 auto;
    padding: 0;
    position: relative;
  /*  width:300px;*/
}


.button_red {
    background: linear-gradient(to bottom, #fff 1%, #ee2918 3%, #ac1a0b 100%) repeat scroll 0 0 rgba(0, 0, 0, 0);
    border: 1px solid #99140f;
    border-radius: 4px;
    color: #fff;
    cursor: pointer;
    font-weight: bold;
    height: 30px;
    line-height: 100%;
    margin: 0;
    padding: 0 14px;
    text-shadow: 1px 1px 0 #871c14;
}
.button_green {
    background: linear-gradient(to bottom, #fff 1%, #81b31c 3%, #4e7f01 100%) repeat scroll 0 0 rgba(0, 0, 0, 0);
    border: 1px solid #5c7f07;
    border-radius: 4px;
    color: #fff;
    cursor: pointer;
    font-family: Tahoma,Geneva,sans-serif;
    font-weight: bold;
    height: 30px;
    line-height: 100%;
    margin: 0;
    padding: 0 14px;
    text-shadow: 1px 1px 0 #4e6803;
}
.button_blue {
    background: linear-gradient(to bottom, #fff 1%, #05a7ef 3%, #0078ad 100%) repeat scroll 0 0 rgba(0, 0, 0, 0);
    border: 1px solid #037aa4;
    border-radius: 4px;
    color: #fff;
    cursor: pointer;
    font-family: Tahoma,Geneva,sans-serif;
    font-weight: bold;
    height: 30px;
    line-height: 100%;
    margin: 0;
    padding: 0 14px;
    text-shadow: 1px 1px 0 #006690;
}
.button_orange {
    background: linear-gradient(to bottom, #fff 1%, #fca404 3%, #f07e01 100%) repeat scroll 0 0 rgba(0, 0, 0, 0);
    border: 1px solid #d67e02;
    border-radius: 4px;
    color: #fff;
    cursor: pointer;
    font-family: Tahoma,Geneva,sans-serif;
    font-weight: bold;
    height: 30px;
    line-height: 100%;
    margin: 0;
    padding: 0 14px;
    text-shadow: 1px 1px 0 #b76900;
}
.button_gray {
    background: linear-gradient(to bottom, #fff 1%, #888 3%, #575757 100%) repeat scroll 0 0 rgba(0, 0, 0, 0);
    border: 1px solid #555;
    border-radius: 4px;
    color: #fff;
    cursor: pointer;
    font-family: Tahoma,Geneva,sans-serif;
    font-weight: bold;
    height: 30px;
    line-height: 100%;
    margin: 0;
    padding: 0 14px;
    text-shadow: 1px 1px 0 #484846;
}
.total_members {
    background: none repeat scroll 0 0 #855f2f;
    border-radius: 10px;
    box-shadow: 2px 2px 2px 2px #342512 inset;
    color: #fff;
    font: 13px/18px Tahoma,Geneva,sans-serif;
    margin: 5px auto;
    padding: 20px;
    width: 220px;
}
.div_color {
    float: left;
    height: 30px;
    margin: 5px;
    width: auto;
}


.polling {
    background: none repeat scroll 0 0 #fff;
    border: 1px solid #d6d6d6;
    border-radius: 0.4em;
    box-sizing: border-box;
    margin: 10px 0;
    word-wrap: break-word;
}
.polling_top {
    background: none repeat scroll 0 0 #f9f9f9;
    border-bottom: 3px solid #eaeaea;
    border-top-left-radius: 0.4em;
    border-top-right-radius: 0.4em;
    box-sizing: border-box;
    padding: 10px 15px;
}
.polling_top h1 {
    color: #636162;
    font-family: Verdana,Geneva,sans-serif;
    font-size: 0.8em;
    text-shadow: 1px 1px 0 #fff;
}
.poling_top_bottom {
    margin: 0 auto;
}
.polling_user_name {
    color: #e25a35;
    float: left;
    font-family: Tahoma,Geneva,sans-serif;
    font-size: 0.75em;
    padding-right: 5px;
    padding-top: 2px;
}
.polling_user_name a {
    text-decoration: none;
}
.grey_clr {
    color: #9f9f9f;
}
.polling_button {
    background: linear-gradient(to bottom, #fdfdfd 0px, #f4f4f4 100%) repeat scroll 0 0 rgba(0, 0, 0, 0);
    border: 1px solid #cfcfcf;
    border-radius: 0.4em;
    color: #595959;
    font-family: Tahoma,Geneva,sans-serif;
    font-size: 0.8em;
    padding: 1px 3px;
}
.polling_button a {
    color: #595959;
    display: block;
    padding: 1px 3px;
    text-decoration: none;
}
.polling_button a:hover {
    color: #595959;
    display: block;
    padding: 1px 3px;
    text-decoration: none;
}
.polling_area {
    box-sizing: border-box;
    padding: 10px 25px 0;
    word-wrap: break-word;
}
.polling_content {
}
.polling_content_top {
    box-sizing: border-box;
    color: #444;
    font-weight: normal;
    margin: 2px auto;
}
.polling_content h3 {
    font-size: 0.65em;
    padding-top: 10px;
}
.polling_content h2 {
    border-bottom: 1px solid #36c;
    color: #36c;
    font-size: 0.8em;
    line-height: 180%;
    margin-bottom: 10px;
}
.polling_bar {
    height: 25px;
    margin: 0 auto;
    padding: 0;
    position: relative;
}
.polling_bar_content {
    border-right: 1px solid #fff;
    height: 25px;
    width: 35%;
}
.pollig_blue {
    background: none repeat scroll 0 0 #dce7f8;
}
.pollig_blue_content {
    background: linear-gradient(to bottom, #476ac4 0px, #5288dc 49%, #476ac4 100%) repeat scroll 0 0 rgba(0, 0, 0, 0);
}
.pollig_yellow {
    background: none repeat scroll 0 0 #fcf3da;
}
.pollig_yellow_content {
    background: linear-gradient(to bottom, #ea9c3a 0px, #f2c547 49%, #ea9c3a 100%) repeat scroll 0 0 rgba(0, 0, 0, 0);
}
.pollig_red {
    background: none repeat scroll 0 0 #f9ded7;
}
.pollig_red_content {
    background: linear-gradient(to bottom, #d03137 0px, #e54141 49%, #d03137 100%) repeat scroll 0 0 rgba(0, 0, 0, 0);
}
.pollig_green {
    background: none repeat scroll 0 0 #eef3da;
}
.pollig_green_content {
    background: linear-gradient(to bottom, #91a138 0px, #a8c447 49%, #91a138 100%) repeat scroll 0 0 rgba(0, 0, 0, 0);
}
.pollig_violet {
    background: none repeat scroll 0 0 #d4f8fc;
}
.pollig_violet_content {
    background: linear-gradient(to bottom, #16a1b2 0px, #3abbca 50%, #16a1b2 100%) repeat scroll 0 0 rgba(0, 0, 0, 0);
}
.pollig_brown {
    background: none repeat scroll 0 0 #e2d1ff;
}
.pollig_brown_content {
    background: linear-gradient(to bottom, #520cc8 0px, #8156cb 50%, #520cc8 100%) repeat scroll 0 0 rgba(0, 0, 0, 0);
}
.pollig_chocolate {
    background: none repeat scroll 0 0 #ffddc2;
}
.pollig_chocolate_content {
    background: linear-gradient(to bottom, #994203 0px, #b76425 50%, #994203 100%) repeat scroll 0 0 rgba(0, 0, 0, 0);
}
.pollig_gray {
    background: none repeat scroll 0 0 #ffcbe3;
}
.pollig_gray_content {
    background: linear-gradient(to bottom, #fc479c 0px, #fa7db6 50%, #fc479c 100%) repeat scroll 0 0 rgba(0, 0, 0, 0);
}
.add_poll_cmnts {
    background: none repeat scroll 0 0 #e25a35;
    border: 0 none;
    border-radius: 0.4em;
    color: #fff;
    cursor: pointer;
    float: left;
    font-size: 0.8em;
    margin-bottom: 20px;
    min-width: 90px;
    padding: 2px 10px;
    text-align: center;
    text-shadow: 1px 1px 0 #bb4120;
}
.polling_area2 {
    box-sizing: border-box;
    float: left;
    padding: 10px 25px 0;
    width: 50%;
    word-wrap: break-word;
}
#poll_form span {
    font-size: 12px;
}
.polling_top h1 a {
    color: #636162;
    font-size: 13px;
    text-decoration: none;
}
.polling_user_name a {
    color: #e25a35;
}




</style>