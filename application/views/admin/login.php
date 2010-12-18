<?xml version="1.0" encoding="ISO-8859-1"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
	$msg = "";
	if(isset($_GET["reason"])) {
		$msg = $_GET["reason"];
		if($msg == "username")
			$msg = "Username này không tồn tại!";
		else if ($msg == "password")
			$msg = "Sai mật khẩu đăng nhập!";
		else if ($msg == "admin")
			$msg = "Vui lòng đăng nhập bằng tài khoản quản trị!";
	}
		
	$username = "";
	if(isset($_GET["username"]))
		$username = $_GET["username"];
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>ProAdmin - Login</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo BASE_PATH ?>/public/css/backend/login.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="logo">
	<img src="<?php echo BASE_PATH ?>/public/images/logo.png" alt="logopng" width="116" height="34" /> <!--//  Logo on upper corner -->
</div>
<div class="box">
	<div class="welcome" id="welcometitle">Welcome to ProAdmin, Please Login: <!--//  Welcome message -->
</div>
  <div id="fields"> 
	<form method="POST" action="<?php echo BASE_PATH ?>/account/doLogin">
    <table width="333">
		<tbody>
			<tr>
				<td colspan="2">
					<?php
					if(!empty($msg))
					echo "<div class='negative'><span class='bodytext' style='padding-left:30px;'><strong>$msg</strong></span></div>";
					?>
				</td>
			</tr>
			<tr>
				<td width="79" height="35"><span class="login">USERNAME</span></td>
				<td width="244" height="35"><label>
				  <input name="username" type="text" class="fields" id="username" size="30" value="<?php echo $username ?>"/>
				</label></td>
			</tr>
			<tr>
				<td height="35"><span class="login">PASSWORD</span></td>
				<td height="35"><input name="password" type="password" class="fields" id="password" size="30" /></td>
			</tr>
			<tr>
				<td height="65">&nbsp;</td>
				<td height="65" valign="middle"><label>
				  <input name="button" type="submit" class="button" id="button" value="LOGIN" />
				</label></td>
			</tr>
		</tbody>
    </table>
	</form>
  </div>
  <div class="login" id="lostpassword"><a href="#">Lost Password?</a></div> <!--//  lost password part -->
  <div class="copyright" id="copyright">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Mauris risus mauris.<br />
  <!--//  copyright / footer -->
  Copyright &copy; Company People 2008.
  <a href="index-2.html">Back to index.</a></div>
</div>
</body>
</html>
