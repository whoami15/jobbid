<style type="text/css">
#tipmsg {
	padding-left:10px;
	color:white !important;
	font-size: 10pt !important;
}
</style>
<div id="content" style="width:100%;">
	<div class="ui-widget-header ui-helper-clearfix ui-corner-top" style="border:none;padding-left: 5px" id="content_title"></div>
	<fieldset style="margin-bottom: 10px; margin-top: 10px; text-align: center;">
		<legend><span style="font-weight:bold;"><?php echo $dataRaovat["raovat"]["tieude"] ?></span></legend>
		<table class="center" width="100%">
			<thead>
				<tr>
					<td colspan="4" id="msg" align="left">
					</td>
				</tr>
			</thead>
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
	$(document).ready(function() {
		$("#content_title").html("Rao Vặt");
		menuid = '#dang-tin-rao-vat';
		$("#menu "+menuid).addClass("current");
		$("input:submit, input:button", "body").button();
	});
</script>
