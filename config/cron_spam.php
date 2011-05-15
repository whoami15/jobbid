<?php
	//include (dirname(__FILE__).'/config/cronconfig.php');
	include ('/home/jobbid/public_html/config/cronconfig.php');
	include (ROOT.DS.'library'.DS.'dataprovider.php');
	include (ROOT.DS.'library'.DS.'sendmail.php');
	$conn=new DataProvider();
	$data = $conn->getEmailSpam();
	if(!empty($data)){
		$mail=new sendmail();
		$secSenders = $conn->get_cache('secSenders');
		$lenSecSenders = count($secSenders);
		$content = $conn->get10NewProject();
		$arrTo = array();
		foreach($data as $e) {
			array_push($arrTo,$e->email);
		}
		try {
			$flag = true;
			while($flag) {
				$rand = mt_rand(0, $lenSecSenders-1);
				$sender = $secSenders[$rand];
				if($sender == null) {
					$mail->send(ADMIN_EMAIL, 'SMTP Error!!!', 'No email sender',$emailGlobal);
					$flag = false;
				} else {
					if($mail->send($arrTo, 'JobBid.vn - Danh Sách Công Việc Bán Thời Gian Mới!!!', $content,$sender)==false) {
						unset($secSenders[$rand]);
						$secSenders = array_values($secSenders);
						$lenSecSenders--;
						$conn->set_cache('secSenders',$secSenders);
						$msgError = 'Email '.$sender['email'].' cannot send!';
						$mail->send(ADMIN_EMAIL, 'SMTP Error!!!', $msgError,$emailGlobal);
					} else {
						$flag = false;
						echo 'Send Mail Success';
					}
				}
			}
		} catch (Exception $e) {
			echo 'Send Mail Error';
		}
	} else
		echo 'No Email To Send';
	$conn->close();
?>