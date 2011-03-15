<?php
	//include ('/home/jobbid/public_html/library/dataprovider.php');
	//include ('/home/jobbid/public_html/library/sendmail.php');
	include ('/home/jobbid/public_html/config/cronconfig.php');
	include (ROOT.DS.'library'.DS.'dataprovider.php');
	$conn=new DataProvider();
	echo 'updateEmailToEmployers;';
	$conn->expiredProjects();
	$conn->close();
	echo 'DONE';
	
?>