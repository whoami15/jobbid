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
		$result = mysql_query($query,$this->link) or die("Error:".mysql_error());
		if($result == null || mysql_num_rows($result)==0) {
			return;
		}
    	$i=0;
		while($a_row=mysql_fetch_object($result))
		{
			$linhvuc_id = $a_row->id;
			$query = "update linhvucs set linhvucs.soduan = (SELECT count(*) FROM `duans` as `duan`  WHERE '1'='1'  and active = 1 and nhathau_id is null and ngayketthuc > now() and linhvuc_id = '$linhvuc_id') where linhvucs.id='$linhvuc_id'";
			mysql_query($query,$this->link) or die("Error:".mysql_error());
            $i++;
		}
	}
	function getListSendmail(){
		$query='select * from sendmails limit 0,10';
		$result = mysql_query($query,$this->link) or die("Error:".mysql_error());
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
	function get10NewProject() {
		$query = "SELECT * FROM `duans` as `duan` WHERE '1'='1' and active = 1 and approve=1 and nhathau_id is null and ngayketthuc>now() ORDER BY duan.id desc LIMIT 10 OFFSET 0";
		$result = mysql_query($query,$this->link) or die("Error:".mysql_error());
		if($result == null || mysql_num_rows($result)==0) {
			return;
		}
		$duannew = '';
		while($a_row=mysql_fetch_object($result)) {
			$duannew.='<a href="'.BASE_PATH.'/duan/view/'.$a_row->id.'/'.$a_row->alias.'">'.$a_row->tenduan.'</a><br>';
		}
		$content = $this->get_cache('mail_spam');
		$search  = array('#DUAN#');
		$replace = array($duannew);
		$content = str_replace($search, $replace, $content);
		return $content;
	}
	function onSpam() {
		$this->set_cache('spamOffset',0);
	}
	function getEmailSpam() {
		$spamOffset = $this->get_cache('spamOffset');
		if($spamOffset==null) {
			$spamOffset = 0;
		}
		$arr = array();
		if($spamOffset == -1)
			return $arr;
		$query="select * from emails limit $spamOffset,10";
		$result = mysql_query($query,$this->link) or die("Error:".mysql_error());
		if($result == null || mysql_num_rows($result)==0) {
			$this->set_cache('spamOffset',-1);
			return $arr;
		}
		while($a_row=mysql_fetch_object($result)) {
			array_push($arr,$a_row);
		}
		if(isset($arr[9]))
			$spamOffset+=10;
		else
			$spamOffset=-1; //Off Spam
		$this->set_cache('spamOffset',$spamOffset);
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
		mysql_query("delete from sendmails where id in ($lstId)",$this->link) or die("Error:".mysql_error());
	}
	function get_cache($fileName) {
		$fileName = ROOT.DS.'tmp'.DS.'cache'.DS.$fileName;
		if (file_exists($fileName)) {
			$handle = fopen($fileName, 'rb');
			$variable = fread($handle, filesize($fileName));
			fclose($handle);
			return unserialize($variable);
		} else {
			return null;
		}
	}
	function set_cache($fileName,$variable) {
		$fileName = ROOT.DS.'tmp'.DS.'cache'.DS.$fileName;
		$handle = fopen($fileName, 'w');
		fwrite($handle, serialize($variable));
		fclose($handle);
	}
	function updateStatistics() {
		$statistics = $this->get_cache('statistics');
		$result = mysql_query('select count(*) as total from duans where active=1 and approve=1',$this->link) or die("Error:".mysql_error());
		$statistics['tProjects'] = mysql_fetch_object($result)->total;
		/* $result = mysql_query('select count(*) as total from accounts where active>=0',$this->link) or die("Error:".mysql_error());
		$statistics['tAccounts'] = mysql_fetch_object($result)->total;
		$result = mysql_query('select count(*) as total from nhathaus where `status`>=0',$this->link) or die("Error:".mysql_error());
		$statistics['tFreelancers'] = mysql_fetch_object($result)->total; */
		$result = mysql_query('select count(*) as total from duans where active=1 and approve=1 and nhathau_id is not null',$this->link) or die("Error:".mysql_error());
		$statistics['tFinishProjects'] = mysql_fetch_object($result)->total;
		$result = mysql_query('select count(*) as total from duans where active = 1 and approve=1 and nhathau_id is null and ngayketthuc>now()',$this->link) or die("Error:".mysql_error());
		$statistics['tLiveProjects'] = mysql_fetch_object($result)->total;
		$this->set_cache('statistics',$statistics);
	}
	function updateNewProject() {
		$query="SELECT id,alias,tenduan,costmin,costmax,ngayketthuc,linhvuc_id from duans where isnew=1 and active=1 and approve=1 and nhathau_id is null and ngayketthuc>now()";
		$result = mysql_query($query,$this->link) or die("Error:".mysql_error());
		if($result == null || mysql_num_rows($result)==0) {
			return;
		}
		$content = $this->get_cache('mail_newproject');
		while($a_row=mysql_fetch_object($result))
		{
			$duan_id = $a_row->id;
			mysql_query("update duans set isnew=0 where id=$duan_id",$this->link) or die("Error:".mysql_error());
			$alias = $a_row->alias;
			$tenduan = $a_row->tenduan;
			$linhvuc_id = $a_row->linhvuc_id;
			$query="SELECT username FROM `nhathaulinhvucs` as `nhathaulinhvuc` LEFT JOIN `nhathaus` as `nhathau` ON `nhathaulinhvuc`.`nhathau_id` = `nhathau`.`id`  LEFT JOIN `accounts` as `account` ON `account`.`id` = `nhathau`.`account_id`   WHERE '1'='1'  and linhvuc_id='$linhvuc_id' and account.active>0 and nhanemail=1";
			$result2 = mysql_query($query,$this->link) or die("Error:".mysql_error());
			if($result2 == null || mysql_num_rows($result2)==0) {
				continue;
			}
			$kinhphi = $a_row->costmin.' đến '.$a_row->costmax.' (VNĐ) ' ;
			$sqldate = strtotime($a_row->ngayketthuc);
			$ngayketthuc = date('d/m/Y', $sqldate);
			$link = "<a href='http://www.jobbid.vn/duan/view/$duan_id/$alias'>http://www.jobbid.vn/duan/view/$duan_id/$alias</a>";
			$link = mysql_real_escape_string($link);
			$search  = array('#TENDUAN#', '#KINHPHI#', '#NGAYKETTHUC#', '#LINK#');
			$replace = array($tenduan, $kinhphi, $ngayketthuc, $link);
			$newcontent = str_replace($search, $replace, $content);
			while($a_row2=mysql_fetch_object($result2)) {
				$email = $a_row2->username;
				$query = "insert into sendmails values (null,'$email','$tenduan','$newcontent',0)";
				mysql_query($query,$this->link) or die("Error:".mysql_error());
			}
		}
	}
	function getDaysFromSecond($second) {
		if($second<=0) {
			return "Đã hết hạn.";
		} 
		$d = (int)($second/86400);
		$second = $second%86400;
		$h = (int)($second/3600);
		$str = '';
		if($d>0) {
			if($h==0)
				$str = "$d ngày";
			else
				$str = "$d ngày $h giờ";
			return $str;
		}
		$second = $second%3600;
		$m = (int)($second/60);
		if($h>0) {
			if($m==0)
				$str = "$h giờ";
			else
				$str = "$h giờ $m phút";
			return $str;
		}
		$second = $second%60;
		if($m==0)
			$str = "$second giây";
		else
			$str = "$m phút $second giây";
		return $str;
	}
	function preexpiredProjects() {
		$query="select id,tenduan,duan_email,alias,editcode,views,bidcount,averagecost,UNIX_TIMESTAMP(ngayketthuc)-UNIX_TIMESTAMP(now()) as timeleft from duans where isbid=1 and active = 1 and approve=1 and nhathau_id is null and ((UNIX_TIMESTAMP(ngayketthuc)-UNIX_TIMESTAMP(now()) ) BETWEEN 0 AND 259200)";
		$result = mysql_query($query,$this->link) or die("Error:".mysql_error());
		if($result == null || mysql_num_rows($result)==0) {
			return;
		}
		$contentsrc = $this->get_cache('mail_expiredproject');
		while($a_row=mysql_fetch_object($result)) {
			//print_r($a_row);die();
			$id = $a_row->id;
			$tenduan = $a_row->tenduan;
			$alias = $a_row->alias;
			$email = $a_row->duan_email;
			$editcode = $a_row->editcode;
			$views = $a_row->views;
			$bidcount = $a_row->bidcount;
			$averagecost = $a_row->averagecost;
			$timeleft = $a_row->timeleft;
			$time = $this->getDaysFromSecond($timeleft);
			if($timeleft>0)
				$stime = "còn <font color='red'>$time</font> là";
			$stime = mysql_real_escape_string($stime);
			$linkviewname = "<a href='http://www.jobbid.vn/duan/view/$id/$alias&editcode=$editcode'>$tenduan</a>";
			$linkviewname = mysql_real_escape_string($linkviewname);
			$linkview = "<a href='http://www.jobbid.vn/duan/view/$id/$alias&editcode=$editcode'>http://www.jobbid.vn/duan/view/$id/$alias</a>";
			$linkview = mysql_real_escape_string($linkview);
			$linkedit = "<a href='http://www.jobbid.vn/duan/edit/$id&editcode=$editcode'>http://www.jobbid.vn/duan/edit/$id</a>";
			$linkedit = mysql_real_escape_string($linkedit);
			$search  = array('#LINKVIEWNAME#','#TIME#','#VIEWS#','#SOHOSO#','#GIATHAUTB#','#LINKVIEW#','#LINKEDIT#');
			$replace = array($linkviewname, $stime, $views, $bidcount, $averagecost, $linkview, $linkedit);
			$newcontent = str_replace($search, $replace, $contentsrc);
			$query = "insert into sendmails values (null,'$email','Công việc [$tenduan] của bạn còn $time là hết hạn đấu thầu!!!','$newcontent',0)";
			mysql_query($query,$this->link) or die("Error:".mysql_error());
		}
	}
	function expiredProjects() {
		$query="select id,tenduan,duan_email,alias,editcode,views,bidcount,averagecost from duans where isbid=1 and active = 1 and approve=1 and nhathau_id is null and ngayketthuc<now()";
		$result = mysql_query($query,$this->link) or die("Error:".mysql_error());
		if($result == null || mysql_num_rows($result)==0) {
			return;
		}
		$contentsrc = $this->get_cache('mail_expiredproject');
		while($a_row=mysql_fetch_object($result)) {
			//print_r($a_row);die();
			$id = $a_row->id;
			$tenduan = $a_row->tenduan;
			$alias = $a_row->alias;
			$email = $a_row->duan_email;
			$editcode = $a_row->editcode;
			$views = $a_row->views;
			$bidcount = $a_row->bidcount;
			$averagecost = $a_row->averagecost;
			$linkviewname = "<a href='http://www.jobbid.vn/duan/view/$id/$alias&editcode=$editcode'>$tenduan</a>";
			$linkviewname = mysql_real_escape_string($linkviewname);
			$linkview = "<a href='http://www.jobbid.vn/duan/view/$id/$alias&editcode=$editcode'>http://www.jobbid.vn/duan/view/$id/$alias</a>";
			$linkview = mysql_real_escape_string($linkview);
			$linkedit = "<a href='http://www.jobbid.vn/duan/edit/$id&editcode=$editcode'>http://www.jobbid.vn/duan/edit/$id</a>";
			$linkedit = mysql_real_escape_string($linkedit);
			$search  = array('#LINKVIEWNAME#','#TIME#','#VIEWS#','#SOHOSO#','#GIATHAUTB#','#LINKVIEW#','#LINKEDIT#');
			$replace = array($linkviewname,'đã', $views, $bidcount, $averagecost, $linkview, $linkedit);
			$newcontent = str_replace($search, $replace, $contentsrc);
			$query = "insert into sendmails values (null,'$email','Công việc [$tenduan] của bạn đã hết hạn đấu thầu!!!','$newcontent',0)";
			mysql_query($query,$this->link) or die("Error:".mysql_error());
		}
	}
	function query($query) {
		$result = mysql_query($query);
		$data = array();
		$tempResults = array();
		$table = array();
		$field = array();
		$numOfFields = mysql_num_fields($result); //or die("Loi:".mysql_error().$this->_query);
		for ($i = 0; $i < $numOfFields; ++$i) {
		    array_push($table,mysql_field_table($result, $i));
		    array_push($field,mysql_field_name($result, $i));
		}
		if (mysql_num_rows($result) > 0 ) {
			while ($row = mysql_fetch_row($result)) {
				for ($i = 0;$i < $numOfFields; ++$i) {
					$tempResults[$table[$i]][$field[$i]] = $row[$i];
				}
				array_push($data,$tempResults);
			}
			if (mysql_num_rows($result) == 1 && $this->id != null) {
				mysql_free_result($result);
				return($data[0]);
			} else {
				mysql_free_result($result);
				return($data);
			}
		} else {
			return $data;
		}
	}
	function updateCache() {
		$data = $this->query("SELECT duan.id,tenduan,alias,linhvuc_id,tenlinhvuc,averagecost,ngaypost,prior,views,bidcount,UNIX_TIMESTAMP(ngayketthuc)-UNIX_TIMESTAMP(now()) as timeleft,duan.active,isbid FROM `duans` as `duan` LEFT JOIN `linhvucs` as `linhvuc` ON `duan`.`linhvuc_id` = `linhvuc`.`id` WHERE '1'='1' and prior>0 and active = 1 and approve = 1 and nhathau_id is null and ngayketthuc>now() ORDER BY prior desc LIMIT 10 OFFSET 0");
		$this->set_cache('vipProjects',$data);
		$data = $this->query("SELECT duan.id,tenduan,alias,linhvuc_id,tenlinhvuc,giathau,prior,bidcount,displayname,duan.nhathau_id,duan.active,nhathau_alias FROM `duans` as `duan` LEFT JOIN `linhvucs` as `linhvuc` ON `duan`.`linhvuc_id` = `linhvuc`.`id` LEFT JOIN `nhathaus` as `nhathau` ON `duan`.`nhathau_id` = `nhathau`.`id` LEFT JOIN `hosothaus` as `hosothau` ON `duan`.`hosothau_id` = `hosothau`.`id` WHERE '1'='1' and duan.active = 1 and approve = 1 and duan.nhathau_id is not null ORDER BY timeupdate desc LIMIT 7 OFFSET 0");
		$this->set_cache('finishedProjects',$data);
		$result = $this->query("SELECT id,tieude,alias FROM `raovats` as `raovat` WHERE status=1 and isvip=1 and expirevip > now() order by ngayupdate desc LIMIT 7 OFFSET 0");
		$data = array();
		foreach($result as $raovat) {
			array_push($data,array('id'=>$raovat['raovat']['id'],'tieude'=>$raovat['raovat']['tieude'],'alias'=>$raovat['raovat']['alias']));
		}
		$this->set_cache('vips',$data);
		
	}
	function close() {
		mysql_close($this->link);
	}
}
	
	
?>