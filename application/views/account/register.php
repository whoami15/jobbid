<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/validator.js"></script>
<?php
	$msg = "";
	if(isset($_GET["msg"])) {
		$msg = $_GET["msg"];
		if($msg == 'taoduan')
			$msg = "Vui lòng đăng ký tài khoản để hoàn tất tạo dự án!";
	}
?>
<div id="content" style="width:100%;">
	<form id="formAccount" style="padding-top: 0px; padding-bottom: 10px;">
	<div class="ui-widget-header ui-helper-clearfix ui-corner-top" style="border:none;padding-left: 5px" id="content_title">Bước 1: Đăng ký email</div>
	<table class="center" width="100%">
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
				<td style="width:200px" align="right" valign="top">Nhập địa chỉ email của bạn :</td>
				<td align="left">
					<input type="text" name="account_username" id="account_username" style="width:200px"  tabindex="1"/><br/><span class="sample">(Ví dụ: nclong87@gmail.com)</span>
				</td>	
			</tr>
			<tr>
				<td colspan="4" align="center" style="height:50px">
					<input onclick="doRegist()" value="Đăng Ký" type="button" tabindex="11">
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
	
	function doRegist() {
		checkValidate=true;
		validate(['require','email'],'account_username',["Vui lòng nhập email!","Địa chỉ email không hợp lệ!"]);
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
					location.href = url("/webmaster/active");
				} else if (data == AJAX_ERROR_EXIST) {
					message('Email này đã được đăng ký!',0);	
					byId("account_username").focus();
					$("#account_username").css('border-color','red');
				} else {
					message('Lỗi hệ thống, vui lòng thử lại sau!',0);
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
		//document.title = "Bước 1: Đăng ký email";
		$("#tfoot_paging").html($("#thead_paging").html());
		menuid = '#register';
		//$("#content_title").text($("#menu "+menuid).text());
		$("#menu "+menuid).addClass("current");
		$("input:submit, input:button", "body").button();
		//alert($("#account_username").left());
		boundTip("account_username","Vui lòng nhập chính xác email của bạn, chúng tôi sẽ gửi cho bạn 1 mail xác nhận đăng ký tới email này.(địa chỉ email này sẽ được bảo mật)");
	});
</script>
