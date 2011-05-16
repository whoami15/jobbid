<?php
	//include ('/home/jobbid/public_html/library/dataprovider.php');
	//include ('/home/jobbid/public_html/library/sendmail.php');
	include ('/home/jobbid/public_html/config/cronconfig.php');
	include (ROOT.DS.'library'.DS.'dataprovider.php');
	include (ROOT.DS.'library'.DS.'sendmail.php');
	$conn=new DataProvider();
	$data = $conn->getListSendmail();
	if(!empty($data)){
		$mail=new sendmail();
		$arr = array();
		$priSenders = $conn->get_cache('priSenders');
		$secSenders = $conn->get_cache('secSenders');
		$lenPriSenders = count($priSenders);
		$lenSecSenders = count($secSenders);
		$rand = mt_rand(0, $lenPriSenders-1);
		$sender1 = $priSenders[$rand];
		$rand = mt_rand(0, $lenSecSenders-1);
		$sender2 = $secSenders[$rand];
		$emailGlobal = array('email'=>GLOBAL_EMAIL,'password'=>GLOBAL_PASS,'smtp'=>GLOBAL_SMTP,'port'=>GLOBAL_PORT);
		foreach($data as $e) {
			try {
				$flag = true;
				while($flag) {
					$sender = $sender1;
					if($e->isprior != 1) {
						$sender = $sender2;
					}
					if($sender == null) {
						$mail->send(ADMIN_EMAIL, 'SMTP Error!!!', 'No email sender',$emailGlobal);
						$flag = false;
					} else {
						if($mail->send($e->to, $e->subject, $e->content,$sender)==false) {
							if($e->isprior != 1) {
								unset($secSenders[$rand]);
								$secSenders = array_values($secSenders);
								$lenSecSenders--;
								$conn->set_cache('secSenders',$secSenders);
							} else {
								unset($priSenders[$rand]);
								$priSenders = array_values($priSenders);
								$lenPriSenders--;
								$conn->set_cache('priSenders',$priSenders);
							}
							$rand = mt_rand(0, $lenPriSenders-1);
							$sender1 = $priSenders[$rand];
							$rand = mt_rand(0, $lenSecSenders-1);
							$sender2 = $secSenders[$rand];
							$msgError = 'Email '.$sender['email'].' cannot send!';
							$mail->send(ADMIN_EMAIL, 'SMTP Error!!!', $msgError,$emailGlobal);
						} else {
							$flag = false;
							echo 'Send mail to <b>'.$e->to.'</b><br/>';
						}
					}
				}
				sleep(3);
				array_push($arr,$e->id);
			} catch (Exception $e) {
			}
		}
		$conn->hadSend($arr);
	} else
		echo 'No Email To Send';
	$conn->close();
	
	
?>