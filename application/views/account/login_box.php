<center>
<div class="divTable" style="width:100%">
	<form id="formAccount">
	<div class="tr" style="border:none;padding-top:5px">
		<div class="td" id="loginbox_msg"></div>
	</div>
	<div class="tr" style="border:none">
		<div class="td tdLabel" style="text-align:right;width:100px">Email :</div>
		<div class="td tdInput" style="width:200px">
		<input type="text" name="username" id="username" style="width:200px"  tabindex="1"  value=""/>
		</div>
	</div>
	<div class="tr" style="border:none">
		<div class="td tdLabel" style="text-align:right;width:100px">Mật khẩu :</div>
		<div class="td tdInput" style="width:200px">
		<input type="password" name="password" id="password" style="width:200px" tabindex="2" />
		</div>
	</div>
	<div class="tr" style="border:none">
		<div class="td">
		<input value="Đăng Nhập" id="loginButton" type="button" onclick="doSubmitLoginbox()" tabindex="3">
		</div>
	</div>
	</form>
	<div class="tr" style="border:none;padding-top:5px">
		<a class="link" target="_blank" href="<?php echo BASE_PATH?>/webmaster/resetpass">Bạn quên mật khẩu đăng nhập?</a><br/>
	</div>
</div>
</center>
<script>
	function loginbox_msg(msg,type) {
		if(type==1) { //Thong diep thong bao
			str = "<div class='positive'><span class='bodytext' style='padding-left:30px;'>"+msg+"</span></div>";
			byId("loginbox_msg").innerHTML = str;
		} else if(type == 0) { //Thong diep bao loi
			str = "<div class='negative'><span class='bodytext' style='padding-left:30px;'>"+msg+"</span></div>";
			byId("loginbox_msg").innerHTML = str;
		}
	}
	function doSubmitLoginbox() {
		username = byId("username").value;
		password = byId("password").value;
		if(username=="") {
			loginbox_msg("Vui lòng nhập Email!",0);
			return;
		}
		if(password=="") {
			loginbox_msg("Vui lòng nhập Password!",0);
			return;
		}
		$('#loginButton').attr('disabled','disabled');
		byId("loginbox_msg").innerHTML="<div class='loading'><span class='bodytext' style='padding-left:30px;'>Kiểm tra đăng nhập...</span></div>";
		dataString = $("#formAccount").serialize();
		//alert(dataString);return;
		$.ajax({
			type : "POST",
			cache: false,
			url : url("/account/submit_login_box&"),
			data: dataString,
			success : function(data){	
				//alert(data);
				$('#loginButton').removeAttr('disabled');
				if(data == "ERROR_MANYTIMES") {
					loginbox_msg("Thao tác quá nhiều, vui lòng đợi 15 phút để tiếp tục!",0);
					return;
				}
				if(data == "ERROR_NOTEXIST") {
					loginbox_msg("Tài khoản này không tồn tại!",0);
					return;
				}
				if(data == "ERROR_WRONGPASSWORD") {
					loginbox_msg("Sai mật khẩu đăng nhập!",0);
					return;
				}
				if(data == "OK") {
					byId("loginbox_msg").innerHTML="<div class='loading'><span class='bodytext' style='padding-left:30px;'>Post dự án...</span></div>";
					timer1=setTimeout("doSubmit()",redirect_time);
				} else {
					loginbox_msg("Có lỗi xảy ra, vui lòng thử lại!",0);
				}
				
			},
			error: function(data){ 
				$('#loginButton').removeAttr('disabled');
				alert (data);
			}			
		});
	}
	$(document).ready(function() {
		$("input:submit, input:button", "body").button();
	});
</script>