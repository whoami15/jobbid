<?php

class Application_Model_Site_GoVn
{
	protected static $_instance = null;
	var $cookie = 'Cookie: __auc=b288891613c19c24de646cf2f28; __asc=05771fe013e56618b549a7608ab; ASP.NET_SessionId=xmjjlp3et0e4t445bnsmhwbq; __utma=1.996164593.1367249025.1367249025.1367251674.2; __utmc=1; __utmz=1.1367251674.2.2.utmcsr=news.go.vn|utmccn=(referral)|utmcmd=referral|utmcct=/cong-nghe/tin-1249383/khoi-dong-cuoc-thi-share-link-gonews-rinh-galaxy-s4.htm; ver=; _azs=; __RC=5; __R=3; cpcSelfServ=; ssoinfo=jj7a0bqge2/DtdACXLg/mQ==; ssosession=114289897.dfd27c0f4ab5559325ace23b46e9eed5; __utma=47719928.1358781579.1367251556.1367251556.1367251556.1; __utmb=47719928.1.10.1367251556; __utmc=47719928; __utmz=47719928.1367251556.1.1.utmcsr=(direct)|utmccn=(direct)|utmcmd=(none); NSC_mc.nz.hp.wo=ffffffff766fda1f45525d5f4f58455e445a4a423dd3; __gads=ID=985829372570ef0b:T=1367251636:S=ALNI_MbALIU6F_dMZDHfk_f-kSixDBjDig; __utmb=1.12.10.1367251674; NSC_mc.xxx.hp.wo_bsdijwf=ffffffff766fda1f45525d5f4f58455e445a4a423df1';
	public static function getInstance($className=__CLASS__){
		//Check instance
		if(empty(self::$_instance)){
			self::$_instance = new $className;
		}
		//Return instance
		return self::$_instance;
	}
	public function __construct(){
		
		 
	}
	public function doLogin() {
		$post_string ='__VIEWSTATE=%2FwEPDwUJNzIzMjAyMTc5ZBgBBR5fX0NvbnRyb2xzUmVxdWlyZVBvc3RCYWNrS2V5X18WAQUScmVtZW1iZXJNZUNoZWNrQm94&__SCROLLPOSITIONX=0&__SCROLLPOSITIONY=0&__EVENTTARGET=&__EVENTARGUMENT=&txtUserName=bot01&txtPassword=74198788&rememberMeCheckBox=on&btnLogin=%C4%90%C4%83ng+nh%E1%BA%ADp';
		$cUrl = new Core_Dom_Curl(array(
			'method' => 'POST',
			'post_fields' => $post_string,
			'url' => 'https://go.vn/accounts/account.login.aspx?sid=660009&ur=http%3a%2f%2fwww.go.vn%2fdiendan%2fforum.php&m=1%2c1&continue='
		));
		$result = $cUrl->exec();
		//die('OK');
	}
	public function addFriend($uid) {
		echo 'Add friend uid '.$uid.PHP_EOL;
		$cUrl = new Core_Dom_Curl(array(
			'method' => 'POST',
			'post_fields' => 'type=sendFriendRequest&userId='.$uid.'&message=',
			'url' => 'http://my.go.vn/Action/FriendHandler.ashx',
			'cookie' => $this->cookie
		));
		$result = $cUrl->exec();
		echo $result['body'].PHP_EOL;
		sleep(1);
	}
	public function postWall($uid) {
		echo 'Post on wall of uid '.$uid.PHP_EOL;
		$cUrl = new Core_Dom_Curl(array(
			'method' => 'POST',
			'post_fields' => "sig=SA0Pcg2jGFt%2BGTDpLCSdYSb50GqHEn0meTkRbWyBPXFlumb1E9nCX1pp1qBOzPab&title=Tuy%E1%BB%83n+waitress+ca+t%E1%BB%91i+l%C3%A0m+vi%E1%BB%87c+Qu%E1%BA%ADn+1%2C2&url=http%3A%2F%2Fwww.jobbid.vn%2Fjob%2Fview-job%2Ftuyen-waitress-ca-toi-lam-viec-quan-12%3Fid%3D1140%26ref%3Dgo.vn&attach=%7B+'type'%3A'link'%2C+'href'%3A+'http%3A%2F%2Fwww.jobbid.vn%2Fjob%2Fview-job%2Ftuyen-waitress-ca-toi-lam-viec-quan-12%3Fid%3D1140%26ref%3Dgo.vn'%2C+'title'%3A'Tuy%E1%BB%83n+waitress+ca+t%E1%BB%91i+l%C3%A0m+vi%E1%BB%87c+Qu%E1%BA%ADn+1%2C2'+%7D&msg=&attachType=link&src=http%3A%2F%2Fwww.jobbid.vn%2Fimages%2Flogo.png&desc=-+Greeting+and+arranging+the+table+for+customers.%0A-+Introducing+food+and+drink+according+to+the+order+of+customers.%0A-+Serving+the+food+service+to+customers%0A-+Cleaning+and+arranging+the+table+after+customer+finish+their+meal%0A-+Location%3A+27+Tong+Huu+Dinh%2C+Thao+Dien+Ward%2C+District+2.%0A-+Working+time%3A++2%3A00+p.m+-+10%3A00+p.m...&UserID=$uid&media=&cuid=114289897&hostname=www.jobbid.vn&autodetect=false&hiddenStatus=",
			'url' => 'http://my.go.vn/status.request?type=postlink',
			'cookie' => $this->cookie
		));
		$result = $cUrl->exec();
		echo $result['body'].PHP_EOL;
		sleep(1);
	}
	public function post($uid) {
		//$this->doLogin();
		//$this->addFriend();
		//$this->doLogin();
		//$this->postWall('114201471');die;
		$str = 'EVENTTARGET=&__EVENTARGUMENT=&__VIEWSTATE=%2FwEPDwULLTEyMjEzODAyMDcPZBYCZg9kFgQCBQ9kFgoCBw8WAh4LXyFJdGVtQ291bnQCBRYKZg9kFgJmDxUEATEENTI2MQExDFRo4budaSB0cmFuZ2QCAQ9kFgJmDxUEATIENTI2MgEyC03hu7kgcGjhuqltZAICD2QWAmYPFQQBMwQ1MzM1ATMMR2nDoHkgLyBUw7ppZAIDD2QWAmYPFQQBNAQ1MzM2ATQMUGjhu6UgS2nhu4duZAIED2QWAmYPFQQBNQQ1Mzg0ATUGxJBURMSQZAIJDw9kFgIeCm9ua2V5cHJlc3MFOmlmIChldmVudC5rZXlDb2RlID09IDEzKSB7IGZuU2VhcmNoS2V5V2QoKTsgcmV0dXJuIGZhbHNlO31kAgsPFgIeBFRleHQF0wE8YSBocmVmPScvRGlzcGxheS9TZWFyY2hSZXN1bHQuYXNweD9LZXl3b3JkMT1MZXR6eic%2BTGV0eno8L2E%2BPGEgaHJlZj0nL0Rpc3BsYXkvU2VhcmNoUmVzdWx0LmFzcHg%2FS2V5d29yZDE9VmljdG9yaWFzK3NlY3JldCc%2BVmljdG9yaWFzIHNlY3JldDwvYT48YSBocmVmPScvRGlzcGxheS9TZWFyY2hSZXN1bHQuYXNweD9LZXl3b3JkMT1Ub255bW9seSc%2BVG9ueW1vbHk8L2E%2BZAIMD2QWAmYPZBYCZg9kFgRmD2QWCAIBDxBkZBYAZAIFDxBkZBYAZAIJDxBkZBYAZAINDxBkZBYAZAIBDw8WAh4HVmlzaWJsZWdkZAIND2QWFAIFDw8WAh8CBQEwZGQCBg8PFgIfAgUBMGRkAgcPDxYCHwIFATBkZAIIDw8WAh8CBQEwZGQCCQ8PFgIfAgUBMGRkAg8PDxYCHwIFATBkZAIQDw8WAh8CBQEwZGQCEQ8PFgIfAgUBMGRkAhIPDxYCHwIFATBkZAITDw8WAh8CBQEwZGQCBw8WAh8AAgMWBmYPZBYCAgEPFgIfAgWNAjxkaXY%2BPGEgaHJlZj0naHR0cDovL3d3dy55ZXMyNC52bi9FdmVudC8yMDEzLzMwLTA0LU1haW4uYXNweCc%2BPGltZyBzcmM9Jy9VcGxvYWQvQmFubmVySW1hZ2Uvc2t5TF8wMV8yMDEzMDMzMF90YTEuanBnJyBib3JkZXI9JzAnIC8%2BPC9hPjwvZGl2PjxkaXY%2BPGEgaHJlZj0naHR0cDovL3d3dy5mYWNlYm9vay5jb20veWVzMjR2aW5hJyB0YXJnZXQ9J19ibGFuayc%2BPGltZyBzcmM9Jy9VcGxvYWQvQmFubmVySW1hZ2Uvc2t5X2xlZnRfZmFjZWJvb2suZ2lmJz48L2E%2BPC9kaXY%2BZAIBD2QWAgIBDxYCHwIF1wE8ZGl2PjxhIGhyZWY9J2h0dHA6Ly93d3cueWVzMjQudm4va2h1eWVuLW1haS81MzAxNjAvc3VjLWtob2UtbGEtdmFuZy5odG1sJz48aW1nIHNyYz0nL1VwbG9hZC9CYW5uZXJJbWFnZS9za3lMXzAyXzIwMTMwNDI1X3R2LmpwZycgYm9yZGVyPScwJyAvPjwvYT48L2Rpdj48ZGl2PjxpbWcgc3JjPScvVXBsb2FkL0Jhbm5lckltYWdlL3NreUxfZGFzaGVkbGluZS5qcGcnPjwvZGl2PmQCAg9kFgICAQ8WAh8CBZsBPGRpdj48YSBocmVmPSdodHRwOi8vd3d3LnllczI0LnZuL2todXllbi1tYWkvNTE5ODQwL3RoZS1naW9pLXRoYXQtbHVuZy5odG1sJz48aW1nIHNyYz0nL1VwbG9hZC9CYW5uZXJJbWFnZS9za3lMXzAzXzIwMTMwNDE3X3RrLmpwZycgYm9yZGVyPScwJyAvPjwvYT48L2Rpdj5kGAEFHl9fQ29udHJvbHNSZXF1aXJlUG9zdEJhY2tLZXlfXxYKBSVjdGwwMCRDb250ZW50UGxhY2VIb2xkZXIyJGltYWdlRmllbGQxBSVjdGwwMCRDb250ZW50UGxhY2VIb2xkZXIyJGltYWdlRmllbGQyBSVjdGwwMCRDb250ZW50UGxhY2VIb2xkZXIyJGltYWdlRmllbGQzBSVjdGwwMCRDb250ZW50UGxhY2VIb2xkZXIyJGltYWdlRmllbGQ0BSVjdGwwMCRDb250ZW50UGxhY2VIb2xkZXIyJGltYWdlRmllbGQ1BSVjdGwwMCRDb250ZW50UGxhY2VIb2xkZXIyJGltYWdlRmllbGQ2BSVjdGwwMCRDb250ZW50UGxhY2VIb2xkZXIyJGltYWdlRmllbGQ3BSVjdGwwMCRDb250ZW50UGxhY2VIb2xkZXIyJGltYWdlRmllbGQ4BSVjdGwwMCRDb250ZW50UGxhY2VIb2xkZXIyJGltYWdlRmllbGQ5BSZjdGwwMCRDb250ZW50UGxhY2VIb2xkZXIyJGltYWdlRmllbGQxMA%3D%3D&searchType=0&ctl00%24hdfSearchType=&ctl00%24txtSearch=&ctl00%24ContentPlaceHolder2%24imageField1.x=58&ctl00%24ContentPlaceHolder2%24imageField1.y=54';
		$array = explode('&', $str);
		print_r($array);die;
		$cUrl = new Core_Dom_Curl(array(
			'method' => 'GET',
			'cookie' => $this->cookie
		));
		echo 'Find friends of uid '.$uid.PHP_EOL;
		$content = $cUrl->getContent('http://my.go.vn/friend/handlers/FriendAction.ashx?_=1367253096326&sig=r6aCXZ%2FCemwk0%2FRfit7KuNR8deAmfAH0imDtXBdmX0cTWJuyp%2FcMKizIZYvVMpS5&type=GetAllFriendWithRelation&friendAccountId='.$uid);
		$array = json_decode($content);
		$array = $array->value->FriendBEs;
		foreach ($array as $item) {
			$this->postWall($item->AccountId);
		}
		//print_r(count($array));die;
		//Core_Utils_Log::write($content);
	}
}

