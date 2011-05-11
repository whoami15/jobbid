<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/validator.js"></script>
<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/jHtmlArea-0.7.0.js"></script>
<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/jHtmlArea.ColorPickerMenu-0.7.0.js"></script>
<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/utils.js"></script>
<link href="<?php echo BASE_PATH ?>/public/css/front/jHtmlArea.css" rel="stylesheet" type="text/css" />
<link href="<?php echo BASE_PATH ?>/public/css/front/jHtmlArea.ColorPickerMenu.css" rel="stylesheet" type="text/css" />
<style type="text/css">
	.multiselect {  
		height:200px;
		width:300px;  
	} 
	.tdLabel {
		text-align:right;
		width:170px;
	}
</style>
<div id="content" style="width:100%;">
	<form id="formRaovat" style="padding-bottom: 10px;" >
	<div class="ui-widget-header ui-helper-clearfix ui-corner-top" style="border:none;padding-left: 5px" id="content_title">Sửa tin rao vặt</div>
		<input type="hidden" name="raovat_id" id="raovat_id" value="<?php echo $dataRaovat["id"]?>" />
		<input type="hidden" name="raovat_alias" id="raovat_alias" value="" />
		<center>
		<div class="divTable" style="width:100%">
			<div class="tr" style="border:none">
				<div class="td" id="msg"></div>
			</div>
			<div class="tr" style="border:none">
				<div class="td tdLabel" style="text-align:right;">Tiêu đề <span style="color:red;font-weight:bold;cursor:pointer;" title="Bắt buộc nhập dữ liệu">*</span> :</div>
				<div class="td tdInput">
				<input type="text" name="raovat_tieude" style="width:90%" id="raovat_tieude" value="<?php echo $dataRaovat["tieude"]?>" tabindex=1/>
				</div>
			</div>
			<div class="tr" style="border:none">
				<div class="td tdLabel" style="text-align:right;">Email <span style="color:red;font-weight:bold;cursor:pointer;" title="Bắt buộc nhập dữ liệu">*</span> :</div>
				<div class="td tdInput">
				<input type="text"  name="raovat_email" id="raovat_email" tabindex=2 value="<?php echo $dataRaovat["raovat_email"]?>"/>
				</div>
			</div>
			<div class="tr" style="border:none">
				<div class="td tdLabel" style="text-align:right;">Số điện thoại <span style="color:red;font-weight:bold;cursor:pointer;" title="Bắt buộc nhập dữ liệu">*</span> :</div>
				<div class="td tdInput">
				<input type="text"  name="raovat_sodienthoai" id="raovat_sodienthoai" tabindex=3 value="<?php echo $dataRaovat["raovat_sodienthoai"]?>"/>
				</div>
			</div>
			<div class="tr" style="border:none;text-align:left">
				<div class="td">
				Nội dung rao :<br/>
				<textarea id="raovat_noidung" name="raovat_noidung" style="width:100%;" spellcheck="false" rows="15" tabindex=4><?php echo $dataRaovat["noidung"]?></textarea>
				</div>
			</div>
			<div class="tr" style="border:none">
				<div class="td">
				<input id="btsubmit" type="button" value="Cập Nhật" onclick="doUpdate()"  tabindex=9>
				<?php
				if($dataRaovat["status"]==1) {
					?>
					<input id="btChangeStatusTinrao" onclick="changeStatus(<?php echo $dataRaovat["id"]?>,0)" value="Ngưng Rao" type="button" tabindex=10>
					<?php
				} else {
				?>
				<input id="btChangeStatusTinrao" onclick="changeStatus(<?php echo $dataRaovat["id"]?>,1)" value="Mở Tin Rao" type="button" tabindex=10>
				<?php
				}
				?>
				</div>
			</div>
		</div>
		</center>
	</form>
</div>
<script type="text/javascript">
	function message(msg,type) {
		if(type==1) { //Thong diep thong bao
			str = "<div class='positive'><span class='bodytext' style='padding-left:30px;'>"+msg+"</span></div>";
			byId("msg").innerHTML = str;
		} else if(type == 0) { //Thong diep bao loi
			str = "<div class='negative'><span class='bodytext' style='padding-left:30px;'>"+msg+"</span></div>";
			byId("msg").innerHTML = str;
		}
	}	
	function doUpdate() {
		$("#dialogIntro").dialog("close");
		location.href = "#top";
		checkValidate=true;
		validate(['require'],'raovat_tieude',["Vui lòng nhập tiêu đề!"]);
		validate(['require','email'],'raovat_email',["Vui lòng nhập email người đăng tin!","Email sai định dạng!"]);
		validate(['require'],'raovat_sodienthoai',["Vui lòng nhập số điện thoại người đăng tin!"]);
		if(checkValidate==false) {
			return;
		}
		$('#btsubmit').attr('disabled','disabled');
		byId("msg").innerHTML="<div class='loading'><span class='bodytext' style='padding-left:30px;'>Đang lưu dữ liệu nhập...</span></div>";
		$('#raovat_noidung').htmlarea("updateTextArea"); 
		byId("raovat_alias").value = remove_space(remove_accents(byId("raovat_tieude").value));
		dataString = $("#formRaovat").serialize();
		//alert(dataString);return;
		$.ajax({
			type : "POST",
			cache: false,
			url : url("/raovat/doEdit&"),
			data: dataString,
			success : function(data){	
				//alert(data);return;
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/account/login");
					return;
				}
				if(data == "ERROR_NOTACTIVE") {
					message('Lỗi! Tài khoản của bạn chưa được active.Vui lòng kiểm tra email để active tài khoản!',0);
					$('#btsubmit').removeAttr('disabled');
					return;
				}
				if(data == "ERROR_LOCKED") {
					message("Tài khoản này đã bị khóa, vui lòng liên hệ admin@jobbid.vn để mở lại!",0);
					$('#btsubmit').removeAttr('disabled');
					return;
				}
				if(data == AJAX_DONE) {
					message("Cập nhật tin rao thành công! Đang chuyển trang...",1);
					setTimeout("redirectPage()",redirect_time);
				} else {
					message("Cập nhật tin rao không thành công!",0);
					$('#btsubmit').removeAttr('disabled');
				}
				
			},
			error: function(data){ 
				$('#btsubmit').removeAttr('disabled');
				alert (data);
			}			
		});
	}
	
	function changeStatus(raovat_id,active) {
		if(raovat_id==null)
			return;
		if(active==0)
			if(!confirm("Tin rao này sẽ không được hiển thị khi ngừng rao.\nBạn có muốn ngừng rao tin này?"))
				return;
		$('#btChangeStatusTinrao').attr('disabled','disabled');
		location.href = "#top";
		byId("msg").innerHTML="<div class='loading'><span class='bodytext' style='padding-left:30px;'>Đang xử lý...</span></div>";
		$.ajax({
			type: "GET",
			cache: false,
			url : url("/raovat/changeStatus/"+active+"&raovat_id="+raovat_id),
			success: function(data){
				$('#btChangeStatusTinrao').removeAttr('disabled');
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/account/login");
					return;
				}
				if(data == "ERROR_LOCKED") {
					message("Tài khoản này đã bị khóa, vui lòng liên hệ admin@jobbid.vn để mở lại!",0);
					return;
				}
				if(data == AJAX_DONE) {
					if(active==0)
						message("Ngưng rao tin thành công! Đang chuyển trang...",1);
					else
						message("Mở tin rao thành công! Đang chuyển trang...",1);
					setTimeout("redirectPage()",redirect_time);
				} else {
					message("Thao tác bị lỗi, vui lòng thử lại!",0);
				}
			},
			error: function(data){ $('#btChangeStatusTinrao').removeAttr('disabled');alert (data);}	
		});
	}
	function redirectPage() {
		location.href = url('/raovat/view/'+byId("raovat_id").value+'/'+byId("raovat_alias").value);
	}
	$(document).ready(function() {
		//document.title = "Chỉnh Sửa Dự Án - "+document.title;
		$("#raovat_noidung").css("width","100%");
		$("#raovat_noidung").htmlarea({
				toolbar: [
					["html"], ["bold", "italic", "underline", "forecolor"],
					["orderedlist", "unorderedlist"],
					["indent", "outdent"],
					["justifyleft", "justifycenter", "justifyright"],
					["link", "unlink", "image", "horizontalrule"],
					["cut", "copy", "paste"]
				],
                toolbarText: $.extend({}, jHtmlArea.defaultOptions.toolbarText, {
                        "bold": "fett",
                        "italic": "kursiv",
                        "underline": "unterstreichen"
                    }),
                css: "<?php echo BASE_PATH ?>/public/css/front/jHtmlArea.Editor.css",
                loaded: function() {
                }
			
		}) ;
		$("#choosecolor").click(function() {
			jHtmlAreaColorPickerMenu(this, {
				colorChosen: function(color) {
					$(document.body).css('background-color', color);
				}
			});
		});
		// pass options to ajaxForm 
		$("input:submit, input:button", "body").button();
	});
</script>
