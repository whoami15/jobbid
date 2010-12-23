<?php
class sendmail {
	function send($to, $subject, $content) {
		echo 'sendmail!!';
		/* require_once ROOT . DS . 'library' . DS .'class.phpmailer.php';
		$mail             = new PHPMailer();
		//$mail->SetLanguage('en', $dirname.'/phpmailer/language/');
		$mail->IsSMTP();
		$mail->SMTPAuth   = true;                  // enable SMTP authentication
		$mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
		$mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
		$mail->Port       = 465;                   // set the SMTP port for the GMAIL server
		$mail->Username   = mUser;  // GMAIL username
		$mail->Password   = mPass;            // GMAIL password
		$from = mUser;
		$mail->AddReplyTo($from, "Admin JobBid");
		$mail->From       = $from;
		$mail->FromName   = "Admin JobBid";
		$mail->Sender = $from;
		$mail->Subject    = $subject;
		//$mail->AltBody    = "Xin chao"; // optional, comment out and test
		$mail->WordWrap   = 50; // set word wrap
		$mail->MsgHTML($content.'<br/>'.mFooter);
		$mail->AddAddress($to);
		$mail->IsHTML(true); // send as HTML
		if(!$mail->Send()) {
			return false;
		} 
		return true; */
	}
}
	

?>