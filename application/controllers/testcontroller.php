<?php

class TestController extends VanillaController {
	function __construct($controller, $action) {		
		global $inflect;
		$this->_controller = ucfirst($controller);
		$this->_action = $action;
		$model = "test";
		$this->$model =& new $model;
		$this->_template =& new Template($controller,$action);

	}
	function beforeAction () {
		performAction('webmaster', 'updateStatistics');
	}
	function setModel($model) {
		 $this->$model =& new $model;
	}
	function doLogin() {
		$username = $_POST['username'];
		$password = $_POST['password'];
		//die($username);
		$this->setModel('account');
		$password = mysql_real_escape_string($password);
		$this->account->where(" and username='$username' and password='$password'");
		$data = $this->account->search('*');
		print_r($data);
		echo 'DONE';
	}
	function index() {
		//die('aa');
		/* if(date("l")=='Tuesday')
			echo 'Thu 3';
		else
			echo 'Ko phai thu 3'; */
		//echo mt_rand(0, 1);
		/* include (ROOT.DS.'library'.DS.'sendmail.php');
		global $cache;
		$senders = $cache->get('senders');
		$sender = $senders['secSender'];
		$mail=new sendmail($sender);
		$mail->send2('nclong87@gmail.com','hello','test');
		$mail->send2('nclong870@gmail.com','hello2','test2');
		echo 'DONE'; */
		include (ROOT.DS.'library'.DS.'dataprovider.php');
		$conn=new DataProvider();
		//$conn->onSpam();
		
		$conn->updateCache();
		$conn->close(); 
		echo 'DONE';
		/* $mail=new sendmail();
		$conn->lstNewProject();
		$data = $conn->getListSendmail();
		$arr = array();
		
		/* $this->setModel("duan");
		$this->duan->orderBy('duan.id','desc');
		$this->duan->setPage(1);
		$this->duan->setLimit(PAGINATE_LIMIT);
		$this->duan->where(" and active = 1 and nhathau_id is null and ngayketthuc>now()");
		$this->duan->search('*',true); */
		//$this->test->query("select InsertPage() as newid");
		//sendMail("nclong87@gmail.com", "Xin chao", "Xin chào <b>Nguyễn Chí Long</b>");
		//die("done");
		//$cache_expire = session_cache_expire();
		//echo "The cached session pages expire after $cache_expire minutes"; 
		/* include (ROOT.DS.'library'.DS.'dataprovider.php');
		//include (ROOT.DS.'library'.DS.'sendmail.php');
		
		$conn->hadSend($arr);
		$conn->updateStatistics();
		$conn->close(); */
		//echo $_SESSION['test'];
		/* include (ROOT.DS.'library'.DS.'crawler.php');
		$crawl = new crawler('http://thienduongweb.com'); 
		$images = $crawl->get('images'); 
		$links = $crawl->get('links');
		print_r($images); */
		/* $handle = fopen("http://www.raovat.vn/lao-dong-viec-lam/nhung-trang-web-kiem-tien-uy-tin-nhat-hien-nay-raovat-403664636.html", "rb");
		$contents = stream_get_contents($handle);
		fclose($handle);
		$str2 = strtolower($contents);
		//echo $str2;
		$start = strpos($str2, "email: ")+8;
		$end   = strpos($str2, " ",$start);
		$email= trim(substr($contents, $start, $end-$start));
		echo $email; */
		//$_COOKIE['username'] = 'hello';
		//setcookie('duan_id', 34);
		//$_SESSION['submit_login_times'] = null;
		//echo $_COOKIE['username'];
		//include (ROOT.DS.'library'.DS.'sendmail.php');
		//$mail = new sendmail();
		//$mail->send('nclong87@gmail.com','Mail Xác Nhận Đăng Ký Tài Khoản JobBid.vn','Tôi là Nguyễn Chí Long');
		//echo 'DONE';
		/* $domain = $_GET['domain'];
		if(empty($domain)==false) {
			$ip = gethostbyname($domain);
			if($domain != $ip) {
				echo "IP Address : $ip<br>";
			}
			$handle = fopen("http://dns.hostdime.com/$domain/", "rb");
			$contents = stream_get_contents($handle);
			fclose($handle);
			$start = strpos($contents, "<th>Name Servers Reported By Your Servera</th>");
			$end = strpos($contents,"Name servers returned by the registrar.",$start);
			$pos1=$start;
			$i=1;
			while($i<10) {
				$pos1 = strpos($contents,"<td>",$pos1);
				if($pos1==false || $pos1>$end)
					break;
				$pos2 = strpos($contents,"</td>",$pos1);
				$ns = trim(substr($contents, $pos1, $pos2-$pos1));
				echo "Name Server $i : $ns<br>";
				$pos1 = $pos2;
				$i++;
			}
		} */

	}
	function rmvsession($session) {
		$_SESSION[$session] = null;
		echo 'DONE';
	}
	function stop() {
		$_SESSION['flag'] = true;
	}
	function start() {
		$i=0;
		$_SESSION['flag'] = false;
		while($i<10) {
			if($_SESSION['flag']==true)
				break;
			$i++;
			sleep(1);
		}
		echo $i;
	}
	function process() {
		if(!isset($_SESSION['process']))
			$_SESSION['process'] = 0;
		$_SESSION['process'] = $_SESSION['process'] + 1;
		//Process
		sleep(10);
		//$_SESSION['process'] = $_SESSION['process'] - 1;
		echo 'DONE';
		
	}
	function pagetest() {
		$totalProcess = 0;
		if(isset($_SESSION['process']))
			$totalProcess = $_SESSION['process'];
		$this->set('totalProcess',$totalProcess);
		$this->_template->renderPage();
	}
    function restart() {
		session_destroy();
		echo "DONE";
	}	
	function afterAction() {

	}

}