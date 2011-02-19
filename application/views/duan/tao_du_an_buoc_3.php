<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/validator.js"></script>
<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/jHtmlArea-0.7.0.js"></script>
<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/jHtmlArea.ColorPickerMenu-0.7.0.js"></script>
<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/jquery.form.js"></script>
<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/utils.js"></script>
<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/costtype.js"></script>

<link href="<?php echo BASE_PATH ?>/public/css/front/jHtmlArea.css" rel="stylesheet" type="text/css" />
<link href="<?php echo BASE_PATH ?>/public/css/front/jHtmlArea.ColorPickerMenu.css" rel="stylesheet" type="text/css" />
<style type="text/css">
	.multiselect {  
		height:200px;
		width:300px; 
	} 
	.tdLabel {
		text-align:right;
		width:114px;
	}
</style>
<div id="content" style="width:100%;">
	<div class="ui-widget-header ui-helper-clearfix ui-corner-top" style="border:none;padding-left: 5px" id="content_title">Tạo dự án - Bước 3</div>
	<center>
	<div class="divTable" style="width:100%">
		<form id="formDuan" >
		<div class="tr" style="border:none">
			<div class="td" id="msg"></div>
		</div>
		<div class="tr" style="border:none">
			<div class="td tdLabel" style="text-align:right;">Email <span style="color:red;font-weight:bold;cursor:pointer;" title="Bắt buộc nhập dữ liệu">*</span> :</div>
			<div class="td tdInput">
			<input type="text"  name="duan_email" id="duan_email" tabindex=7 value="<?php echo $email ?>"/>
			</div>
		</div>
		<div class="tr" style="border:none">
			<div class="td tdLabel" style="text-align:right;">Số điện thoại <span style="color:red;font-weight:bold;cursor:pointer;" title="Bắt buộc nhập dữ liệu">*</span> :</div>
			<div class="td tdInput">
			<input type="text"  name="duan_sodienthoai" id="duan_sodienthoai" tabindex=7 value="<?php echo $sodienthoai ?>"/>
			</div>
		</div>
		<div class="tr" style="border:none;text-align:left">
			<div class="td">
			Chi tiết công việc:<br/>
			<textarea id="duan_thongtinchitiet" name="duan_thongtinchitiet" style="border:none;" rows="15" tabindex=8></textarea>
			</div>
		</div>
		</form>
		<form id="formUpload">
		<div class="tr" style="border:none">
			<div class="td tdLabel" style="text-align:right;">File đính kèm :</div>
			<div class="td tdInput">
			<input type="hidden" name="duan_filedinhkem" id="duan_filedinhkem" value="0"/>
			<input type="file" name="fileupload" id="fileupload" onchange="doUploadFile()" tabindex=5/> (Size < 2Mb)
			</div>
		</div>
		<div style="border:none">
			<div class="td tdLabel" style="text-align:right;">&nbsp;</div>
			<div class="td tdInput" id="fileuploaded">
			</div>
		</div>
		</form>
		<div class="tr" style="border:none">
			<div class="td">
			<input id="btsubmit" type="button" onclick="location.href='<?php echo BASE_PATH?>/duan/tao_du_an_buoc_2'" value="Trở Lại Bước 2"  tabindex=9>
			<input id="btsubmit" type="button" onclick="doSubmit()" value="Hoàn Tất"  tabindex=9>
			</div>
		</div>
	</div>
	</center>
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
	function doReset() {
		$("#formDuan")[0].reset(); //Reset form cua jquery, giu lai gia tri mac dinh cua cac field	
		$("#formDuan :input").css('border-color','');
		byId("msg").innerHTML="";
		$('#btsubmit').removeAttr('disabled');
	}
	function validateFormDuAn(formData, jqForm, options) {
		location.href = "#top";
		checkValidate=true;
		validate(['require','email'],'duan_email',["Vui lòng nhập email chủ dự án!","Email sai định dạng!"]);
		validate(['require'],'duan_sodienthoai',["Vui lòng nhập số điện thoại chủ dự án!"]);
		if(checkValidate==false) {
			return false;
		}
		if($("#select2 option").length><?php echo MAX_SKILL ?>) {
			message("Bạn được phép chọn tối đa <?php echo MAX_SKILL ?> Skill!",0);
			return false;
		}
		byId("duan_alias").value = remove_space(remove_accents(byId("duan_tenduan").value));
		$("#select2").each(function(){  
			$("#select2 option").attr("selected","selected");
		});
		var value = byId("duan_cost").value;
		byId("duan_costmin").value = arrCostType[value].min;
		byId("duan_costmax").value = arrCostType[value].max;
		$('#btsubmit').attr('disabled','disabled');
		byId("msg").innerHTML="<div class='loading'><span class='bodytext' style='padding-left:30px;'>Đang xử lý...</span></div>";
		return true;
	}
	function redirectPage() {
		location.href = url("/");
	}
	function doUploadFile() {
		$("#fileuploaded").html("Uploading...");
		$('#formUpload').submit();
	}
	function doSubmit() {
		$('#formDuan').submit();
	}
	function removechosen(idchosen) {
		$("#chosen_"+idchosen).remove();
	}
	$(document).ready(function() {
		//document.title = "Tạo Dự Án - "+document.title;
		$("#duan_thongtinchitiet").css("width","100%");
		$("#duan_thongtinchitiet").htmlarea({
				toolbar: [
					["html"], ["bold", "italic", "underline"],
					["increasefontsize", "decreasefontsize", "forecolor"],
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
		options = { 
			beforeSubmit: validateFormDuAn,
			url:        url("/duan/submit_tao_du_an_buoc_3"), 
			type:      "post",
			dataType: "xml",
			success:    function(data) { 
				$('#btsubmit').removeAttr('disabled');
				data = data.body.childNodes[0].data;	
				
				if(data == AJAX_DONE) {
					message("Tạo mới dự án thành công! Đang chuyển đến trang chủ...",1);
					setTimeout("redirectPage()",redirect_time);
				} if(data == AJAX_DONE) {
					message("Tạo mới dự án thành công! Đang chuyển đến trang chủ...",1);
					setTimeout("redirectPage()",redirect_time);
				} else {
					message("Tạo mới dự án không thành công!",0);
				}
			},
			error : function(data) {
				$('#btsubmit').removeAttr('disabled');
				alert(data);
			} 
		}; 
		options2 = { 
			url:        url("/file/upload"), 
			type:      "post",
			dataType: "xml",
			success:    function(data) { 
				data = data.body.childNodes[0].data;	
				$("#fileuploaded").html('');
				if(data == "ERROR_FILESIZE") {
					message("File upload phải nhỏ hơn 2Mb!",0);
					return;
				}
				if(data == AJAX_ERROR_WRONGFORMAT) {
					message("Upload file sai định dạng!",0);
					return;
				}
				if(isNaN(data) == true) {
					message("Lỗi hệ thống, vui lòng thử lại sau!",0);
				} else {
					byId("msg").innerHTML="";
					byId("duan_filedinhkem").value = data;
					idchosen = "chosen_"+data;
					$("#fileuploaded").html('<div style="display: block;" id="'+idchosen+'" ") class="chosen-container"><span class="chosen">'+byId("fileupload").value+'<img onclick="removechosen('+data+')" class="btn-remove-chosen" src="<?php echo BASE_PATH?>/public/images/icons/close_8x8.gif"/></span></div>');
				} 
			},
			error : function(data) {
				alert(data);
			} 
		}; 
		$('#formDuan').ajaxForm(options);
		$('#formUpload').ajaxForm(options2);
		// pass options to ajaxForm 
		$("#tfoot_paging").html($("#thead_paging").html());
		menuid = '#tao-du-an';
		$("#menu "+menuid).addClass("current");
		$("input:submit, input:button", "body").button();
		boundTip("duan_email","Là email của chủ dự án mà ứng viên thắng thầu sẽ liên lạc.");
		boundTip("duan_sodienthoai","Là số điện thoại của chủ dự án mà ứng viên thắng thầu sẽ liên lạc.");

	});
</script>
