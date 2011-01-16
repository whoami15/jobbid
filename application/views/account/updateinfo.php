<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/validator.js"></script>
<div id="content" style="width:100%;">
	<form id="formAccount" style="padding-top: 0px; padding-bottom: 10px;">
	<div class="ui-widget-header ui-helper-clearfix ui-corner-top" style="border:none;padding-left: 5px" id="content_title">Bước 3: Cập Nhật Thông Tin Tài Khoản</div>
	<table class="center" width="100%">
		<thead>
			<tr>
				<td colspan="4" id="msg">
				</td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td style="width:200px" align="right">Nhập mật khẩu :</td>
				<td align="left">
					<input type="password" name="account_password" id="account_password" style="width:200px" tabindex="2"/>
				</td>	
			</tr>
			<tr>
				<td align="right">Nhập lại mật khẩu :</td>
				<td align="left">
					<input type="password" id="password_again" style="width:200px" tabindex="3"/>
				</td>
			</tr>
			<tr>
				<td align="right">Số điện thoại :</td>
				<td align="left">
					<input type="text" name="account_sodienthoai" id="account_sodienthoai" style="width:200px"  tabindex="4"/>
				</td>
			</tr>
			<tr>
				<td colspan="4" align="center" style="height:50px">
					<input onclick="doUpdateInfo()" value="Cập Nhật" type="button" tabindex="11">
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
	function redirectPage() {
		location.href = url("/webmaster/registcomplete");
	}
	function doUpdateInfo() {
		checkValidate=true;
		validate(['require',5],'account_password',["Vui lòng nhập Password!","Password phải lớn hơn 5 ký tự"]);
		validate(['require','pwdagain'],'password_again',["Vui lòng nhập lại Password!","Password và password nhập lại chưa trùng khớp!"]);
		validate(['require'],'account_sodienthoai',["Vui lòng nhập số điện thoại!"]);
		if(checkValidate == false)
			return;
		byId("msg").innerHTML="";
		dataString = $("#formAccount").serialize();
		block("#content");
		$.ajax({
			type: "POST",
			cache: false,
			url : url("/account/doUpdateInfo&"),
			data: dataString,
			success: function(data){
				unblock("#content");				
				if(data == AJAX_DONE) {
					//Dang ky thanh cong	
					message('Cập nhật thành công, đang chuyển sang bước 4...',1);
					setTimeout("redirectPage()",redirect_time);
				} else {
					message('Lỗi hệ thống, vui lòng thử lại sau!',0);
				}
			},
			error: function(data){ unblock("#content");alert (data);}	
		});
	}
	$(document).ready(function() {
		document.title = "Bước 3: Cập Nhật Thông Tin Tài Khoản";
		$("#tfoot_paging").html($("#thead_paging").html());
		menuid = '#register';
		//$("#content_title").text($("#menu "+menuid).text());
		$("#menu "+menuid).addClass("current");
		$("input:submit, input:button", "body").button();
		message("Xác nhận đăng ký thành công",1);
		//alert($("#account_username").left());
	});
</script>
