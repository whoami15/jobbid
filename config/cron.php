<?php
	include (ROOT.DS.'library'.DS.'dataprovider.php');
	include (ROOT.DS.'library'.DS.'sendmail.php');
	$conn=new DataProvider();
	$mail=new sendmail();
	$conn->updateSoduan();
	$conn->lstNewProject();
	$data = $conn->getListSendmail();
	$arr = array();
	foreach($data as $e) {
		try {
			echo 'Send mail to <b>'.$e->to.'</b><br/>';
			$mail->send($e->to, $e->subject, $e->content);
			sleep(3);
			array_push($arr,$e->id);
		} catch (Exception $e) {
		}
	}
	$conn->hadSend($arr);
	$conn->close();
	echo 'DONE';
	
?>