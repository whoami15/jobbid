<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/validator.js"></script>
<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/utils.js"></script>
<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/jHtmlArea-0.7.0.js"></script>
<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/jHtmlArea.ColorPickerMenu-0.7.0.js"></script>
<link href="<?php echo BASE_PATH ?>/public/css/front/jHtmlArea.css" rel="stylesheet" type="text/css" />
<link href="<?php echo BASE_PATH ?>/public/css/front/jHtmlArea.ColorPickerMenu.css" rel="stylesheet" type="text/css" />
<style type="text/css">
	.tdLabel {
		text-align:right;
		width:100px;
	}
	.tdInput {
		width:500px;
	}
</style>
<div id="content" style="width:100%;">
	<div class="ui-widget-header ui-helper-clearfix ui-corner-top" style="border:none;padding-left: 5px" id="content_title">Gửi hồ sơ thầu</div>
	<form id="formHosothau" style="padding-top: 10px; padding-bottom: 10px;" onsubmit="doSubmit(); return false;">
		<input type="hidden" name="hosothau_duan_id" id="hosothau_duan_id" value="<?php echo $dataDuan["duan"]["id"]?>" />
		<fieldset>
			<legend>
			<a class='link' href="<?php echo BASE_PATH ?>/duan/view/<?php echo $dataDuan["duan"]["id"]?>/<?php echo $dataDuan["duan"]["alias"]?>">Dự án : <b><?php echo $dataDuan["duan"]["tenduan"] ?></b></a></legend>
			<center>
			<div class="divTable" style="width:100%">
				<div class="tr" style="border:none">
					<div class="td" id="msg"></div>
				</div>
				<div class="tr" style="border:none">
					<div class="td tdLabel" style="text-align:right;">Giá thầu (<span style="color:red;font-weight:bold;cursor:pointer;" title="Bắt buộc nhập dữ liệu">*</span>) :</div>
					<div class="td tdInput">
					<input maxlength=10 type="text" name="hosothau_giathau" style="width:40%" value="" id="hosothau_giathau" tabindex=1 onkeyup="convertGiathau(this.value)"/><span id="txt_displaygiathau" style="padding-left: 20px; color: red; font-weight: bold;"></span> (VNĐ)
					</div>
				</div>
				<div class="tr" style="border:none">
					<div class="td tdLabel" style="text-align:right;">Thời gian (<span style="color:red;font-weight:bold;cursor:pointer;" title="Bắt buộc nhập dữ liệu">*</span>) :</div>
					<div class="td tdInput">
					<input maxlength=2 type="text" name="hosothau_thoigian" style="width:40%" value="" id="hosothau_thoigian" tabindex=2/>
					</div>
				</div>
				<div class="tr" style="border:none">
					<div class="td tdLabel" style="text-align:right;">MileStone :</div>
					<div class="td tdInput">
					<input type="text" name="hosothau_milestone" style="width:40%" value="" id="hosothau_milestone" tabindex=3/> (%)
					</div>
				</div>
				<div class="tr" style="border:none">
					<div class="td tdLabel" style="text-align:right;">Email :</div>
					<div class="td tdInput">
					<input type="text" id="hosothau_email" name="hosothau_email" style="width:70%" value="<?php echo $username ?>" tabindex=3/>
					</div>
				</div>
				<div class="tr" style="border:none">
					<div class="td tdLabel" style="text-align:right;">Số điện thoại :</div>
					<div class="td tdInput">
					<input type="text" id="hosothau_sodienthoai" name="hosothau_sodienthoai" style="width:70%" value="<?php echo $sodienthoai ?>" tabindex=3/>
					</div>
				</div>
				<div class="tr" style="border:none;text-align:left">
					<div class="td">
					Lời nhắn ( nhỏ hơn 1000 từ ) :<br/>
					<textarea  id="hosothau_content" name="hosothau_content" style="margin-top: 5px; width: 99%;" rows="5" tabindex=5></textarea>
					</div>
				</div>
				<div class="tr" style="border:none">
					<div class="td">
					<input id="btsubmit" type="submit" value="Gửi hồ sơ thầu"  tabindex=6>
					</div>
				</div>
			</div>
			</center>
		</fieldset>
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
	function doSubmit() {
		//alert(byId("hosothau_duan_id").value);return false;
		location.href = "#top";
		checkValidate=true;
		byId("hosothau_giathau").value = $.trim(byId("hosothau_giathau").value);
		byId("hosothau_thoigian").value = $.trim(byId("hosothau_thoigian").value);
		validate(['require','number'],'hosothau_giathau',["Vui lòng nhập giá thầu!","Vui lòng nhập kiểu số!"]);
		validate(['require','number'],'hosothau_thoigian',["Vui lòng nhập thời gian!","Vui lòng nhập kiểu số!"]);
		validate(['number'],'hosothau_milestone',["Vui lòng nhập kiểu số!"]);
		validate(['require','email'],'hosothau_email',["Vui lòng nhập email của bạn!","Email sai định dạng!"]);
		validate(['require'],'hosothau_sodienthoai',["Vui lòng nhập số điện thoại của bạn!"]);
		if(checkValidate==false) {
			return;
		}
		if(byId("hosothau_giathau").value == "0") {
			message("Giá thầu phải lớn hơn 0!",0);
			$("#hosothau_giathau").css('border-color','red');
			byId("hosothau_giathau").focus();
			return;
		}
		if(byId("hosothau_thoigian").value == "0") {
			message("Thời gian phải lớn hơn 0!",0);
			$("#hosothau_thoigian").css('border-color','red');
			byId("hosothau_thoigian").focus();
			return;
		}
		byId("msg").innerHTML="<div class='loading'><span class='bodytext' style='padding-left:30px;'>Đang xử lý...</span></div>";
		$('#btsubmit').attr('disabled','disabled');
		dataString = $("#formHosothau").serialize();
		$.ajax({
			type : "POST",
			cache: false,
			url : url("/hosothau/doPost&"),
			data: dataString,
			success : function(data){	
				//alert(data);
				$('#btsubmit').removeAttr('disabled');
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/account/login");
					return;
				}
				if(data == "ERROR_MAXLENGTH") {
					message('Lỗi! Lời nhắn phải ít hơn 1000 ký tự!',0);
					return;
				}
				if(data == "ERROR_NOTACTIVE") {
					message('Lỗi! Tài khoản của bạn chưa được active.Vui lòng kiểm tra email để active tài khoản!',0);
					return;
				}
				if(data == "ERROR_LOCKED") {
					message("Tài khoản này đã bị khóa, vui lòng liên hệ admin@jobbid.vn để mở lại!",0);
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
			error: function(data){ 
				$('#btsubmit').removeAttr('disabled');
				alert (data);
			}			
		});
		return;
	}
	function redirectPage() {
		location.href = url('/duan/view/<?php echo $dataDuan["duan"]["id"]."/".$dataDuan["duan"]["alias"] ?>');
	}
	function convertGiathau(value) {
		//alert(value);
		$("#txt_displaygiathau").html(FormatMoney(value));
	}
	function redirectMakeProfile() {
		location.href = url('/nhathau/add');
	}
	$(document).ready(function() {
		//document.title = "Gửi Hồ Sơ Thầu - "+document.title;
		$("input:submit, input:button", "body").button();
		boundTip("hosothau_milestone","Ví dụ : Nếu bạn đặt milestone là 50%, khi bạn hoàn thành được 50% dự án đó, chủ dự án sẽ chi trả 50% số tiền cho bạn");
		boundTip("hosothau_thoigian","Nhập số ngày bạn sẽ hoàn thành dự án.");
		boundTip("hosothau_giathau","Nhập số tiền (VNĐ) bạn sẽ thầu dự án này, với giá thầu và thời gian hợp lý, bạn sẽ có nhiều cơ hội được chủ dự án lựa chọn");
		boundTip("hosothau_email","Chủ dự án sẽ liên hệ với bạn qua email này nếu bạn thắng thầu.");
		boundTip("hosothau_sodienthoai","Chủ dự án sẽ liên hệ với bạn qua số điện thoại này nếu bạn thắng thầu.");
	});
</script>
