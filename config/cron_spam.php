<?php
	//include (dirname(__FILE__).'/config/cronconfig.php');
	include ('/home/jobbid/public_html/config/cronconfig.php');
	include (ROOT.DS.'library'.DS.'dataprovider.php');
	include (ROOT.DS.'library'.DS.'sendmail.php');
	$conn=new DataProvider();
	$senders = $conn->get_cache('senders');
	$content = $conn->get10NewProject();
	$mail=new sendmail();
	$data = $conn->getEmailSpam();
	if(!empty($data)){
		foreach($data as $e) {
			try {
				$sender = $senders['secSender'];
				$mail->send($e->email, 'Jbobbid.vn - Danh Sách Công Việc Bán Thời Gian Mới!!!', $content,$sender);
				sleep(3);
			} catch (Exception $e) {
			}
		}
	}
	$conn->close();
	echo 'DONE';
	
?>