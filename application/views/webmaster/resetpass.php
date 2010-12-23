<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/validator.js"></script>
<style>
	.tdLabel {
		text-align:right;
		width:133px;
	}
</style>
<div id="content" style="width:100%;">
	<form id="formResetpass">
	<div class="ui-widget-header ui-helper-clearfix ui-corner-top" style="border:none;padding-left: 5px" id="content_title">Khôi phục Mật Khẩu</div>
	<center>
	<div class="divTable" style="width:100%;padding-top:10px;">
		<div class="tr" style="border:none">
			<div class="td" id="msg"></div>
		</div>
		<div class="tr" style="border:none">
			<div class="td tdLabel" style="text-align:right;">Tài khoản (email) :</div>
			<div class="td tdInput">
			<input type="text" name="username" id="username" style="width:50%" value="" tabindex=1/>&nbsp;&nbsp;<input id="btsubmit" type="button" value="Nhận Mật Khẩu Mới" onclick="doResetPass()">
			</div>
		</div>
	</div>
	</center>
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
	function doResetPass() {
		location.href = "#top";
		checkValidate=true;
		validate(['require','email'],'username',["Vui lòng nhập email của bạn!","Email không hợp lệ!"]);
		if(checkValidate==false) {
			return false;
		}
		$('#btsubmit').attr('disabled','disabled');
		byId("msg").innerHTML="<div class='loading'><span class='bodytext' style='padding-left:30px;'>Đang xử lý...</span></div>";
		var dataString = $("#formResetpass").serialize();
		$.ajax({
			type: "GET",
			cache: false,
			url : url("/account/resetpassword&"+dataString),
			success: function(data){
				$('#btsubmit').removeAttr('disabled');	
				if(data == 'ERROR_MANYTIMES') {
					message('Lỗi! Bạn đã yêu cầu khôi phục mật khẩu quá nhiều!',0);
					return;
				}
				if(data == 'ERROR_NOTEXIST') {
					message('Lỗi! Email này chưa được đăng ký hoặc đã bị khóa!',0);
					return;
				}
				if(data == 'ERROR_LOCKED') {
					message('Lỗi! Chức năng khôi phục mật khẩu cho email này đã bị khóa, vui lòng liên hệ admin để mở lại!',0);
					return;
				}
				if(data == AJAX_DONE) {
					//Dang ky thanh cong	
					message('Khôi phục mật khẩu thành công! Vui lòng kiểm tra mail để xác nhận.',1);
				} else {
					message('Hệ thống đang quá tải, vui lòng thử lại!',0);
				}
			},
			error: function(data){ $('#btsubmit').removeAttr('disabled');alert (data);}	
		});
	}
	$(document).ready(function() {
		$("input:submit, input:button", "body").button();
	});
</script>
