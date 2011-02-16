<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/validator.js"></script>
<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/jHtmlArea-0.7.0.js"></script>
<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/jHtmlArea.ColorPickerMenu-0.7.0.js"></script>
<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/jquery.form.js"></script>
<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/utils.js"></script>
<link href="<?php echo BASE_PATH ?>/public/css/front/jHtmlArea.css" rel="stylesheet" type="text/css" />
<link href="<?php echo BASE_PATH ?>/public/css/front/jHtmlArea.ColorPickerMenu.css" rel="stylesheet" type="text/css" />
<style type="text/css">
	.tdLabel {
		text-align:right;
		width:170px;
	}
	.tdInput {
		width:492px;
	}
</style>
<div id="content" style="width:100%;">
	<form id="formnhathau" style="padding-top: 0px; padding-bottom: 10px;">
	<input type="hidden" name="nhathau_alias" id="nhathau_alias" value="" />
	<div class="ui-widget-header ui-helper-clearfix ui-corner-top" style="border:none;padding-left: 5px" id="content_title">Tạo hồ sơ nhà thầu</div>
		<center>
		<div class="divTable" style="width:99%;padding-top:5px;">
			<div class="tr" style="border:none">
				<div class="td" id="msg"></div>
			</div>
			<div class="tr" style="border:none">
				<div class="td tdLabel" style="text-align:right;">Bạn đại diện cho :</div>
				<div class="td tdInput">
				<input type="radio" name="nhathau_type" id="nhathau_type1" onclick="changeType(1)" value="1">Cá nhân
				<input type="radio" name="nhathau_type" id="nhathau_type2" onclick="changeType(2)" value="2">Công ty
				</div>
				</div>
			</div>
			<div class="tr" style="border:none">
				<div class="td tdLabel" style="text-align:right;"><span id="display_tenhienthi"></span> <span style="color:red;font-weight:bold;cursor:pointer;" title="Bắt buộc nhập dữ liệu">*</span> :</div>
				<div class="td tdInput">
				<input maxlength="255" type="text" name="nhathau_displayname" id="nhathau_displayname" style="width:90%" tabindex=1 value=""/>
				</div>
			</div>
			<div class="tr" style="border:none">
				<div class="td tdLabel" style="text-align:right;"><span id="display_gpkd_cmnd"></span> :</div>
				<div class="td tdInput">
				<input maxlength="255" type="text" name="nhathau_gpkd_cmnd" id="nhathau_gpkd_cmnd" style="width:90%" tabindex=1 value=""/>
				</div>
			</div>
			<div class="tr" style="border:none">
				<div class="td tdLabel" style="text-align:right;"><span id="display_birthyear"></span> :</div>
				<div class="td tdInput">
				<select name="nhathau_birthyear" id="nhathau_birthyear">
				</select>
				</div>
			</div>
			<div class="tr" style="border:none">
				<div class="td tdLabel" style="text-align:right;"><span id="display_diachilienhe"></span> :</div>
				<div class="td tdInput">
				<input maxlength="255" type="text" name="nhathau_diachilienhe" id="nhathau_diachilienhe" style="width:90%" tabindex=1 />
				</div>
			</div>
			<div class="tr" style="border:none">
				<div class="td tdLabel" style="text-align:right;">Lĩnh vực :</div>
				<div class="td tdInput">
				<table id="table_chonlinhvuc" width="99%">
					<tbody>
					<?php
					$i = 0;
					while($i<count($lstLinhvuc)) {
						$linhvuc = $lstLinhvuc[$i];
						echo "<tr>";
						echo "<td style='width:50%'><input type='checkbox' name='nhathau_linhvuc[]' value='".$linhvuc["linhvuc"]["id"]."'>".$linhvuc["linhvuc"]["tenlinhvuc"]."</td>";
						$i++;
						if($i<count($lstLinhvuc)) {
							$linhvuc = $lstLinhvuc[$i];
							echo "<td><input type='checkbox' name='nhathau_linhvuc[]' value='".$linhvuc["linhvuc"]["id"]."'>".$linhvuc["linhvuc"]["tenlinhvuc"]."</td>";
							$i++;
						}
						echo "</tr>";
					}
					?>
					</tbody>
				</table>
				</div>
			</div>
			<div class="tr" style="border:none">
				<div class="td tdLabel" style="text-align:right;">Email <span style="color:red;font-weight:bold;cursor:pointer;" title="Bắt buộc nhập dữ liệu">*</span> :</div>
				<div class="td tdInput">
				<input type="text" style="width:90%" value="<?php echo $_SESSION["account"]["username"] ?>" disabled=true/>
				</div>
			</div>
			<div class="tr" style="border:none">
				<div class="td tdLabel" style="text-align:right;">Số điện thoại <span style="color:red;font-weight:bold;cursor:pointer;" title="Bắt buộc nhập dữ liệu">*</span> :</div>
				<div class="td tdInput">
				<input maxlength="255" type="text" name="account_sodienthoai" id="account_sodienthoai" style="width:90%" value="<?php echo $_SESSION["account"]["sodienthoai"] ?>"/>
				</div>
			</div>
			<div class="tr" style="border:none">
				<div class="td tdLabel" style="text-align:right;"><span id="display_file"></span> :</div>
				<div class="td tdInput">
				<input type="file" name="nhathau_file" /> (Size < 2Mb)
				</div>
			</div>
			<div class="tr" style="border:none;text-align:left">
				<div class="td">
				Mô tả thêm :<br/>
				<textarea name="nhathau_motachitiet" id="nhathau_motachitiet" style="border:none;" rows="15"></textarea>
				</div>
			</div>
			<div class="tr" style="border:none">
				<div class="td">
				<input type="checkbox" name="nhathau_nhanemail" id="nhathau_nhanemail" value="1"/> Đăng ký nhận email thông báo khi có dự án mới.
				</div>
			</div>
			<div class="tr" style="border:none">
				<div class="td">
				<input value="Lưu" type="submit" id="btsubmit" tabindex="1">
				<input onclick="doReset()" value="Reset" type="button"tabindex="2">
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
	function doReset() {
		$("#formnhathau")[0].reset(); //Reset form cua jquery, giu lai gia tri mac dinh cua cac field	
		$("#formnhathau :input").css('border-color','');
		byId("msg").innerHTML="";
		$('#btsubmit').removeAttr('disabled');
	}
	var display_tenhienthi = '';
	var display_gpkd_cmnd = '';
	var display_file = '';
	var display_birthyear = '';
	var display_diachilienhe = '';
	function changeType(value) {
		if(value == 1) {
			display_tenhienthi = "Tên hiển thị";
			display_gpkd_cmnd = "Số CMND";
			display_birthyear = "Năm sinh";
			display_diachilienhe = "Địa chỉ liên hệ";
			display_file = "File mô tả kinh nghiệm";
		} else {
			display_tenhienthi = "Tên công ty";
			display_gpkd_cmnd = "Giấy phép kinh doanh";
			display_birthyear = "Năm thành lập";
			display_diachilienhe = "Trụ sở chính";
			display_file = "File hồ sơ năng lực";
		}
		byId("display_tenhienthi").innerHTML = display_tenhienthi;
		byId("display_gpkd_cmnd").innerHTML = display_gpkd_cmnd;
		byId("display_birthyear").innerHTML = display_birthyear;
		byId("display_diachilienhe").innerHTML = display_diachilienhe;
		byId("display_file").innerHTML = display_file;
	}
	function redirectPage() {
		location.href = url('/nhathau/view');
	}
	function validateFormnhathau(formData, jqForm, options) {
		location.href = "#top";
		checkValidate=true;
		validate(['require'],'nhathau_displayname',["Vui lòng nhập "+display_tenhienthi+"!"]);
		//validate(['require'],'nhathau_gpkd_cmnd',["Vui lòng nhập "+display_gpkd_cmnd+"!"]);
		validate(['require'],'account_sodienthoai',["Vui lòng nhập số điện thoại!"]);
		if(checkValidate==false) {
			return false;
		}
		byId("nhathau_alias").value = remove_space(remove_accents(byId("nhathau_displayname").value));
		$('#btsubmit').attr('disabled','disabled');
		byId("msg").innerHTML="<div class='loading'><span class='bodytext' style='padding-left:30px;'>Đang xử lý...</span></div>";
		return true;
	}
	$(document).ready(function() {
		//document.title = "Tạo Hồ Sơ Nhà Thầu - "+document.title;
		yearBegin = 1950;
		yearEnd = 2011;
		str = '';
		for(i=yearBegin;i<=yearEnd;i++)
			str+='<option value='+i+'>'+i+'</option>';
		//alert(str);
		$('#nhathau_birthyear').append(str);
		byId('nhathau_birthyear').value=2000;
		setCheckedValue(document.forms['formnhathau'].elements['nhathau_type'], 1);
		changeType(1);
		$("#nhathau_motachitiet").css("width","98%");
		$("#nhathau_motachitiet").htmlarea({
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
		var options = { 
			beforeSubmit: validateFormnhathau,
			url:        url("/nhathau/doAdd"), 
			type:      "post",
			dataType: "xml",
			success:    function(data) { 
				$('#btsubmit').removeAttr('disabled');
				data = data.body.childNodes[0].data;	
				if(data == "ERROR_FILESIZE") {
					message("File Upload có kích thước quá lớn!",0);
					return;
				}	
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/account/login");
					return;
				}
				if(data == "ERROR_NOTACTIVE") {
					message("Bạn cần phải xác nhận tài khoản mới có thể tạo hồ sơ thầu!",0);
					return;
				}
				if(data == "ERROR_LOCKED") {
					message("Tài khoản này đã bị khóa, vui lòng liên hệ admin@jobbid.vn để mở lại!",0);
					return;
				}
				if(data == AJAX_DONE) {
					message("Tạo mới hồ sơ thành công! Đang chuyển trang...",1);
					setTimeout("redirectPage()",redirect_time);
				} else if(data == AJAX_ERROR_WRONGFORMAT) {
					message("Upload file sai định dạng!",0);
				} else {
					message("Tạo mới hồ sơ không thành công!",0);
				}
			} 
		}; 
		// pass options to ajaxForm 
		$('#formnhathau').ajaxForm(options);
		$("#quan_ly_ho_so_ca_nhan").css('color','#F68618');
		$("input:submit, input:button", "body").button();
	});
</script>
