<?php 
class DataProvider
{
	var $link;
	function DataProvider()
	{
		$this->link=mysql_connect("localhost:3306","root","");
		if(!$this->link)
			die("Not connect to MySQL");
	  	$db="cms";
		if(!mysql_select_db($db,$this->link))
			die("Error:".mysql_error());
		mysql_query("SET NAMES 'utf8'");
	}
	function updateSoduan()
	{
		$query='select * from linhvucs';
		$result = mysql_query($query,$this->link);
		if($result == null || mysql_num_rows($result)==0) {
			return;
		}
    	$i=0;
		while($a_row=mysql_fetch_object($result))
		{
			$linhvuc_id = $a_row->id;
			$query = "update linhvucs set linhvucs.soduan = (SELECT count(*) FROM `duans` as `duan`  WHERE '1'='1'  and active = 1 and nhathau_id is null and ngayketthuc > now() and linhvuc_id = '$linhvuc_id') where linhvucs.id='$linhvuc_id'";
			mysql_query($query,$this->link);
            $i++;
		}
	}
	function getListSendmail(){
		$query='select * from sendmails';
		$result = mysql_query($query,$this->link);
		if($result == null || mysql_num_rows($result)==0) {
			return null;
		}
    	$i=0;
		$arr = array();
		while($a_row=mysql_fetch_object($result))
		{
			array_push($arr,$a_row);
            $i++;
		}
		return $arr;
	}
	function hadSend($arr) {
		$lstId = '';
		$i=0;
		while($i<count($arr)) {
			$id = $arr[$i];
			if($i==count($arr)-1) {
				$lstId.=$id;
			} else {
				$lstId.=$id.',';
			}
			$i++;
		}
		if(empty($lstId))
			return;
		echo "delete from sendmails where id in ($lstId)";
	}
	function close() {
		mysql_close($this->link);
	}
}
	
	
?>