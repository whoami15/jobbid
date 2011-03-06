<?php
	//include (dirname(__FILE__).'/config/cronconfig.php');
	include ('/home/jobbid/public_html/config/cronconfig.php');
	include (ROOT.DS.'library'.DS.'dataprovider.php');
	$conn=new DataProvider();
	$conn->onSpam();
	$conn->close();
	echo 'BAT CO CHO PHEP GUI EMAIL SPAM';
	
?>