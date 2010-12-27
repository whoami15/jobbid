<?php
	include("dataprovider.php");
	$conn=new DataProvider();
	$conn->test('23/12/2010');
	$conn->close();
	echo 'DONE';
	
?>