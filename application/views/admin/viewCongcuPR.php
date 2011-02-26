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
<div id="tabs">
	<ul>
		<li><a href="#tabs-1">Mời Nhà Tuyển Dụng</a></li>
		<li><a href="#tabs-2">Mời Ứng Viên</a></li>
	</ul>
	<div id="tabs-1">
		<form id="formMoinhatuyendung">
		<table class="center" width="100%">
			<thead>
				<tr>
					<td colspan="4" id="msg1">
					</td>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td width="110px" align="left">Email 1 :</td>
					<td align="left">
						<input type="text" name="email1" id="email1" value="" style="width:99%" tabindex="1" onfocus="this.select()"/>
					</td>	
				</tr>
				<tr>
					<td align="left">Email 2 :</td>
					<td align="left">
						<input type="text" name="email2" id="email2" value="" style="width:99%" tabindex="2" onfocus="this.select()"/>
					</td>
				</tr>
				<tr>
					<td align="left">Email 3 :</td>
					<td align="left">
						<input type="text" name="email3" id="email3" value="" style="width:99%" tabindex="3" onfocus="this.select()"/>
					</td>
				</tr>
				<tr>
					<td align="left">Email 4 :</td>
					<td align="left">
						<input type="text" name="email4" id="email4" value="" style="width:99%" tabindex="4" onfocus="this.select()"/>
					</td>
				</tr>
				<tr>
					<td align="left">Email 5 :</td>
					<td align="left">
						<input type="text" name="email5" id="email5" value="" style="width:99%" tabindex="5" onfocus="this.select()"/>
					</td>
				</tr>				
				<tr>
					<td colspan="4" align="center" height="50px">
						<input onclick="doSend1()" value="Gửi Thư Mời" type="button" tabindex="6">
					</td>
				</tr>
			</tbody>
		</table>
		</form>
		<div id="tabs-1-result"></div>
	</div>
	<div id="tabs-2">
		
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
		$("#title_page").text("Công Cụ PR");
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