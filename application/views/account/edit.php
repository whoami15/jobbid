<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/validator.js"></script>
<div id="content" style="width:100%;">
	<div class="ui-widget-header ui-helper-clearfix ui-corner-all" style='text-align: left; padding-left: 10px; margin-left: -5px; width: 100%;' id="content_title">Content</div>
	<form id="formAccount" style="padding-top: 10px; padding-bottom: 10px;">
		<fieldset>
			<legend><span style="font-weight:bold;">Username : <?php echo $dataAccount["username"]?></span></legend>
			<table class="center" width="500px">
				<thead>
					<tr>
						<td colspan="4" id="msg">
						</td>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td width="150px" align="right">Mật khẩu <span style="color:red;font-weight:bold;cursor:pointer;" title="Bắt buộc nhập dữ liệu">*</span> :</td>
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
						<td align="right">Họ tên :</td>
						<td align="left">
							<input type="text" name="account_hoten" id="account_hoten" style="width:300px"  tabindex="4" value="<?php echo $dataAccount["hoten"]?>"/>
						</td>
					</tr>
					<tr>
						<td align="right">Địa chỉ :</td>
						<td align="left">
							<input type="text" name="account_diachi" id="account_diachi" style="width:300px"  tabindex="6" value="<?php echo $dataAccount["diachi"]?>"/>
						</td>	
					</tr>
					<tr>
						<td align="right">Email <span style="color:red;font-weight:bold;cursor:pointer;" title="Bắt buộc nhập dữ liệu">*</span> :</td>
						<td align="left">
							<input type="text" value="<?php echo $dataAccount["hoten"]?>" name="account_email" id="account_email" style="width:300px"  tabindex="7"/>
						</td>	
					</tr>
					<tr>	
						<td align="right">Ngày sinh :</td>
						<td align="left">
							<input type="text" name="account_ngaysinh" id="account_ngaysinh" style="width:200px"  tabindex="8" value="<?php echo $html->format_date($dataAccount["ngaysinh"],'d/m/Y')?>"/>
						</td>
					</tr>
					<tr>
						<td align="right">Số điện thoại <span style="color:red;font-weight:bold;cursor:pointer;" title="Bắt buộc nhập dữ liệu">*</span> :</td>
						<td align="left">
							<input type="text" name="account_sodienthoai" id="account_sodienthoai" style="width:200px"  tabindex="9" value="<?php echo $dataAccount["sodienthoai"]?>"/>
						</td>
					</tr>
					<tr>
						<td colspan="4" align="center" height="50px">
							<input onclick="doRegist()" value="Cập Nhật" type="button" tabindex="11">
							<input onclick="doReset()" value="Reset" type="button"tabindex="12">
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
	function doRegist() {
		checkValidate=true;
		validate(['require'],'account_username',["Vui lòng nhập Username!"]);
		validate(['require',5],'account_password',["Vui lòng nhập Password!","Password phải lớn hơn 5 ký tự"]);
		validate(['require','pwdagain'],'password_again',["Vui lòng nhập lại Password!","Password và password nhập lại chưa trùng khớp!"]);
		validate(['require','email'],'account_email',["Vui lòng nhập email!","Địa chỉ email không hợp lệ!"]);
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
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/account/login");
					return;
				}
				if(data == AJAX_DONE) {
					//Dang ky thanh cong	
					location.href = url("/account/registsuccess&username="+byId("account_username").value);
				} else if (data == AJAX_ERROR_EXIST) {
					message('Username này đã tồn tại!',0);	
					byId("account_username").focus();
					$("#account_username").css('border-color','red');
					reloadImageCaptcha();
				} else if (data == "ERROR_EXIST_EMAIL") {
					message('Email này đã được đăng ký!',0);	
					byId("account_email").focus();
					$("#account_email").css('border-color','red');
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
		$("#content_title").css("width",width_content-19);
		$("#content_title").text("Cập nhật thông tin cá nhân");
		$('#account_ngaysinh').datepicker({
			dateFormat: "dd/mm/yy",
			changeMonth: true,
			changeYear: true
		});
		$("input:submit, input:button", "body").button();
	});
</script>
