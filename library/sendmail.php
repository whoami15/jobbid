<?php
class sendmail {
	function send($to, $subject, $content, $sender) {
		//echo 'sendmail!!';
		require_once ROOT . DS . 'library' . DS .'class.phpmailer.php';
		$mail             = new PHPMailer();
		$mail->CharSet = "UTF-8";
		$mail->SetLanguage('vi', ROOT . DS . 'library' .'/phpmailer/language/');
		$mail->IsSMTP();
		$mail->SMTPAuth   = true;                  // enable SMTP authentication
		$mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
		//$mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
		//$mail->Port       = 465;                   // set the SMTP port for the GMAIL server
		$mail->Host       = $sender['smtp'];
		$mail->Port       = $sender['port'];
		$mail->Username   = $sender['email'];  // GMAIL username
		$mail->Password   = $sender['password'];            // GMAIL password
		$from = $sender['email'];
		$mail->AddReplyTo($from, "Jobbid.vn Support");
		$mail->From       = $from;
		$mail->FromName   = "Jobbid.vn Support";
		$mail->Sender = $from;
		$mail->Subject    = $subject;
		//$mail->AltBody    = "Xin chao"; // optional, comment out and test
		//$mail->WordWrap   = 50; // set word wrap
		$mail->MsgHTML($content);
		$mail->AddAddress($to);
		$mail->IsHTML(true); // send as HTML
		if(!$mail->Send()) {
			return false;
		} 
		return true;
	}
	function send2($to, $subject, $content, $sender) {
		//echo 'sendmail!!';
		echo ";sender:".$sender['email'];
		return true;
	}
	
}
	

?>