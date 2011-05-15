<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/validator.js"></script>
<style type="text/css">
#tipmsg {
	padding-left:10px;
	color:white !important;
	font-size: 10pt !important;
}
.tdLabel {
	text-align:right;
	width:91px;
}
.tdInput {
	width:500px;
}
</style>
<div id="content" style="width:100%;">
	<div class="ui-widget-header ui-helper-clearfix ui-corner-top" style="border:none;padding-left: 5px" id="content_title"></div>
	<fieldset style="margin-bottom: 10px; margin-top: 10px; text-align: center;">
		<legend><span style="font-weight:bold;"><?php echo $dataRaovat["raovat"]["tieude"] ?></span></legend>
		<table class="center" width="100%">
			<tbody>
				<tr style="height:30px">
					<td width="50%" align="left" >
					<b>Trạng thái :</b> <?php echo $status ?>
					</td>
					<td width="50%" align="left" >
					<b>Ngày đăng :</b> <?php echo $html->format_date($dataRaovat["raovat"]["ngaypost"],'d/m/Y') ?>
					</td>
				</tr>
				<tr style="height:30px">
					<td align="left" >
					<b>Email:</b> <span style="color:red"><?php echo $dataRaovat["raovat"]["raovat_email"] ?></span>
					</td>
					<td align="left">
					<b>Số điện thoại :</b> <span style="color:red"><?php echo $dataRaovat["raovat"]["raovat_sodienthoai"] ?></span>
					</td>
				</tr>
				<tr style="height:30px">
					<td align="left" colspan="2">
					<b>Nội dung rao :</b>
					</td>
				</tr>
				<tr>
					<td align="left" colspan="2" style="padding-left:50px" class="viewcontent">
					<?php echo $dataRaovat["raovat"]["noidung"] ?>
					</td>
				</tr>
				<?php
					if($isEmployer == true) {
				?>
				<tr style="height:30px">
					<td align="center" colspan="2">
						<input id="btUptin" type="button" value="Up Tin" onclick="upraovat(<?php echo $dataRaovat["raovat"]["id"] ?>)"/>
						<input type="button" value="Sửa Tin" onclick="location.href='<?php echo BASE_PATH?>/raovat/edit/<?php echo $dataRaovat["raovat"]["id"]?>'"/>
					</td>
				</tr>
				<?php
					}
				?>
			</tbody>
		</table>
	</fieldset>
	<div id="binhluan" class="ui-widget-header ui-helper-clearfix" style="border:none;padding-left: 5px;margin-top:10px" id="content_title">BÌNH LUẬN</div>
	<div id="datagrid" style="padding:10px;">
	</div>
	<fieldset style="margin:5px">
	<legend>Ý kiến của bạn</legend>
	<center>
	<form id="sendComment">
	<input type="hidden" name="raovat_id" value="<?php echo $dataRaovat["raovat"]["id"]?>"/>
	<div class="divTable" style="width:100%">
		<div class="tr" style="border:none">
			<div class="td" id="msg"></div>
		</div>
		<div class="tr" style="border:none">
			<div class="td tdLabel" style="text-align:right;">Tên bạn (<span style="color:red;font-weight:bold;cursor:pointer;" title="Bắt buộc nhập dữ liệu">*</span>) :</div>
			<div class="td tdInput">
			<input type="text" name="raovatcomment_ten" style="width:60%" value="<?php echo $raovatcomment_ten?>" id="raovatcomment_ten" tabindex=1 />
			</div>
		</div>
		<div class="tr" style="border:none">
			<div class="td tdLabel" style="text-align:right;">URL :</div>
			<div class="td tdInput">
			<input type="text" name="raovatcomment_url" style="width:90%" value="<?php echo $raovatcomment_url?>" id="raovatcomment_url" tabindex=1 />
			</div>
		</div>
		<div class="tr" style="border:none;text-align:left">
			<div class="td">
			Nội dung (ít hơn 1500 từ) :<br/>
			<textarea  id="raovatcomment_noidung" name="raovatcomment_noidung" style="margin-top: 5px; width: 99%;" rows="5" tabindex=2></textarea>
			</div>
		</div>
		<div class="tr" style="border:none;text-align:left">
			<div class="td">
			<div id="image_security" style="width:100px;height:40px;padding-left:140px;float:left">
			<img alt="imgcaptcha" id="imgcaptcha" src="<?php echo BASE_PATH ?>/util/captcha&width=100&height=40&characters=5"/>
			</div>
			<div style="float:left">
			<img title="Load mã bảo vệ khác" onclick="reloadImageCaptcha()" style="cursor:pointer" alt="reload_capcha" src="<?php echo BASE_PATH ?>/public/images/icons/refresh_icon.png"/>
			</div>
			</div>
		</div>
		<div class="tr" style="border:none">
			<div class="td tdLabel" style="width: 135px;text-align:left;">Mã xác nhận (<span style="color:red;font-weight:bold;cursor:pointer;" title="Bắt buộc nhập dữ liệu">*</span>) :</div>
			<div class="td tdInput"><input id="security_code" name="security_code" type="text" style="width:200px"  tabindex="3"/></div>
		</div>
		<div class="tr" style="border:none">
			<div class="td">
			<input id="btsubmit" type="button" onclick="doSendComment()" value="Gửi ý kiến"  tabindex=6>
			</div>
		</div>
	</div>
	</form>
	</center>
	</fieldset>
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
	function upraovat(id) {
		if(id==null)
			return;
		$('#btUptin').attr('disabled','disabled');
		location.href = "#top";
		byId("msg").innerHTML="<div class='loading'><span class='bodytext' style='padding-left:30px;'>Đang xử lý...</span></div>";
		$.ajax({
			type : "GET",
			cache: false,
			url : url("/raovat/upraovat/"+id),
			success : function(data){	
				//alert(data);return;
				$('#btUptin').removeAttr('disabled');
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/account/login");
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
				if(data == "ERROR_DENIED") {
					message('Lỗi! Bạn không được phép up tin người khác!',0);
					return;
				}
				if(data == AJAX_DONE) {
					message("Bạn đã up tin rao thành công!",1);
				} else {
					message("Up tin rao không thành công!",0);
				}
				
			},
			error: function(data){ 
				$('#btUptin').removeAttr('disabled');
				alert (data);
			}			
		});
	}
	function reloadImageCaptcha() {
		byId("imgcaptcha").src = byId("imgcaptcha").src + '#';
		byId("security_code").value = "";
	}
	function loadComments(page) {
		block("#datagrid");
		$.ajax({
			type : "GET",
			cache: false,
			url: url("/raovat/comments/<?php echo $dataRaovat["raovat"]['id']?>/"+page),
			success : function(data){	
				unblock("#datagrid");
				$("#datagrid").html(data);
				
			},
			error: function(data){ 
				unblock("#datagrid");
				alert (data);
			}			
		});
	}
	function selectpage(page) {
		loadComments(page);
	}
	function doDeleteComment(_this,id) {
		if(!confirm("Bạn muốn xóa comment này?"))
			return;
		block("#datagrid");
		$.ajax({
			type : "GET",
			cache: false,
			url : url("/raovat/doDeleteComment&comment_id="+id),
			success : function(data){	
				unblock("#datagrid");
				if(data == AJAX_DONE) {
					$(_this.parentNode).remove();
				} else {
					message("Có lỗi xảy ra, vui lòng thử lại!",0);
				}
				
			},
			error: function(data){ 
				unblock("#datagrid");
				alert (data);
			}			
		});
	}
	function doSendComment() {
		location.href = "#sendComment";
		checkValidate=true;
		validate(['require'],'raovatcomment_ten',["Vui lòng nhập tên!"]);
		validate(['require'],'raovatcomment_noidung',["Vui lòng nhập nội dung!"]);
		validate(['require'],'security_code',["Vui lòng nhập 5 ký tự ở hình trên!"]);
		if(checkValidate==false) {
			return;
		}
		byId("msg").innerHTML="<div class='loading'><span class='bodytext' style='padding-left:30px;'>Đang xử lý...</span></div>";
		dataString = $("#sendComment").serialize();
		//alert(dataString);return;
		$('#btsubmit').attr('disabled','disabled');
		$.ajax({
			type : "POST",
			cache: false,
			url : url("/raovat/doSaveComment&"),
			data: dataString,
			success : function(data){	
				//alert(data);
				byId("msg").innerHTML="";
				$('#btsubmit').removeAttr('disabled');
				reloadImageCaptcha();
				if (data == AJAX_ERROR_SECURITY_CODE) {
					message('Sai mã xác nhận!',0);										
					byId("security_code").focus();
					$("#security_code").css('border-color','red');
					return;
				}
				if(data == AJAX_DONE) {
					raovatcomment_ten = byId("raovatcomment_ten").value;
					raovatcomment_url = byId("raovatcomment_url").value;
					$("#sendComment")[0].reset();
					byId("raovatcomment_ten").value = raovatcomment_ten;
					byId("raovatcomment_url").value = raovatcomment_url;
					loadComments(1);
					location.href = "#binhluan";
					//setTimeout("redirectPage()",redirect_time);
				} else {
					message("Có lỗi xảy ra, vui lòng thử lại!",0);
				}
				
			},
			error: function(data){ 
				$('#btsubmit').removeAttr('disabled');
				alert (data);
			}			
		});
	}
	$(document).ready(function() {
		$("#content_title").html("Rao Vặt");
		menuid = '#dang-tin-rao-vat';
		$("#menu "+menuid).addClass("current");
		$("input:submit, input:button", "body").button();
		loadComments(1);
	});
</script>
