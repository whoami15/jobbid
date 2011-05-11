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
		width:114px;
	}
</style>
<div id="content" style="width:100%;">
	<div class="ui-widget-header ui-helper-clearfix ui-corner-top" style="border:none;padding-left: 5px" id="content_title">Đăng Tin Rao Vặt</div>
	<center>
	<div class="divTable" style="width:100%">
		<form id="formRaovat" >
		<input type="hidden" name="raovat_alias" id="raovat_alias" value="" />
		<div class="tr" style="border:none;padding-top:5px">
			<div class="td" id="msg">(Những thông tin có dấu <span style="color:red;font-weight:bold;cursor:pointer;" title="Bắt buộc nhập dữ liệu">*</span> là những thông tin bắt buộc bạn phải nhập)</div>
		</div>
		<div class="tr" style="border:none">
			<div class="td tdLabel" style="text-align:right;">Tiêu đề <span style="color:red;font-weight:bold;cursor:pointer;" title="Bắt buộc nhập dữ liệu">*</span> :</div>
			<div class="td tdInput">
			<input type="text" maxlength="100" name="raovat_tieude" style="width:90%" id="raovat_tieude" value="" tabindex=1/>
			</div>
		</div>
		<div class="tr" style="border:none">
			<div class="td tdLabel" style="text-align:right;">Email <span style="color:red;font-weight:bold;cursor:pointer;" title="Bắt buộc nhập dữ liệu">*</span> :</div>
			<div class="td tdInput">
			<input type="text" maxlength="100"  name="raovat_email" id="raovat_email" tabindex=2 value="<?php echo $email ?>"/>
			</div>
		</div>
		<div class="tr" style="border:none">
			<div class="td tdLabel" style="text-align:right;">Số điện thoại <span style="color:red;font-weight:bold;cursor:pointer;" title="Bắt buộc nhập dữ liệu">*</span> :</div>
			<div class="td tdInput">
			<input type="text" maxlength="20"  name="raovat_sodienthoai" id="raovat_sodienthoai" tabindex=3 value="<?php echo $sodienthoai ?>"/>
			</div>
		</div>
		<div class="tr" style="border:none;text-align:left">
			<div class="td">
			Nội dung rao :<br/>
			<textarea id="raovat_noidung" name="raovat_noidung" style="width:100%;" spellcheck="false" rows="15" tabindex=4></textarea>
			</div>
		</div>
		<div class="tr" style="border:none">
			<div class="td">
			<input id="btsubmit" type="button" onclick="doSubmit()" value="Đăng Tin"  tabindex=9>
			</div>
		</div>
		</form>
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
	function checkEmail() {
		$.ajax({
			type : "GET",
			cache: false,
			url : url("/account/checkEmail&email="+byId("raovat_email").value),
			success : function(data){	
				//alert(data);return;
				if(data=="OK" || data == "REGISTER") {
					byId("msg").innerHTML="<div class='loading'><span class='bodytext' style='padding-left:30px;'>Đang lưu dữ liệu nhập...</span></div>";
					$('#raovat_noidung').htmlarea("updateTextArea"); 
					byId("raovat_alias").value = remove_space(remove_accents(byId("raovat_tieude").value));
					dataString = $("#formRaovat").serialize();
					//alert(dataString);return;
					$.ajax({
						type : "POST",
						cache: false,
						url : url("/raovat/submit_dang_tin_rao_vat&"),
						data: dataString,
						success : function(data){	
							//alert(data);return;
							$('#btsubmit').removeAttr('disabled');
							if(data == "OK") {
								message("Đăng tin rao vặt thành công! Đang chuyển đến trang chủ...",1);
								setTimeout("redirectPage()",redirect_time);
							} else if(data == "NOT_ACTIVE") {
								location.href = url("/raovat/active_account&email="+byId("raovat_email").value);
							} else {
								message("Đăng tin rao vặt không thành công!",0);
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
								email = byId("raovat_email").value;
								$("#loginbox_msg").html("<font color='red'>Email <b>"+email+"</b> đã được đăng ký trước đây, vui lòng đăng nhập bằng email này!</font>");
								byId("username").value = email;
								byId("password").focus();
							},
							error: function(data){ alert (data);}			
						});
					} else {
						message("Đăng tin rao vặt không thành công!",0);
					}
				}
			},
			error: function(data){ 
				$('#btsubmit').removeAttr('disabled');
				alert (data);
			}			
		});
	}
	function doSubmit() {
		//alert($("#raovat_noidung").html());return;
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
		byId("msg").innerHTML="<div class='loading'><span class='bodytext' style='padding-left:30px;'>Kiểm tra dữ liệu nhập...</span></div>";
		checkEmail();
		
	}
	$(document).ready(function() {
		//document.title = "Tạo Dự Án - "+document.title;
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
		$("#tfoot_paging").html($("#thead_paging").html());
		menuid = '#dang-tin-rao-vat';
		$("#menu "+menuid).addClass("current");
		$("input:submit, input:button", "body").button();
		boundTip("raovat_tieude","Nhập tiêu đề bạn cần rao");
		boundTip("raovat_email","Nhập email người đăng tin.");
		boundTip("raovat_sodienthoai","Nhập số điện thoại người đăng tin.");

	});
</script>
