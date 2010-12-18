<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/validator.js"></script>
<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/jHtmlArea-0.7.0.js"></script>
<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/jHtmlArea.ColorPickerMenu-0.7.0.js"></script>
<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/jquery.form.js"></script>
<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/utils.js"></script>
<link href="<?php echo BASE_PATH ?>/public/css/front/jHtmlArea.css" rel="stylesheet" type="text/css" />
<link href="<?php echo BASE_PATH ?>/public/css/front/jHtmlArea.ColorPickerMenu.css" rel="stylesheet" type="text/css" />
<style>
	.label{
		width:180px;
	}
</style>
<!--[if !IE]> 
<-->
<style>
	.label{
		width:165px;
	}
</style>
<!--> 
<![endif]-->
<div id="content" style="width:100%;">
	<div class="ui-widget-header ui-helper-clearfix ui-corner-all" style='text-align: left; padding-left: 10px; margin-left: -5px; width: 100%;' id="content_title">Content</div>
	<form id="formnhathau" style="padding-top: 10px; padding-bottom: 10px;">
		<fieldset>
			<legend><span style="font-weight:bold;">Phiếu khai báo hồ sơ nhà thầu</span></legend>
			<table id="table_taonhathau" class="center" width="100%">
				<thead>
					<tr>
						<td colspan="4" id="msg">
						</td>
					</tr>
				</thead>
				<tbody>
					<tr height="30px">
						<td class="label" align="right">Bạn đại diện cho :</td>
						<td align="left">
						<input type="radio" name="nhathau_type" id="nhathau_type1" onclick="changeType(1)" value="1">Cá nhân
						<input type="radio" name="nhathau_type" id="nhathau_type2" onclick="changeType(2)" value="2">Công ty
						</td>
					</tr>
					<tr>
						<td align="right"><span id="display_tenhienthi"></span> <span style="color:red;font-weight:bold;cursor:pointer;" title="Bắt buộc nhập dữ liệu">*</span> :</td>
						<td align="left"> <input maxlength="255" type="text" name="nhathau_displayname" id="nhathau_displayname" style="width:90%" tabindex=1 value=""/>
						</td>
					</tr>
					<tr>
						<td align="right"><span id="display_gpkd_cmnd"></span> <span style="color:red;font-weight:bold;cursor:pointer;" title="Bắt buộc nhập dữ liệu">*</span> :</td>
						<td align="left"> <input maxlength="255" type="text" name="nhathau_gpkd_cmnd" id="nhathau_gpkd_cmnd" style="width:90%" tabindex=1 value=""/>
						</td>
					</tr>
					<tr>
						<td align="right">Lĩnh vực :</td>
						<td align="left">
							<table id="table_chonlinhvuc" width="99%">
								<tbody>
								<?php
								$i = 0;
								while($i<count($lstLinhvuc)) {
									$linhvuc = $lstLinhvuc[$i];
									echo "<tr>";
									echo "<td><input type='checkbox' name='nhathau_linhvuc[]' value='".$linhvuc["linhvuc"]["id"]."'>".$linhvuc["linhvuc"]["tenlinhvuc"]."</td>";
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
						</td>	
					</tr>
					<tr>
						<td align="right">Email <span style="color:red;font-weight:bold;cursor:pointer;" title="Bắt buộc nhập dữ liệu">*</span> :</td>
						<td align="left"> <input maxlength="255" type="text" name="account_email" id="account_email" style="width:90%" value="<?php echo $_SESSION["user"]["account"]["email"] ?>"/>
						</td>
					</tr>
					<tr>
						<td align="right">Số điện thoại <span style="color:red;font-weight:bold;cursor:pointer;" title="Bắt buộc nhập dữ liệu">*</span> :</td>
						<td align="left"> <input maxlength="255" type="text" name="account_sodienthoai" id="account_sodienthoai" style="width:90%" value="<?php echo $_SESSION["user"]["account"]["sodienthoai"] ?>"/>
						</td>
					</tr>
					<tr>
						<td align="right"><span id="display_file"></span> :</td>
						<td align="left">
							<input type="file" name="nhathau_file" /> (Size < 2Mb)
						</td>	
					</tr>
					<tr>
						<td align="left" colspan="2"><br/>Mô tả thêm :<br/>
							<textarea name="nhathau_motachitiet" id="nhathau_motachitiet" style="border:none;" rows="15"></textarea>
						</td>
					</tr>
					<tr>
						<td align="center" colspan="2">
						<input type="checkbox" name="nhathau_nhanemail" id="nhathau_nhanemail" value="1"/> Đăng ký nhận email thông báo khi có dự án mới.
						</td>
					</tr>
					<tr>
						<td colspan="4" align="center" height="50px">
							<input value="Lưu" type="submit" id="btsubmit" tabindex="1">
							<input onclick="doReset()" value="Reset" type="button"tabindex="2">
						</td>
					</tr>
				</tbody>
			</table>
		</fieldset>
	</form>
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
		$("#formnhathau")[0].reset(); //Reset form cua jquery, giu lai gia tri mac dinh cua cac field	
		$("#formnhathau :input").css('border-color','');
		byId("msg").innerHTML="";
		$('#btsubmit').removeAttr('disabled');
	}
	var display_tenhienthi = '';
	var display_gpkd_cmnd = '';
	var display_file = '';
	function changeType(value) {
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
	function redirectPage() {
		location.href = url('/nhathau/view');
	}
	function validateFormnhathau(formData, jqForm, options) {
		location.href = "#top";
		checkValidate=true;
		validate(['require'],'nhathau_displayname',["Vui lòng nhập "+display_tenhienthi+"!"]);
		validate(['require'],'nhathau_gpkd_cmnd',["Vui lòng nhập "+display_gpkd_cmnd+"!"]);
		validate(['require','email'],'account_email',["Vui lòng nhập email!","Địa chỉ email không hợp lệ!"]);
		validate(['require'],'account_sodienthoai',["Vui lòng nhập số điện thoại!"]);
		if(checkValidate==false) {
			return false;
		}
		$('#btsubmit').attr('disabled','disabled');
		byId("msg").innerHTML="<div class='loading'><span class='bodytext' style='padding-left:30px;'>Đang xử lý...</span></div>";
		return true;
	}
	$(document).ready(function() {
		setCheckedValue(document.forms['formnhathau'].elements['nhathau_type'], 1);
		changeType(1);
		$("#nhathau_motachitiet").css("width","100%");
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
				data = data.activeElement.childNodes[0].data;	
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/account/login");
					return;
				}
				if(data == "ERROR_FILESIZE") {
					message("File upload phải nhỏ hơn 2Mb!",0);
					return;
				}
				if(data == AJAX_DONE) {
					message("Tạo mới hồ sơ thành công! Đang chuyển trang...",1);
					setTimeout("redirectPage()",redirect_time);
				} else if(data == AJAX_ERROR_WRONGFORMAT) {
					message("Upload file sai định dạng!",0);
				} else if (data == "ERROR_EXIST_EMAIL") {
					message('Email này đã được đăng ký!',0);	
					byId("account_email").focus();
					$("#account_email").css('border-color','red');
				} else {
					message("Tạo mới hồ sơ không thành công!",0);
				}
			} 
		}; 
		// pass options to ajaxForm 
		$('#formnhathau').ajaxForm(options);
		$("#content_title").css("width",width_content-19);
		$("#content_title").text("Tạo hồ sơ cá nhân");
		$("#quan_ly_ho_so_ca_nhan").css('color','#F68618');
		$("input:submit, input:button", "body").button();
		boundTip("tip_loinhan","Số điện thoại và email của bạn (khi đăng ký tài khoản) sẽ được chủ dự án sử dụng để liên lạc với bạn <span style='color:red'>nếu bạn được trúng thầu</span>, vui lòng không điền số điện thoại và email của bạn trong phần thông tin mô tả bên dưới!",500);
	});
</script>
