<?php 
class DataProvider
{
	var $link;
	function DataProvider()
	{
		$this->link=mysql_connect("localhost:3306","jobbid_nclong87","74198788");
		if(!$this->link)
			die("Not connect to MySQL");
	  	$db="jobbid_mycms";
		if(!mysql_select_db($db,$this->link))
			die("Error:".mysql_error());
		mysql_query("SET NAMES 'utf8'");
	}
	function test($value)
	{
		$query="Insert into tests values (N'$value')";
		if(!mysql_query($query,$this->link))
			die("Error :".mysql_error());
	}
	function close() {
		mysql_close($this->link);
	}
}
	
	
?>