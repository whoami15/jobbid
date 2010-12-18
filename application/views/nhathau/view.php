<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/validator.js"></script>
<div id="content" style="width:100%">
	<div class="ui-widget-header ui-helper-clearfix ui-corner-all" style='text-align: left; padding-left: 10px; margin-left: -5px; width: 99%' id="content_title"></div>
	<fieldset style="margin-top:10px">
		<legend>Thông tin hồ sơ nhà thầu</legend>
		<?php
		if(empty($nhathau)==false) {
		?>
		<table class="center" width="100%">
			<tbody>
				<tr height="30px">
					<td align="left" >
					<b><span id="display_tenhienthi"></span> :</b> <?php echo $nhathau["nhathau"]["displayname"] ?>
					</td>
				</tr>
				<tr height="30px">
					<td align="left" >
					<b><span id="display_gpkd_cmnd"></span> :</b> <?php echo $nhathau["nhathau"]["gpkd_cmnd"] ?>
					</td>
				</tr>
				<tr height="30px">
					<td align="left" >
					<b>Lĩnh vực :</b>
					</td>
				</tr>
				<tr align="left" >
					<td align="left" style="padding-left:50px">
					<?php 
					if(isset($lstLinhvucquantam)) {
						echo "<ul style='padding-left:15px'>";
						foreach($lstLinhvucquantam as $linhvuc) {
							echo "<li>".$linhvuc['linhvuc']['tenlinhvuc']."</li>";
						}
						echo "</ul>";
					}
					?>
					</td>
				</tr>
				<tr height="30px">
					<td align="left" >
					<b><span id="display_file"></span> :</b> <a class="link" target="_blank" href="<?php echo BASE_PATH.'/file/download/'.$nhathau["file"]["id"] ?>"><?php echo $nhathau["file"]["filename"] ?></a>
					</td>
				</tr>
				<tr height="30px">
					<td align="left" >
					<b>Mô tả thêm :</b>
					</td>
				</tr>
				<tr height="30px">
					<td align="left" style="padding-left:50px">
					<?php echo $nhathau["nhathau"]["motachitiet"] ?>
					</td>
				</tr>
				<tr height="30px">
					<td align="center">
					<input type="button" value="Sửa hồ sơ" onclick="location.href=url('/nhathau/edit')"/>
					</td>
				</tr>
			</tbody>
		</table>
		<?php
		} else {
		?>
		<div style="text-align:center">
		Hiện tại bạn chưa có hồ sơ nhà thầu!<br/>
		Để tham gia đấu giá các dự án trên website, bạn cần phải tạo hồ sơ nhà thầu.<br/>
		Click <a class="link" href="<?php echo BASE_PATH ?>/nhathau/add"/>vào đây</a> để tạo hồ sơ nhà thầu.
		</div>
		<?php
		}
		?>
	</fieldset>
	<fieldset style="margin-top:10px">
		<legend>Thông tin cá nhân</legend>
		<form id="formAccount" style="padding-top: 10px; padding-bottom: 10px;">
		<table class="center" width="500px">
			<thead>
				<tr>
					<td colspan="4" id="msg">
					</td>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td width="150px" align="right">Username :</td>
					<td align="left">
						<a href="#" class="link"><?php echo $dataAccount["username"]?></a>
					</td>
				</tr>
				<tr>
					<td></td>
					<td>
					<a href="javascript:showTabChangePass()" class="link" >Cập nhật mật khẩu</a>
					</td>
				</tr>
				<tr id="tr_oldpass">
					<td width="150px" align="right">Mật khẩu cũ <span style="color:red;font-weight:bold;cursor:pointer;" title="Bắt buộc nhập dữ liệu">*</span> :</td>
					<td align="left">
						<input type="password" name="account_oldpassword" id="account_oldpassword" style="width:200px" tabindex="2"/>
					</td>
				</tr>
				<tr id="tr_newpass">
					<td align="right">Mật khẩu mới<span style="color:red;font-weight:bold;cursor:pointer;" title="Bắt buộc nhập dữ liệu">*</span> :</td>
					<td align="left">
						<input type="password" name="account_password" id="account_password" style="width:200px" tabindex="2"/>
					</td>
				</tr>
				<tr id="tr_passagain">
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
						<input type="text" value="<?php echo $dataAccount["email"]?>" name="account_email" id="account_email" style="width:300px"  tabindex="7"/>
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
						<input id="btUpdate" onclick="doUpdate()" value="Cập Nhật" type="button" tabindex="11">
						<input onclick="doReset()" value="Reset" type="button"tabindex="12">
					</td>
				</tr>
			</tbody>
		</table>
		</form>
	</fieldset>
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
	function doReset() {
		$("#formAccount")[0].reset(); //Reset form cua jquery, giu lai gia tri mac dinh cua cac field	
		$("#formAccount :input").css('border-color','');
		byId("msg").innerHTML="";
		$('#btUpdate').removeAttr('disabled');
	}
	var display_tenhienthi = '';
	var display_gpkd_cmnd = '';
	var display_file = '';
	function changeType(value) {
		if(value==null)
			return;
		if(value == 1) {
			display_tenhienthi = "Tên hiển thị";
			display_gpkd_cmnd = "Số CMND";
			display_file = "File mô tả kinh nghiệm";
		} else {
			display_tenhienthi = "Tên công ty";
			display_gpkd_cmnd = "Giấy phép kinh doanh";
			display_file = "File hồ sơ năng lực";
		}
		byId("display_tenhienthi").innerHTML = display_tenhienthi;
		byId("display_gpkd_cmnd").innerHTML = display_gpkd_cmnd;
		byId("display_file").innerHTML = display_file;
	}
	var isShowChangePass = false;
	function showTabChangePass() {
		if(isShowChangePass==false) {
			$("#tr_oldpass").show();
			$("#tr_newpass").show();
			$("#tr_passagain").show();
			isShowChangePass = true;
		} else {
			$("#tr_oldpass").hide();
			$("#tr_newpass").hide();
			$("#tr_passagain").hide();
			byId("account_oldpassword").value = "";
			byId("account_password").value = "";
			byId("password_again").value = "";
			isShowChangePass = false;
		}
		
	}
	function doUpdate() {
		location.href = "#top";
		checkValidate=true;
		if(byId("account_oldpassword").value!="") {
			validate(['require',5],'account_password',["Vui lòng nhập Password!","Password phải lớn hơn 5 ký tự"]);
			validate(['require','pwdagain'],'password_again',["Vui lòng nhập lại Password!","Password và password nhập lại chưa trùng khớp!"]);
		}
		validate(['require','email'],'account_email',["Vui lòng nhập email!","Địa chỉ email không hợp lệ!"]);
		validate(['require'],'account_sodienthoai',["Vui lòng nhập số điện thoại!"]);
		if(checkValidate == false)
			return;
		byId("msg").innerHTML="";
		dataString = $("#formAccount").serialize();
		//alert(dataString);return;
		$('#btUpdate').attr('disabled','disabled');
		byId("msg").innerHTML="<div class='loading'><span class='bodytext' style='padding-left:30px;'>Đang xử lý...</span></div>";
		$.ajax({
			type: "POST",
			cache: false,
			url : url("/account/doUpdate&"),
			data: dataString,
			success: function(data){
				$('#btUpdate').removeAttr('disabled');		
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/account/login");
					return;
				}
				if(data == AJAX_DONE) {
					//Dang ky thanh cong	
					message('Cập nhật thông tin tài khoản thành công!',1);
				} else if (data == "ERROR_WRONGPASSWORD") {
					message('Mật khẩu cũ không đúng!',0);	
					byId("account_oldpassword").focus();
					$("#account_oldpassword").css('border-color','red');
				} else if (data == "ERROR_EXIST_EMAIL") {
					message('Email này đã được đăng ký!',0);	
					byId("account_email").focus();
					$("#account_email").css('border-color','red');
				} else {
					message('Cập nhật thông tin tài khoản không thành công!',0);
				}
			},
			error: function(data){ $('#btUpdate').removeAttr('disabled');alert (data);}	
		});
	}
	$(document).ready(function() {
		<?php
		if(isset($nhathau))
			echo "changeType(".$nhathau["nhathau"]["type"].");";
		?>
		$("#content_title").text("Quản lý hồ sơ cá nhân");
		$("#content_title").css("width",width_content-19);
		$("#quan_ly_ho_so_ca_nhan").css('color','#F68618');
		$("input:submit, input:button", "body").button();
		$('#account_ngaysinh').datepicker({
			dateFormat: "dd/mm/yy",
			changeMonth: true,
			changeYear: true
		});
		$("#tr_oldpass").hide();
		$("#tr_newpass").hide();
		$("#tr_passagain").hide();
	});
</script>
