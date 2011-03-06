<?php
	//include (dirname(__FILE__).'/config/cronconfig.php');
	include ('/home/jobbid/public_html/config/cronconfig.php');
	include (ROOT.DS.'library'.DS.'dataprovider.php');
	include (ROOT.DS.'library'.DS.'sendmail.php');
	$conn=new DataProvider();
	$data = $conn->getEmailSpam();
	if(!empty($data)){
		$mail=new sendmail();
		$senders = $conn->get_cache('senders');
		$content = $conn->get10NewProject();
		$arrTo = array();
		foreach($data as $e) {
			array_push($arrTo,$e->email);
		}
		try {
			$sender = $senders['secSender'];
			$mail->send($arrTo, 'Jbobbid.vn - Danh Sách Công Việc Bán Thời Gian Mới!!!', $content,$sender);
			$conn->close();
			echo 'Send Mail Success';
		} catch (Exception $e) {
			$conn->close();
			echo 'Send Mail Error';
		}
	} else
		echo 'No Email To Send';
?>