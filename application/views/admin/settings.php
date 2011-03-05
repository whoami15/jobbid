<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/tiny_mce/jquery.tinymce.js"></script>
<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/tiny_mce/jquery.tinymce.js"></script>
<style type="text/css"> 	
	.input {
		width:86%;
	}
	select {
		margin-right:-5px;
	}
	.select {
		width:86%;
	}
	fieldset {
		margin-bottom:5px;
	}
</style>
<div id="msg" style="width:99%"></div>
<div id="tabs">
	<ul>
		<li><a href="#tabs-1">Upload File Types</a></li>
		<li><a href="#tabs-2">Mail Template</a></li>
		<li><a href="#tabs-3">Sender Email</a></li>
	</ul>
	<div id="tabs-1">
		<form id="formSettings">
		<table class="center" width="100%">
			<tbody>
				<tr>
					<td width="110px" align="left">Image Types :</td>
					<td align="left">
						<input type="text" name="imagetypes" id="imagetypes" value="<?php echo $imageTypes ?>" style="width:99%"/>
					</td>	
				</tr>
				<tr>
					<td align="left">File Types :</td>
					<td align="left">
						<input type="text" name="filetypes" id="filetypes" value="<?php echo $fileTypes ?>" style="width:99%"/>
					</td>
				</tr>	
				<tr>
					<td colspan="4" align="center" height="50px">
						<input onclick="save()" value="Lưu" type="button">
					</td>
				</tr>
			</tbody>
		</table>
		</form>
	</div>
	<div id="tabs-2">
		<fieldset>
		<legend>Danh Sách Mail Template</legend>
		<div id="datagrid">
			<form id="formMailTemplate">
			<table width="99%">
				<thead>
					<tr class="ui-accordion-header ui-helper-reset ui-state-default ui-corner-all" style="font-weight:bold;height:30px;text-align:center;">
						<td>
							<select id="mail_type" name="mail_type" onchange="selectMailtype(this.value)">
								<option value="">Chọn loại mail</option>
								<option value="mail_verify">Xác Nhận</option>
								<option value="mail_resetpass">Khôi Phục Pass</option>
								<option value="mail_resendactivecode">Gửi Lại Mã Xác Nhận</option>
								<option value="mail_newproject">Dự án mới</option>
								<option value="mail_newbid">Gói thầu mới</option>
								<option value="mail_win">Nhà thầu trúng thầu</option>
								<option value="mail_lost">Nhà thầu trúng thầu hụt</option>
								<option value="mail_moithau">Mời thầu</option>
								<option value="mail_moinhatuyendung">Mời nhà tuyển dụng</option>
								<option value="mail_moiungvien">Mời ứng viên</option>
								<option value="mail_spam">Spam Mail</option>
							</select>
						</td>
					</tr>
				</thead>
				<tbody>
				<tr>
					<td align="left" width="100%">
					<textarea id="mail_content" name="mail_content" style="border:none;width:100%" cols="60" rows="15" ></textarea>
					</td>
				</tr>
				<tr>
					<td align="center" height="50px">
						<input onclick="saveMailTemplate()" value="Lưu" type="button">
					</td>
				</tr>
				</tbody>
			</table>
			</form>
		</div>
	</fieldset>
	</div>
	<div id="tabs-3">
		<form id="formSender">
		<div id="msg_email"></div>
		<fieldset>
		<legend><strong>Primary Sender</strong></legend>
		<table>
		<tr>
			<td><div style="width:80px">Email:</div><input type="text" name="primary_email" id="primary_email" value="<?php echo $priSender['email']?>" style="width:200px"/><br/></td>
			<td><div style="width:80px">Password:</div>
		<input type="password" name="primary_passsword" id="primary_passsword" value="<?php echo $priSender['password']?>" style="width:200px"/><br/></td>
			<td rowspan="2" valign="center">
			<input id="btSendTestPrimary" type="button" value="Send Test" onclick="sendTestPrimary()"/>
			</td>
		</tr>	
		<tr>
			<td><div style="width:80px">SMTP:</div>
		<input type="text" name="primary_smtp" id="primary_smtp" value="<?php echo $priSender['smtp']?>" style="width:200px"/><br/></td>
			<td><div style="width:80px">Port:</div>
		<input type="text" name="primary_port" id="primary_port" value="<?php echo $priSender['port']?>" style="width:200px"/><br/></td>
		</tr>
		</table>
		</fieldset>
		<fieldset>
		<legend><strong>Second Sender</strong></legend>
		<table>
		<tr>
			<td><div style="width:80px">Email:</div> 
		<input type="text" name="second_email" id="second_email" value="<?php echo $secSender['email']?>" style="width:200px"/><br/></td>
			<td><div style="width:80px">Password:</div>
		<input type="password" name="second_passsword" id="second_passsword" value="<?php echo $secSender['password']?>" style="width:200px"/><br/></td>
		<td rowspan="2" valign="center">
			<input id="btSendTestSecond" type="button" value="Send Test" onclick="sendTestSecond()"/>
			</td>
		</tr>	
		<tr>
			<td><div style="width:80px">SMTP:</div>
		<input type="text" name="second_smtp" id="second_smtp" value="<?php echo $secSender['smtp']?>" style="width:200px"/><br/></td>
			<td><div style="width:80px">Port:</div>
		<input type="text" name="second_port" id="second_port" value="<?php echo $secSender['port']?>" style="width:200px"/><br/></td>
		</tr>
		</table>
		</fieldset>
		<input onclick="saveSenderEmail()" value="Lưu" type="button">
		</form>
	</div>
</div>
<script type="text/javascript">
	var objediting; //Object luu lai row dang chinh sua
	function message(msg,type) {
		if(type==1) { //Thong diep thong bao
			str = "<div class='positive'><span class='bodytext' style='padding-left:30px;'><strong>"+msg+"</strong></span></div>";
			byId("msg").innerHTML = str;
		} else if(type == 0) { //Thong diep bao loi
			str = "<div class='negative'><span class='bodytext' style='padding-left:30px;'><strong>"+msg+"</strong></span></div>";
			byId("msg").innerHTML = str;
		}
	}
	function selectMailtype(id) {
		byId("msg").innerHTML="";
		block("#tabs-2");	
		$.ajax({
			type: "GET",
			cache: false,
			url : url("/admin/getMailTemplate&mail_type="+id),
			success: function(data){
				unblock("#tabs-2");	
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/admin/login");
					return;
				}
				if(data == 'ERROR_SYSTEM') {
					message('Thao tác không thành công!',0);
				} else {
					$("#mail_content").html(data);										
				}
			},
			error: function(data){ unblock("#tabs-2");alert (data);}	
		});
	}
	function saveMailTemplate() {
		dataString = $("#formMailTemplate").serialize();
		byId("msg").innerHTML="";
		block("#tabs-2");	
		$.ajax({
			type: "POST",
			cache: false,
			url : url("/admin/saveMailTemplate&"),
			data: dataString,
			success: function(data){
				unblock("#tabs-2");	
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/admin/login");
					return;
				}
				if(data == AJAX_DONE) {
					//Load luoi du lieu	
					message("Lưu mail template thành công!",1);
				} else {
					message('Lưu mail template không thành công!',0);										
				}
			},
			error: function(data){ unblock("#tabs-2");alert (data);}	
		});
	}
	function save() {
		dataString = $("#formSettings").serialize();
		byId("msg").innerHTML="";
		block("#tabs-1");	
		$.ajax({
			type: "POST",
			cache: false,
			url : url("/admin/saveSettings&"),
			data: dataString,
			success: function(data){
				unblock("#tabs-1");	
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/admin/login");
					return;
				}
				if(data == AJAX_DONE) {
					//Load luoi du lieu	
					message("Lưu file type thành công!",1);
				} else {
					message('Lưu file type không thành công!',0);										
				}
			},
			error: function(data){ unblock("#tabs-1");alert (data);}	
		});
	}
	function saveSenderEmail() {
		checkValidate=true;
		if(byId("primary_email").value!='')
			validate(['email'],'primary_email',['Email không hợp lệ!']);
		if(byId("second_email").value!='')
			validate(['email'],'second_email',['Email không hợp lệ!']);
		if(checkValidate == false)
			return;
		dataString = $("#formSender").serialize();
		byId("msg").innerHTML="";
		block("#tabs-3");	
		$.ajax({
			type: "POST",
			cache: false,
			url : url("/admin/saveMailSender&"),
			data: dataString,
			success: function(data){
				unblock("#tabs-3");	
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/admin/login");
					return;
				}
				if(data == AJAX_DONE) {
					//Load luoi du lieu	
					message("Lưu mail sender thành công!",1);
				} else {
					message('Lưu mail sender không thành công!',0);										
				}
			},
			error: function(data){ unblock("#tabs-3");alert (data);}	
		});
	}
	function sendTestPrimary() {
		checkValidate=true;
		validate(['require','email'],'primary_email',['Vui lòng nhập địa chỉ Email','Email không hợp lệ!']);
		if(checkValidate == false)
			return;
		dataString = $("#formSender").serialize();
		$('#btSendTestPrimary').attr('disabled','disabled');
		byId("msg_email").innerHTML="Sending...";
		$.ajax({
			type: "POST",
			cache: false,
			url : url("/admin/sendTestPrimary&"),
			data: dataString,
			success: function(data){
				$('#btSendTestPrimary').removeAttr('disabled');
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/admin/login");
					return;
				}
				if(data == AJAX_DONE) {
					//Load luoi du lieu	
					byId("msg_email").innerHTML="<font color='green'>Test primary sender thành công!</font>";
				} else {
					byId("msg_email").innerHTML="<font color='red'>Test primary sender  không thành công!</font>";									
				}
			},
			error: function(data){ $('#btSendTestPrimary').removeAttr('disabled');alert (data);}	
		});
	}
	function sendTestSecond() {
		checkValidate=true;
		validate(['require','email'],'primary_email',['Vui lòng nhập địa chỉ Email','Email không hợp lệ!']);
		if(checkValidate == false)
			return;
		dataString = $("#formSender").serialize();
		$('#btSendTestSecond').attr('disabled','disabled');
		byId("msg_email").innerHTML="Sending...";
		$.ajax({
			type: "POST",
			cache: false,
			url : url("/admin/sendTestSecond&"),
			data: dataString,
			success: function(data){
				$('#btSendTestSecond').removeAttr('disabled');
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/admin/login");
					return;
				}
				if(data == AJAX_DONE) {
					//Load luoi du lieu	
					byId("msg_email").innerHTML="<font color='green'>Test second sender thành công!</font>";
				} else {
					byId("msg_email").innerHTML="<font color='red'>Test second sender không thành công!</font>";									
				}
			},
			error: function(data){ $('#btSendTestSecond').removeAttr('disabled');alert (data);}	
		});
	}
	$(document).ready(function(){				
		$("#title_page").text("Cấu hình hệ thống");
		$("#tabs").tabs();
		$('#mail_content').tinymce({
			script_url : url_base+'/public/js/tiny_mce/tiny_mce.js',
			theme : "advanced",
			plugins : "pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",
			theme_advanced_buttons1 : "newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
			theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,code,|,preview,|,forecolor,backcolor",
			theme_advanced_buttons3 : "tablecontrols,emotions,media",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "bottom",
			theme_advanced_resizing : true,
			relative_urls : false,
			convert_urls : false,
			content_css : "css/content.css"
		});
	});
</script>