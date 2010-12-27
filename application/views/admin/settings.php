<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/tiny_mce/jquery.tinymce.js"></script>
<style> 	
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
<div id="tabs">
	<ul>
		<li><a href="#tabs-1">Upload File Types</a></li>
		<li><a href="#tabs-2">Mail Template</a></li>
	</ul>
	<div id="tabs-1">
		<form id="formSettings">
		<table class="center" width="100%">
			<thead>
				<tr>
					<td colspan="4" id="msg1">
					</td>
				</tr>
			</thead>
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
					<tr>
						<td id="msg2">
						</td>
					</tr>
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
</div>
<script type="text/javascript">
	var objediting; //Object luu lai row dang chinh sua
	function message1(msg,type) {
		if(type==1) { //Thong diep thong bao
			str = "<div class='positive'><span class='bodytext' style='padding-left:30px;'><strong>"+msg+"</strong></span></div>";
			byId("msg").innerHTML = str;
		} else if(type == 0) { //Thong diep bao loi
			str = "<div class='negative'><span class='bodytext' style='padding-left:30px;'><strong>"+msg+"</strong></span></div>";
			byId("msg").innerHTML = str;
		}
	}
	function message2(msg,type) {
		if(type==1) { //Thong diep thong bao
			str = "<div class='positive'><span class='bodytext' style='padding-left:30px;'><strong>"+msg+"</strong></span></div>";
			byId("msg2").innerHTML = str;
		} else if(type == 0) { //Thong diep bao loi
			str = "<div class='negative'><span class='bodytext' style='padding-left:30px;'><strong>"+msg+"</strong></span></div>";
			byId("msg2").innerHTML = str;
		}
	}
	function selectMailtype(id) {
		byId("msg2").innerHTML="";
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
					message2('Thao tác không thành công!',0);
				} else {
					$("#mail_content").html(data);										
				}
			},
			error: function(data){ unblock("#tabs-2");alert (data);}	
		});
	}
	function saveMailTemplate() {
		dataString = $("#formMailTemplate").serialize();
		byId("msg2").innerHTML="";
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
					message2("Lưu cấu hình thành công!",1);
				} else {
					message2('Lưu cấu hình không thành công!',0);										
				}
			},
			error: function(data){ unblock("#tabs-2");alert (data);}	
		});
	}
	function save() {
		dataString = $("#formSettings").serialize();
		byId("msg1").innerHTML="";
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
					message1("Lưu cấu hình thành công!",1);
				} else {
					message1('Lưu cấu hình không thành công!',0);										
				}
			},
			error: function(data){ unblock("#tabs-1");alert (data);}	
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