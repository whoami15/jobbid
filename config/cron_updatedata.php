<?php
	//include ('/home/jobbid/public_html/library/dataprovider.php');
	//include ('/home/jobbid/public_html/library/sendmail.php');
	include ('/home/jobbid/public_html/config/cronconfig.php');
	include (ROOT.DS.'library'.DS.'dataprovider.php');
	$conn=new DataProvider();
	$conn->updateSoduan();
	$conn->updateStatistics();
	$conn->close();
	echo 'DONE';
	
?>