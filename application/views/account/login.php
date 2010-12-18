<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/validator.js"></script>
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
<div id="content2" style="width:100%;">
	<div class="ui-widget-header ui-helper-clearfix ui-corner-all" style='text-align: left; padding-left: 10px; margin-left: -5px; width: 100%;' id="content_title">Đăng nhập</div>
	<form id="formAccount" style="padding-top: 10px; padding-bottom: 10px;" method="POST" action="<?php echo BASE_PATH ?>/account/doLogin/account" onsubmit="return validaFormAccount()">
		<fieldset style="width:500px">
			<legend><span style="font-weight:bold;">Nhập username và password để login</span></legend>
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
						<td width="150px" align="right">Username :</td>
						<td align="left">
							<input type="text" name="username" id="username" style="width:200px"  tabindex="1"  value="<?php echo $username ?>"/><span style="color:red;font-weight:bold;cursor:pointer;" title="Bắt buộc nhập dữ liệu">*</span>
						</td>	
					</tr>
					<tr>
						<td align="right">Mật khẩu :</td>
						<td align="left">
							<input type="password" name="password" id="password" style="width:200px" tabindex="2" /><span style="color:red;font-weight:bold;cursor:pointer;" title="Bắt buộc nhập dữ liệu">*</span>
						</td>
					</tr>
					<tr>
						<td colspan="4" align="center" height="50px">
							<input value="Đăng Nhập" type="submit" tabindex="3">
						</td>
					</tr>
				</tbody>
			</table>
		</fieldset>
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
		validate(['require'],'username',["Vui lòng nhập Username!"]);
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
		$("#content_title").css("width",width_content-19);
		$("#menu "+menuid).addClass("current");
		$("input:submit, input:button", "body").button();
	});
</script>
