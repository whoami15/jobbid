<?php
class sendmail {
	function send($to, $subject, $content) {
		//echo 'sendmail!!';
		require_once ROOT . DS . 'library' . DS .'class.phpmailer.php';
		$mail             = new PHPMailer();
		//$mail->CharSet = "UTF-8";
		//$mail->SetLanguage('en', $dirname.'/phpmailer/language/');
		$mail->IsSMTP();
		$mail->SMTPAuth   = true;                  // enable SMTP authentication
		$mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
		//$mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
		//$mail->Port       = 465;                   // set the SMTP port for the GMAIL server
		$mail->Host       = SMTP_HOST;
		$mail->Port       = SMTP_PORT;
		$mail->Username   = mUser;  // GMAIL username
		$mail->Password   = mPass;            // GMAIL password
		$from = mUser;
		$mail->AddReplyTo($from, "www.jobbid.vn");
		$mail->From       = $from;
		$mail->FromName   = "www.jobbid.vn";
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
}
	

?>