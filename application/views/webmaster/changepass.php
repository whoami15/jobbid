<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/validator.js"></script>
<style>
	.tdLabel {
		text-align:right;
		width:160px;
	}
	.tdInput {
		width: 250px;
	}
</style>
<div id="content" style="width:100%;">
	<form id="formChangepass">
	<div class="ui-widget-header ui-helper-clearfix ui-corner-top" style="border:none;padding-left: 5px" id="content_title">Thay đổi Mật Khẩu</div>
	<center>
	<div style="padding:10px" id="msg"></div>
	<div class="divTable" style="width:65%;padding-top:10px;">
		<div class="tr" style="border:none">
			<div class="td tdLabel" style="text-align:right;">Mật khẩu mới :</div>
			<div class="td tdInput">
			<input type="password" name="account_password" id="account_password" style="width:200px" tabindex="1"/>
			</div>
		</div>
		<div class="tr" style="border:none">
			<div class="td tdLabel" style="text-align:right;">Nhập lại mật khẩu mới :</div>
			<div class="td tdInput">
			<input type="password" id="password_again" style="width:200px" tabindex="2"/>
			</div>
		</div>
		<div class="tr" style="border:none">
			<div class="td">
			<input id="btsubmit" type="button" value="Cập Nhật" onclick="doChangePass()">
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
	function redirectLoginpage() {
		location.href = url('/account/login');
	}
	function doChangePass() {
		location.href = "#top";
		checkValidate=true;
		validate(['require',5],'account_password',["Vui lòng nhập Password!","Password phải lớn hơn 5 ký tự"]);
		validate(['require','pwdagain'],'password_again',["Vui lòng nhập lại Password!","Password và password nhập lại chưa trùng khớp!"]);
		if(checkValidate==false) {
			return false;
		}
		$('#btsubmit').attr('disabled','disabled');
		byId("msg").innerHTML="<div class='loading'><span class='bodytext' style='padding-left:30px;'>Đang xử lý...</span></div>";
		var dataString = $("#formChangepass").serialize();
		$.ajax({
			type: "POST",
			cache: false,
			url : url("/account/doChangePass&"),
			data: dataString,
			success: function(data){
				$('#btsubmit').removeAttr('disabled');	
				if(data == AJAX_DONE) {
					//Dang ky thanh cong	
					message('Cập nhật mật khẩu mới thành công, đang chuyển đến trang đăng nhập...',1);
					setTimeout("redirectLoginpage()",redirect_time);
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
