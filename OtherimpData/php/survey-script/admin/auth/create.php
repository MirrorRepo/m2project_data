<?php

$link = mysql_connect($hostname, $username,$password);

if($link)
{

 	$dbcon = mysql_select_db($dbname,$link);

	if($dbcon)
	{
		
		
	    	$result = mysql_query("CREATE TABLE hioxpm (username varchar(255) NOT NULL, password varchar(255) default '',  PRIMARY KEY (username))",$link);
		$result1 = @mysql_query("CREATE TABLE IF NOT EXISTS `survey` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` varchar(80) NOT NULL,
  `description` varchar(80) NOT NULL,
  `opt1` varchar(100) NOT NULL DEFAULT '0',
  `opt2` varchar(100) NOT NULL DEFAULT '0',
  `opt3` varchar(100) NOT NULL DEFAULT '0',
  `opt4` varchar(100) NOT NULL DEFAULT '0',
  `opt5` varchar(100) NOT NULL DEFAULT '0',
  `status` varchar(20) NOT NULL DEFAULT 'No',
  `dat` date NOT NULL,
  `todate` date NOT NULL,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33 ;
",$link);

	$result4 = @mysql_query("INSERT INTO `survey` (`id`, `question`, `description`, `opt1`, `opt2`, `opt3`, `opt4`, `opt5`, `status`, `dat`, `todate`, `name`) VALUES
(1, 'What is the cause of India Semi Final lose against Australia', 'What is the cause of India Semi Final lose against Australia', 'Australia was better', 'kohli performance', 'Indian Fielding', 'Indian Bowling', 'Whole Team', 'Yes', '0000-00-00', '0000-00-00', ''),
(2, 'How do you rate Modi Govt first full fledged year budget', 'How do you rate Modi Govt first full fledged year budget', 'Good long term oriented budget', 'Partly good partly bad', 'Nothing useful for middle and lower class people', 'No Comments', '', 'Yes', '0000-00-00', '0000-00-00', ''),
(3, 'What is your age?', 'What is your age', '25 or under', '26-40', '41-55', '56 or older', '', 'Yes', '0000-00-00', '0000-00-00', ''),
(4, 'What is your gender?', 'What is your gender', 'Male', 'Female', '', '', '', 'No', '0000-00-00', '0000-00-00', ''),
(5, 'How did you first hear about our web site?', 'How did you first hear about our web site', 'Internet', 'Newspaper', 'Word-of-mouth', 'Friends', 'Others', 'No', '0000-00-00', '0000-00-00', '')
",$link);	
		
	
	
	
		
$result2 = @mysql_query("CREATE TABLE IF NOT EXISTS `rating` (
  `id` int(20) NOT NULL,
  `opt1` int(20) NOT NULL DEFAULT '0',
  `opt2` int(20) NOT NULL DEFAULT '0',
  `opt3` int(20) NOT NULL DEFAULT '0',
  `opt4` int(20) NOT NULL DEFAULT '0',
  `opt5` int(20) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;",$link);

$result3 = @mysql_query("CREATE TABLE IF NOT EXISTS `user_survey` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `uid` int(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `question` varchar(200) NOT NULL,
  `options` varchar(100) NOT NULL,
  `opt1` int(20) NOT NULL DEFAULT '0',
  `opt2` int(20) NOT NULL DEFAULT '0',
  `opt3` int(20) NOT NULL DEFAULT '0',
  `opt4` int(20) NOT NULL DEFAULT '0',
  `opt5` int(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17") ;
                              
$result5 = @mysql_query("INSERT INTO `rating` (`id`, `opt1`, `opt2`, `opt3`, `opt4`, `opt5`) VALUES
(1, 0, 0, 3, 0, 1),
(2, 1, 0, 2, 1, 0),
(3, 2, 0, 2, 1, 0),
(4, 0, 0, 0, 0, 0)",$link);
		@mysql_free_result($link);
	 	if (!$result)
		{
		    
                   echo(" <div align='center' class='errortext'>
				 <p class='errortext'>Unable to create tables.<br>");
		     echo("Your tables might have already be created.</p>");
		    echo(" <div>");
		    //echo(mysql_error());
		}
		else
		{
		   include "adminpass.php";
		}
	}
	else
	{
		$vv =false;
	}
}
else
{
	$vv =false;
}


if($vv === false)
{
 echo	"<div class='form' style='margin:25px;border:1px solid #ddd;padding:10px;'>";
 echo "<form method=POST action=$PHP_SELF>";
 echo "<input type=hidden name=type value=changedb>";
 echo "<div class='errortext'>Unable to connect to the database.<br>
	Please check your database entries  </div><br><input type=submit value='dbentries' class='form_button' style='float:left;'><div style='clear:both;'></div>";
 echo "</form>";
echo(" </div>");

}
?>
