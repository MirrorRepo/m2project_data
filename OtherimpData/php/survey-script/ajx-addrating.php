<?php
error_reporting(0);
include "./admin/auth/config.php";
$link = mysql_connect($hostname, $username,$password) or die ("Could not connect");
mysql_select_db($dbname,$link);
 $ipadd = $_SERVER['REMOTE_ADDR'];
 if(isset($_POST['id']))
  {   
   $opt=$_POST['val'];
   $ip = $_POST['ip'];
   $id = $_POST['id'];
   $new = explode(",",$opt);
   $newid = explode(",",$id);
   
   $ques = $_POST['ques'];
   $question = explode(",",$ques);
   $option = $_POST['option'];
   $optval = explode(",",$option);
   $name=$_POST['name'];
  
   $j=1;
   
   for($i=0;$i<count($new);$i++)
   {
        $qry = mysql_query("SELECT * FROM rating WHERE id IN($id)");
        //echo "SELECT * FROM rating WHERE id IN($id)";
        $dd = mysql_fetch_array($qry,MYSQL_BOTH);
        $vall = $dd[1];
        
        $query = "UPDATE rating SET $new[$i]=$new[$i]+1,ip='$ip' WHERE id=$newid[$i]";
        $delquery=mysql_query($query);
        //echo "Thanks For Rating Us!!!";
        $qry = "INSERT into user_survey SET uid=$newid[$i],name='$name',question='$question[$j]',options='$optval[$i]',$new[$i]=$new[$i]+1";
        $upt = mysql_query($qry);
        
        
       
        $j++;
             
   }
   if($qry)
   {        
      echo "Thanks For Rating Us!!!";              
   }
   
  }
  
  