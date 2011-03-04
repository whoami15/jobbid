<?php
	include (dirname(__FILE__).'/config/cronconfig.php');
	include (ROOT.DS.'library'.DS.'dataprovider.php');
	include (ROOT.DS.'library'.DS.'sendmail.php');
	$conn=new DataProvider();
	$senders = $conn->get_cache('senders');
	$mail=new sendmail();
	$conn->lstNewProject();
	$data = $conn->getListSendmail();
	if(!empty($data)){
		$arr = array();
		foreach($data as $e) {
			try {
				$sender = $senders['secSender'];
				if($e->isprior == 1)
					$sender = $senders['priSender'];
				$mail->send2($e->to, $e->subject, $e->content,$sender);echo "<br>";
				sleep(3);
				array_push($arr,$e->id);
			} catch (Exception $e) {
			}
		}
	}
	$conn->close();
	echo 'DONE';
	
?>