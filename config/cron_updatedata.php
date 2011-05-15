<?php
	//include ('/home/jobbid/public_html/library/dataprovider.php');
	//include ('/home/jobbid/public_html/library/sendmail.php');
	include ('/home/jobbid/public_html/config/cronconfig.php');
	include (ROOT.DS.'library'.DS.'dataprovider.php');
	$conn=new DataProvider();
	echo 'updateNewProject;';
	$conn->updateNewProject();
	echo 'updateSoduan;';
	$conn->updateSoduan();
	echo 'updateStatistics;';
	$conn->updateStatistics();
	echo 'updateCache;';
	$conn->updateCache();
	$conn->close();
	echo 'DONE';
	
?>