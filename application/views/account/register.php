<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/validator.js"></script>
<div id="content" style="width:100%;">
	<form id="formAccount" style="padding-top: 0px; padding-bottom: 10px;">
	<div class="ui-widget-header ui-helper-clearfix ui-corner-top" style="border:none;padding-left: 5px" id="content_title">Đăng ký</div>
	<table class="center" width="500px">
		<thead>
			<tr>
				<td colspan="4" id="msg">
				</td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td width="150px" align="right">Email <span style="color:red;font-weight:bold;cursor:pointer;" title="Bắt buộc nhập dữ liệu">*</span> :</td>
				<td align="left">
					<input type="text" name="account_username" id="account_username" style="width:200px"  tabindex="1"/>
				</td>	
			</tr>
			<tr>
				<td align="right">Mật khẩu <span style="color:red;font-weight:bold;cursor:pointer;" title="Bắt buộc nhập dữ liệu">*</span> :</td>
				<td align="left">
					<input type="password" name="account_password" id="account_password" style="width:200px" tabindex="2"/>
				</td>
			</tr>
			<tr>
				<td align="right">Nhập lại mật khẩu <span style="color:red;font-weight:bold;cursor:pointer;" title="Bắt buộc nhập dữ liệu">*</span> :</td>
				<td align="left">
					<input type="password" id="password_again" style="width:200px" tabindex="3"/>
				</td>
			</tr>
			<tr>
				<td align="right">Số điện thoại <span style="color:red;font-weight:bold;cursor:pointer;" title="Bắt buộc nhập dữ liệu">*</span> :</td>
				<td align="left">
					<input type="text" name="account_sodienthoai" id="account_sodienthoai" style="width:200px"  tabindex="9"/>
				</td>
			</tr>
			<tr>
				<td></td>
				<td align="left">
					<div id="image_security" style="width:100px;height:40px;padding-left:30px;float:left">
					<img alt="imgcaptcha" id="imgcaptcha" src="<?php echo BASE_PATH ?>/util/captcha&width=100&height=40&characters=5"/>
					</div>
					<div style="float:left">
					<img title="Load mã bảo vệ khác" onclick="reloadImageCaptcha()" style="cursor:pointer" alt="reload_capcha" src="<?php echo BASE_PATH ?>/public/images/icons/refresh_icon.png"/>
					</div>
				</td>
			</tr>
			<tr>
				<td align="right">Mã xác nhận <span style="color:red;font-weight:bold;cursor:pointer;" title="Bắt buộc nhập dữ liệu">*</span> :</td>
				<td align="left">
					<input id="security_code" name="security_code" type="text" style="width:200px"  tabindex="10"/>
				</td>
			</tr>
			<tr>
				<td colspan="4" align="center" style="height:50px">
					<input onclick="doRegist()" value="Đăng Ký" type="button" tabindex="11">
					<input onclick="doReset()" value="Reset" type="button"tabindex="12">
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

	function reloadImageCaptcha() {
		byId("imgcaptcha").src = byId("imgcaptcha").src + '#';
		byId("security_code").value = "";
	}	
	function doRegist() {
		checkValidate=true;
		validate(['require','email'],'account_username',["Vui lòng nhập email!","Địa chỉ email không hợp lệ!"]);
		validate(['require',5],'account_password',["Vui lòng nhập Password!","Password phải lớn hơn 5 ký tự"]);
		validate(['require','pwdagain'],'password_again',["Vui lòng nhập lại Password!","Password và password nhập lại chưa trùng khớp!"]);
		validate(['require'],'account_sodienthoai',["Vui lòng nhập số điện thoại!"]);
		validate(['require'],'security_code',["Vui lòng nhập mã bảo vệ!"]);
		if(checkValidate == false)
			return;
		byId("msg").innerHTML="";
		dataString = $("#formAccount").serialize();
		block("#content");
		$.ajax({
			type: "POST",
			cache: false,
			url : url("/account/doRegist&"),
			data: dataString,
			success: function(data){
				unblock("#content");				
				if(data == AJAX_DONE) {
					//Dang ky thanh cong	
					location.href = url("/account/registsuccess&username="+byId("account_username").value);
				} else if (data == AJAX_ERROR_EXIST) {
					message('Email này đã được đăng ký!',0);	
					byId("account_username").focus();
					$("#account_username").css('border-color','red');
					reloadImageCaptcha();
				} else if (data == AJAX_ERROR_SECURITY_CODE) {
					message('Sai mã xác nhận!',0);										
					byId("security_code").focus();
					$("#security_code").css('border-color','red');
					reloadImageCaptcha();
				} else {
					message('Lưu Tài Khoản không thành công!',0);
					reloadImageCaptcha();				
				}
			},
			error: function(data){ unblock("#content");alert (data);}	
		});
	}
	function doReset() {
		$("#formAccount")[0].reset(); //Reset form cua jquery, giu lai gia tri mac dinh cua cac field	
		$("#formAccount :input").css('border-color','');
		byId("msg").innerHTML="";
	}
	$(document).ready(function() {
		document.title = "Trang Đăng Ký Thành Viên - "+document.title;
		$("#tfoot_paging").html($("#thead_paging").html());
		menuid = '#register';
		//$("#content_title").text($("#menu "+menuid).text());
		$("#menu "+menuid).addClass("current");
		$("input:submit, input:button", "body").button();
		boundTip("account_username","Vui lòng nhập chính xác email của bạn, chúng tôi sẽ gửi cho bạn 1 mail xác nhận đăng ký tới email này.");
		boundTip("account_sodienthoai","Chủ dự án hoặc nhà thầu sẽ liên hệ với bạn bằng số điện thoại này khi trúng thầu.");
	});
</script>
