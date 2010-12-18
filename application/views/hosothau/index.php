<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/validator.js"></script>
<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/jHtmlArea-0.7.0.js"></script>
<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/jHtmlArea.ColorPickerMenu-0.7.0.js"></script>
<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/jquery.form.js"></script>
<link href="<?php echo BASE_PATH ?>/public/css/front/jHtmlArea.css" rel="stylesheet" type="text/css" />
<link href="<?php echo BASE_PATH ?>/public/css/front/jHtmlArea.ColorPickerMenu.css" rel="stylesheet" type="text/css" />
<style>
	.label {
		width:100px;
	}
</style>
<!--[if !IE]> 
<-->
<style>
	.label {
		width:100px;
	}
</style>
<!--> 
<![endif]-->
<div id="content" style="width:100%;">
	<div class="ui-widget-header ui-helper-clearfix ui-corner-all" style='text-align: left; padding-left: 10px; margin-left: -5px; width: 100%;' id="content_title">Content</div>
	<form id="formHosothau" style="padding-top: 10px; padding-bottom: 10px;" >
		<input type="hidden" name="hosothau_duan_id" id="hosothau_duan_id" value="<?php echo $dataDuan["duan"]["id"]?>" />
		<fieldset>
			<legend>
			<a class='link' href="<?php echo BASE_PATH ?>/duan/view/<?php echo $dataDuan["duan"]["id"]?>/<?php echo $dataDuan["duan"]["alias"]?>">Dự án : <b><?php echo $dataDuan["duan"]["tenduan"] ?></b></a></legend>
			<table class="center" width="100%">
				<thead>
					<tr>
						<td colspan="4" id="msg">
						</td>
					</tr>
				</thead>
				<tbody>
					<tr height="25px">
						<td class="label" align="right">Giá thầu (<span style="color:red;font-weight:bold;cursor:pointer;" title="Bắt buộc nhập dữ liệu">*</span>) :</td>
						<td align="left">
							<input maxlength=10 type="text" name="hosothau_giathau" style="width:70%" value="" id="hosothau_giathau" tabindex=1/> <span class="question" id="tip_giathau">(?)</span>
						</td>
					</tr>
					<tr height="25px">
						<td align="right">Thời gian (<span style="color:red;font-weight:bold;cursor:pointer;" title="Bắt buộc nhập dữ liệu">*</span>) :</td>
						<td align="left" >
							<input maxlength=2 type="text" name="hosothau_thoigian" style="width:40%" value="" id="hosothau_thoigian" tabindex=2/> <span class="question" id="tip_thoigian">(?)</span>
						</td>
					</tr>
					<tr height="25px">
						<td align="right">MileStone :</td>
						<td align="left">
							<input type="text" name="hosothau_milestone" style="width:40%" value="" id="hosothau_milestone" tabindex=3/> (%)
						</td>
					</tr>	
					<tr height="25px">
						<td align="right">File đính kèm :</td>
						<td align="left">
							<input type="file" name="hosothau_filedinhkem" style="width:65%" value="" id="hosothau_filedinhkem" tabindex=4/>(Size < 2Mb)
						</td>
					</tr>
					<tr>
						<td align="left" colspan="4">
							<br/>Lời nhắn (vui lòng<span id="tip_loinhan" style="color:red;font-weight:bold;cursor:pointer;" > không điền email, số điện thoại </span>của bạn ở đây) :<br/>
							<textarea maxlength=5 id="hosothau_content" name="hosothau_content" style="margin-top: 5px; width: 99%;" rows="10" tabindex=5></textarea>
						</td>
					</tr>
					<tr>
						<td colspan="2" align="center" height="50px">
							<input id="btsubmit" type="submit" value="Gửi"  tabindex=6>
							<input onclick="doReset()" value="Reset" type="button" tabindex=7>
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
		$("#formHosothau")[0].reset(); //Reset form cua jquery, giu lai gia tri mac dinh cua cac field	
		$("#formHosothau :input").css('border-color','');
		byId("msg").innerHTML="";
		$('#btsubmit').removeAttr('disabled');
	}
	function validateFormHosothau(formData, jqForm, options) {
		//alert(byId("hosothau_duan_id").value);return false;
		location.href = "#top";
		checkValidate=true;
		byId("hosothau_giathau").value = $.trim(byId("hosothau_giathau").value);
		byId("hosothau_thoigian").value = $.trim(byId("hosothau_thoigian").value);
		validate(['require','number'],'hosothau_giathau',["Vui lòng nhập giá thầu!","Vui lòng nhập kiểu số!"]);
		validate(['require','number'],'hosothau_thoigian',["Vui lòng nhập thời gian!","Vui lòng nhập kiểu số!"]);
		validate(['number'],'hosothau_milestone',["Vui lòng nhập kiểu số!"]);
		if(checkValidate==false) {
			return false;
		}
		if(byId("hosothau_giathau").value == "0") {
			message("Giá thầu phải lớn hơn 0!",0);
			$("#hosothau_giathau").css('border-color','red');
			byId("hosothau_giathau").focus();
			return false;
		}
		if(byId("hosothau_thoigian").value == "0") {
			message("Thời gian phải lớn hơn 0!",0);
			$("#hosothau_thoigian").css('border-color','red');
			byId("hosothau_thoigian").focus();
			return false;
		}
		byId("msg").innerHTML="<div class='loading'><span class='bodytext' style='padding-left:30px;'>Đang xử lý...</span></div>";
		$('#btsubmit').attr('disabled','disabled');
		return true;
	}
	function redirectPage() {
		location.href = url('/duan/view/<?php echo $dataDuan["duan"]["id"]."/".$dataDuan["duan"]["alias"] ?>');
	}
	function redirectMakeProfile() {
		location.href = url('/nhathau/view');
	}
	$(document).ready(function() {
		$("#hosothau_content").css("width","99%");
		
		$("#choosecolor").click(function() {
			jHtmlAreaColorPickerMenu(this, {
				colorChosen: function(color) {
					$(document.body).css('background-color', color);
				}
			});
		});
		var options = { 
			beforeSubmit: validateFormHosothau,
			url:        url("/hosothau/doPost"), 
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
				if(data == "ERROR_EXPIRED") {
					message("Dự án này đã hết thời gian đấu thầu!",0);
					return;
				}
				if(data == "ERROR_SELFBID") {
					message("Bạn không thể đấu thầu dự án của bạn!",0);
					return;
				}
				if(data == "ERROR_DUPLICATE") {
					message("Bạn không thể đặt thầu 2 lần liên tiếp trong dự án này!",0);
					return;
				}
				if(data == "ERROR_MAKEPROFILE") {
					message("Lỗi, bạn chưa tạo hồ sơ nhà thầu! Đang chuyển đến trang tạo hồ sơ...",0);
					setTimeout("redirectMakeProfile()",redirect_time);
					return;
				}
				if(data == AJAX_DONE) {
					message("Gửi hồ sơ thầu thành công! Đang chuyển trang...",1);
					setTimeout("redirectPage()",redirect_time);
				} else if(data == AJAX_ERROR_WRONGFORMAT) {
					message("Upload file sai định dạng!",0);
				} else {
					message("Có lỗi xảy ra, vui lòng thử lại!",0);
				}
			},
			error : function(data) {
				$('#btsubmit').removeAttr('disabled');
				alert(data);
			}
		}; 
		// pass options to ajaxForm 
		$('#formHosothau').ajaxForm(options);
		$("#content_title").css("width",width_content-19);
		$("#content_title").text("Gửi hồ sơ thầu");
		$("input:submit, input:button", "body").button();
		boundTip("hosothau_milestone","Ví dụ : Nếu bạn đặt milestone là 50%, khi bạn hoàn thành được 50% dự án đó, chủ dự án sẽ chi trả 50% số tiền cho bạn");
		boundTip("tip_thoigian","Nhập số ngày bạn sẽ hoàn thành dự án.");
		boundTip("tip_giathau","Nhập số tiền (VNĐ) bạn sẽ thầu dự án này, với giá thầu và thời gian hợp lý, bạn sẽ có nhiều cơ hội được chủ dự án lựa chọn");
		boundTip("tip_loinhan","Số điện thoại và email của bạn (khi đăng ký tài khoản) sẽ được chủ dự án sử dụng để liên lạc với bạn <span style='color:red'>nếu bạn được trúng thầu</span>, vui lòng không điền số điện thoại và email của bạn trong phần thông tin mô tả bên dưới!",500);
	});
</script>
