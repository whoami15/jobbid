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
		<input type="hidden" name="duan_id" id="duan_id" value="<?php echo $duan_id?>" />
		<input type="hidden" name="duan_filedinhkem" id="duan_filedinhkem" value="0"/>
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
			<textarea id="duan_thongtinchitiet" name="duan_thongtinchitiet" style="width:100%;" spellcheck="false" rows="15" tabindex=8></textarea>
			</div>
		</div>
		</form>
		<form id="formUpload">
		<div class="tr" style="border:none">
			<div class="td tdLabel" style="text-align:right;">File đính kèm :</div>
			<div class="td tdInput">
			<span id="div_filedinhkem"><input type="file" name="fileupload" id="fileupload" onchange="doUploadFile()" tabindex=5/> (Size < 2Mb)</span>
			<span id="fileuploaded"></span>
			</div>
		</div>
		</form>
		<div class="tr" style="border:none">
			<div class="td">
			<input type="button" onclick="location.href='<?php echo BASE_PATH?>/duan/tao_du_an_buoc_2/<?php echo $duan_id?>'" value="Trở Lại Bước 2"  tabindex=9>
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
	function redirectPage() {
		location.href = url("/");
	}
	function doUploadFile() {
		$("#div_filedinhkem").hide();
		$("#fileuploaded").html("Uploading...");
		$('#formUpload').submit();
	}
	function checkEmail() {
		$.ajax({
			type : "GET",
			cache: false,
			url : url("/account/checkEmail&email="+byId("duan_email").value),
			success : function(data){	
				//alert(data);return;
				if(data=="OK" || data == "REGISTER") {
					$('#duan_thongtinchitiet').htmlarea("updateTextArea"); 
					dataString = $("#formDuan").serialize();
					//alert(dataString);return;
					$.ajax({
						type : "POST",
						cache: false,
						url : url("/duan/submit_tao_du_an_buoc_3&"),
						data: dataString,
						success : function(data){	
							//alert(data);return;
							$('#btsubmit').removeAttr('disabled');
							if(data == "OK") {
								message("Tạo mới dự án thành công! Đang chuyển đến trang chủ...",1);
								setTimeout("redirectPage()",redirect_time);
							} else if(data == "NOT_ACTIVE") {
								location.href = url("/duan/active_account&email="+byId("duan_email").value);
							} else {
								message("Tạo mới dự án không thành công!",0);
							}
							
						},
						error: function(data){ 
							$('#btsubmit').removeAttr('disabled');
							alert (data);
						}			
					});
				} else {
					byId("msg").innerHTML="";
					$('#btsubmit').removeAttr('disabled');
					if(data == "LOGIN") {
						$("#dialogIntro").dialog({
							minWidth: 450,
							title: 'Đăng Nhập',
							buttons: {}
						});	
						$.ajax({
							type : "GET",
							cache: false,
							url : url("/account/login_box"),
							success : function(data){	
								//alert(data);return;
								$("#dialogIntro").html(data);
								$("#dialogIntro").dialog("open");
								email = byId("duan_email").value;
								$("#loginbox_msg").html("<font color='red'>Email <b>"+email+"</b> đã được đăng ký trước đây, vui lòng đăng nhập bằng email này!</font>");
								byId("username").value = email;
								byId("password").focus();
							},
							error: function(data){ alert (data);}			
						});
					} else {
						message("Tạo mới dự án không thành công!",0);
					}
				}
			},
			error: function(data){ 
				$('#btsubmit').removeAttr('disabled');
				alert (data);
			}			
		});
	}
	var timer1;
	function doSubmit() {
		//alert($("#duan_thongtinchitiet").html());return;
		$("#dialogIntro").dialog("close");
		clearTimeout(timer1);
		location.href = "#top";
		checkValidate=true;
		validate(['require','email'],'duan_email',["Vui lòng nhập email chủ dự án!","Email sai định dạng!"]);
		validate(['require'],'duan_sodienthoai',["Vui lòng nhập số điện thoại chủ dự án!"]);
		if(checkValidate==false) {
			return;
		}
		$('#btsubmit').attr('disabled','disabled');
		byId("msg").innerHTML="<div class='loading'><span class='bodytext' style='padding-left:30px;'>Đang xử lý...</span></div>";
		checkEmail();
		
	}
	function removechosen(idchosen) {
		$("#chosen_"+idchosen).remove();
		$("#div_filedinhkem").show();
	}
	$(document).ready(function() {
		//document.title = "Tạo Dự Án - "+document.title;
		$("#duan_thongtinchitiet").css("width","100%");
		$("#duan_thongtinchitiet").htmlarea({
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
		$('#formUpload').ajaxForm({ 
			url:        url("/file/upload"), 
			type:      "post",
			dataType: "xml",
			success:    function(data) { 
				data = data.body.childNodes[0].data;	
				$("#fileuploaded").html('');
				if(data == "ERROR_FILESIZE") {
					$("#div_filedinhkem").show();
					message("File upload phải nhỏ hơn 2Mb!",0);
					return;
				}
				if(data == AJAX_ERROR_WRONGFORMAT) {
					$("#div_filedinhkem").show();
					message("Upload file sai định dạng!",0);
					return;
				}
				if(isNaN(data) == true) {
					$("#div_filedinhkem").show();
					message("Lỗi hệ thống, vui lòng thử lại sau!",0);
				} else {
					byId("msg").innerHTML="";
					byId("duan_filedinhkem").value = data;
					idchosen = "chosen_"+data;
					$("#div_filedinhkem").hide();
					$("#fileuploaded").html('<div style="display: block;" id="'+idchosen+'" ") class="chosen-container"><span class="chosen">'+byId("fileupload").value+'<img onclick="removechosen('+data+')" class="btn-remove-chosen" src="<?php echo BASE_PATH?>/public/images/icons/close_8x8.gif"/></span></div>');
				} 
			},
			error : function(data) {
				$("#div_filedinhkem").show();
				alert(data);
			} 
		});
		// pass options to ajaxForm 
		$("#tfoot_paging").html($("#thead_paging").html());
		menuid = '#tao-du-an';
		$("#menu "+menuid).addClass("current");
		$("input:submit, input:button", "body").button();
		boundTip("duan_email","Là email của chủ dự án mà ứng viên thắng thầu sẽ liên lạc.");
		boundTip("duan_sodienthoai","Là số điện thoại của chủ dự án mà ứng viên thắng thầu sẽ liên lạc.");

	});
</script>
