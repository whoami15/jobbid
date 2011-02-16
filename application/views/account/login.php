<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/validator.js"></script>
<?php
	$msg = "";
	if(isset($_GET["reason"])) {
		$msg = $_GET["reason"];
		if($msg == "username")
			$msg = "Email này chưa được đăng ký hoặc đã bị khóa!";
		else if ($msg == "password")
			$msg = "Sai mật khẩu đăng nhập!";
		else if ($msg == "admin")
			$msg = "Vui lòng đăng nhập bằng tài khoản quản trị!";
	}
		
	$username = "";
	if(isset($_GET["username"]))
		$username = $_GET["username"];
?>
<div id="content" style="width:100%;">
	<form id="formAccount" style="padding-top: 0px; padding-bottom: 10px;" method="POST" action="<?php echo BASE_PATH ?>/account/doLogin/account" onsubmit="return validaFormAccount()">
	<div class="ui-widget-header ui-helper-clearfix ui-corner-top" style="border:none;padding-left: 5px" id="content_title">Đăng nhập</div>
	<table class="center" width="99%">
		<thead>
			<tr>
				<td colspan="4" id="msg">
				<?php
				if(!empty($msg))
					echo "<div class='negative'><span class='bodytext' style='padding-left:30px;'>$msg</span></div>";
				?>
				</td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td width="250px" align="right">Email :</td>
				<td align="left">
					<input type="text" name="username" id="username" style="width:200px"  tabindex="1"  value="<?php echo $username ?>"/>
				</td>	
			</tr>
			<tr>
				<td align="right">Mật khẩu :</td>
				<td align="left">
					<input type="password" name="password" id="password" style="width:200px" tabindex="2" />
				</td>
			</tr>
			<tr>
				<td colspan="4" align="center" style="height:30px">
					<input value="Đăng Nhập" type="submit" tabindex="3">
				</td>
			</tr>
			<tr>
				<td align="right"></td>
				<td align="left">
					<a class="link" href="javascript:location.href=url('/webmaster/resetpass')">Quên mật khẩu đăng nhập?</a><br/>
					<a class="link" href="<?php echo BASE_PATH ?>/account/register">Đăng ký tài khoản miễn phí!</a>
				</td>
			</tr>
		</tbody>
	</table>
	</form>
</div>
<script>
	function message(msg,type) {
		if(type==1) { //Thong diep thong bao
			str = "<div class='positive'><span class='bodytext' style='padding-left:30px;'>"+msg+"</span></div>";
			byId("msg").innerHTML = str;
		} else if(type == 0) { //Thong diep bao loi
			str = "<div class='negative'><span class='bodytext' style='padding-left:30px;'>"+msg+"</span></div>";
			byId("msg").innerHTML = str;
		}
	}	
	function validaFormAccount(){
		checkValidate=true;
		validate(['require'],'username',["Vui lòng nhập Email!"]);
		validate(['require',5],'password',["Vui lòng nhập Password!","Password phải lớn hơn 5 ký tự"]);
		if(checkValidate == false)
			return false;
		byId("msg").innerHTML="";
		return true;
	}
	$(document).ready(function() {
		$("#tfoot_paging").html($("#thead_paging").html());
		menuid = '#login';
		//$("#content_title").text($("#menu "+menuid).text());
		$("#menu "+menuid).addClass("current");
		$("input:submit, input:button", "body").button();
		byId("username").focus();
	});
</script>
