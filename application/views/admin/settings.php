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
								<option value="mail_permission">Mail Xin Đăng Dự Án</option>
								<option value="mail_expiredproject">Mail Dự Án Hết Hạn</option>
								<option value="mail_approve">Mail Duyệt Dự Án</option>
								<option value="mail_postproject">Mail Thông Báo Đăng Dự Án</option>
								<option value="mail_rejectpostproject">Mail Thông Báo Từ Chối Đăng Dự Án</option>
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
		<form id="formPriSender">
		<div id="msg_email"></div>
		<fieldset>
		<legend><strong>Primary Sender</strong></legend>
		<table width="99%">
		<tr>
			<input type="hidden" name="primary_id" id="primary_id" value="" />
			<td><div style="width:80px">Email:</div><input type="text" name="primary_email" id="primary_email" value="" style="width:200px"/><br/></td>
			<td><div style="width:80px">Password:</div>
		<input type="password" name="primary_password" id="primary_password" value="" style="width:200px"/><br/></td>
			<td><div style="width:80px">SMTP:</div>
			<input type="text" name="primary_smtp" id="primary_smtp" value="" style="width:200px"/><br/></td>
				<td><div style="width:80px">Port:</div>
			<input type="text" name="primary_port" id="primary_port" value="" style="width:200px"/><br/></td>
		</tr>	
		<tr>
			<td colspan="4" align="center">
			<input id="btSavePrimary" type="button" value="Lưu" onclick="saveEmail(1)"/>
			<input id="btSendTestPrimary" type="button" value="Send Test" onclick="sendTest(1)"/>
			<input type="button" value="Reset" onclick="doResetEmail(1)"/>
			</td>
		</tr>
		<tr>
			<td colspan="4">
			<div id="datagridPreSenders">
				<table width="99%">
					<thead>
						<tr class="ui-accordion-header ui-helper-reset ui-state-default ui-corner-all" style="font-weight:bold;height:20px;text-align:center;">
							<td width="10px">ID</td>
							<td>Email</td>
							<td>Password</td>
							<td>SMTP</td>
							<td width="40px">Port</td>
							<td width="40px">Xử lý</td>
						</tr>
					</thead>
				</table>
			</div>
			</td>
		</tr>
		</table>
		</fieldset>
		</form>
		<form id="formSecSender">
		<fieldset>
		<legend><strong>Second Sender</strong></legend>
		<table width="99%">
		<tr>
			<input type="hidden" name="second_id" id="second_id" value="" />
			<td><div style="width:80px">Email:</div> 
			<input type="text" name="second_email" id="second_email" value="" style="width:200px"/><br/></td>
			<td><div style="width:80px">Password:</div>
			<input type="password" name="second_password" id="second_password" value="" style="width:200px"/><br/></td>
			<td><div style="width:80px">SMTP:</div>
			<input type="text" name="second_smtp" id="second_smtp" value="" style="width:200px"/><br/></td>
				<td><div style="width:80px">Port:</div>
			<input type="text" name="second_port" id="second_port" value="" style="width:200px"/><br/></td>
		</tr>	
		<tr>
			<td colspan="4" align="center">
			<input id="btSaveSecond" type="button" value="Lưu" onclick="saveEmail(0)"/>
			<input id="btSendTestSecond" type="button" value="Send Test" onclick="sendTest(0)"/>
			<input type="button" value="Reset" onclick="doResetEmail(0)"/>
			</td>
		</tr>
		<tr>
			<td colspan="4">
			<div id="datagridSecSenders">
				<table width="99%">
					<thead>
						<tr class="ui-accordion-header ui-helper-reset ui-state-default ui-corner-all" style="font-weight:bold;height:20px;text-align:center;">
							<td width="10px">ID</td>
							<td>Email</td>
							<td>Password</td>
							<td>SMTP</td>
							<td width="40px">Port</td>
							<td width="40px">Xử lý</td>
						</tr>
					</thead>
				</table>
			</div>
			</td>
		</tr>
		</table>
		</fieldset>
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
	function sendTest(isPre) {
		checkValidate=true;
		if(isPre==1) //Luu email primary
			if(byId("primary_email").value!='')
				validate(['email'],'primary_email',['Email không hợp lệ!']);
		else {
			if(byId("second_email").value!='')
				validate(['email'],'second_email',['Email không hợp lệ!']);
		}
		if(checkValidate == false)
			return;
		idBtSendTest = "#btSendTestPrimary";
		if(isPre) {
			dataString = $("#formPriSender").serialize();
		} else {
			dataString = $("#formSecSender").serialize();
			idBtSendTest = "#btSendTestSecond";
		}
		$(idBtSendTest).attr('disabled','disabled');
		byId("msg_email").innerHTML="Sending...";
		$.ajax({
			type: "POST",
			cache: false,
			url : url("/admin/sendTest/"+isPre+"&"),
			data: dataString,
			success: function(data){
				$(idBtSendTest).removeAttr('disabled');
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/admin/login");
					return;
				}
				if(data == AJAX_DONE) {
					//Load luoi du lieu	
					byId("msg_email").innerHTML="<font color='green'>Test gửi email thành công!</font>";
				} else {
					byId("msg_email").innerHTML="<font color='red'>Test gửi email không thành công!</font>";									
				}
			},
			error: function(data){ $(idBtSendTest).removeAttr('disabled');alert (data);}	
		});
	}
	function doResetEmail(isPre) {
		if(isPre == 1) {
			$("#formPriSender")[0].reset();
			byId("primary_id").value = '';
		} else {
			$("#formSecSender")[0].reset();
			byId("second_id").value = '';
		}
	}
	function saveEmail(isPre) {
		checkValidate=true;
		if(isPre==1) //Luu email primary
			validate(['email'],'primary_email',['Email không hợp lệ!']);
		else {
			validate(['email'],'second_email',['Email không hợp lệ!']);
		}
		if(checkValidate == false)
			return;
		if(isPre)
			dataString = $("#formPriSender").serialize();
		else
			dataString = $("#formSecSender").serialize();
		byId("msg").innerHTML="";
		block("#tabs-3");	
		$.ajax({
			type: "POST",
			cache: false,
			url : url("/admin/saveEmail/"+isPre+"&"),
			data: dataString,
			success: function(data){
				unblock("#tabs-3");	
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/admin/login");
					return;
				}
				if(data == AJAX_DONE) {
					//Load luoi du lieu	
					if(isPre==1) {
						loadEmailSenders(1);
						if(byId("primary_id").value!='')
							doResetEmail(1);
					} else {
						loadEmailSenders(0);
						if(byId("second_id").value!='')
							doResetEmail(0);
					}
					message("Lưu mail sender thành công!",1);
				} else {
					message('Lưu mail sender không thành công!',0);										
				}
			},
			error: function(data){ unblock("#tabs-3");alert (data);}	
		});
	}
	function loadEmailSenders(isPre) {
		var idblock = "#datagridSecSenders";
		if(isPre==1)
			idblock = "#datagridPreSenders";
		block(idblock);
		$.ajax({
			type : "GET",
			cache: false,
			url: url("/admin/listEmail/"+isPre),
			success : function(data){	
				//alert(data);
				unblock(idblock);
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/admin/login");
				} else {
					if(isPre==1)
						$(idblock).html(data);
					else
						$(idblock).html(data);
				}
				
			},
			error: function(data){ 
				unblock(idblock);
				alert (data);
			}			
		});
	}
	function selectSender(isPre,_this) {
		//jsdebug(_this);
		if(objediting)
			objediting.style.backgroundColor = '';
		var tr = _this.parentNode.parentNode;
		var cells = tr.cells;
		tr.style.backgroundColor = CONST_ROWSELECTED_COLOR;	
		objediting = tr;	
		if(isPre == 1) {
			byId("primary_id").value = $.trim($(cells.td_id).text());
			byId("primary_email").value = $.trim($(cells.td_email).text());
			byId("primary_password").value = $.trim($(cells.td_password).text());
			byId("primary_smtp").value = $.trim($(cells.td_smtp).text());
			byId("primary_port").value = $.trim($(cells.td_port).text());
		} else {
			byId("second_id").value = $.trim($(cells.td_id).text());
			byId("second_email").value = $.trim($(cells.td_email).text());
			byId("second_password").value = $.trim($(cells.td_password).text());
			byId("second_smtp").value = $.trim($(cells.td_smtp).text());
			byId("second_port").value = $.trim($(cells.td_port).text());
		}
	}
	function removeEmail(isPre,id) {
		if(!confirm("Bạn muốn xóa email này?"))
			return;
		block("#tabs-3");
		$.ajax({
			type : "GET",
			cache: false,
			url: url("/admin/removeEmail/"+isPre+"&id="+id),
			success : function(data){	
				//alert(data);
				unblock("#tabs-3");
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/admin/login");
				} else if(data == AJAX_DONE) {
					//Load luoi du lieu	
					if(isPre==1)
						loadEmailSenders(1);
					else
						loadEmailSenders(0);
					message("Thao tác thành công!",1);
				} else {
					message('Thao tác không thành công!',0);										
				}
				
			},
			error: function(data){ 
				unblock("#tabs-3");
				alert (data);
			}			
		});
		
	}
	$(document).ready(function(){				
		$("#title_page").text("Cấu hình hệ thống");
		$("#tabs").tabs({
			select: function(e, ui) {
				if(ui.tab.hash == "#tabs-3") {
					loadEmailSenders(1);
					loadEmailSenders(0);
				}
			}
		});
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