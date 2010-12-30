<div id="content" style="width:100%">
	<div class="ui-widget-header ui-helper-clearfix ui-corner-top" style="border:none;padding-left: 5px" id="content_title">Thông tin hồ sơ thầu</div>
	<div style="padding:10px">
	<form>
	<input type="hidden" id="duan_id" name="duan_id" value="<?php echo $duan_id ?>"/>
	<input type="hidden" id="hosothau_id" value="<?php echo $data['hosothau']['id'] ?>"/>
	</form>
	<table class="center" width="100%">
		<thead>
			<tr>
				<td colspan="4" id="msg">
				</td>
			</tr>
		</thead>
		<tbody>
			<tr height="30px">
				<td align="left" >
				<b>Nhà thầu :</b> <a class="link" target="_blank" href="<?php echo BASE_PATH ?>/nhathau/xem_ho_so/<?php echo $data['nhathau']["id"] ?>"><?php echo $data['nhathau']["displayname"] ?></a>
				</td>
			</tr>
			<tr height="30px">
				<td align="left" >
				<b>Giá thầu :</b> <?php echo $data['hosothau']['giathau'] ?>
				</td>
			</tr>
			<tr height="30px">
				<td align="left" >
				<b>Thời gian :</b> <?php echo $data['hosothau']['thoigian'] ?>
				</td>
			</tr>
			<tr height="30px">
				<td align="left" >
				<b>Milestone :</b> <?php echo $data['hosothau']['milestone'] ?>
				</td>
			</tr>
			<tr height="30px">
				<td align="left" >
				<b>Lời nhắn :</b> <?php echo $data['hosothau']['content'] ?>
				</td>
			</tr>
			<tr height="30px">
				<td align="left" >
				<b>Ngày gửi :</b> <?php  echo $html->format_date($data['hosothau']['ngaygui'],'d/m/Y H:i')?>
				</td>
			</tr>
			<tr height="30px">
				<td align="left"><b>Email :</b><span style="color:red"> <?php echo $data['hosothau']['hosothau_email']?></span>
				</td>	
			</tr>
			<tr height="30px">
				<td align="left"><b>Số điện thoại :</b><span style="color:red"> <?php echo $data['hosothau']['hosothau_sodienthoai']?></span>
				</td>
			</tr>
			<tr height="30px">
				<td align="center" height="50px">
					<?php
					if(!$flag)
						echo '<input id="btChonnhathau" onclick="doChonnhathau()" value="Chọn Nhà Thầu Này" type="button" tabindex="11">';
					?>
				</td>
			</tr>
		</tbody>
	</table>
	</div>
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
	function redirectPage() {
		location.reload(true);
	}
	function doChonnhathau() {
		location.href = "#top";
		duan_id = byId("duan_id").value;
		hosothau_id = byId("hosothau_id").value;
		if(hosothau_id==null || duan_id==null)
			return;
		$('#btChonnhathau').attr('disabled','disabled');
		byId("msg").innerHTML="<div class='loading'><span class='bodytext' style='padding-left:30px;'>Đang xử lý...</span></div>";
		$.ajax({
			type: "GET",
			cache: false,
			url : url("/hosothau/chonhoso&duan_id="+duan_id+"&hosothau_id="+hosothau_id),
			success: function(data){
				//alert(data);return;
				$('#btChonnhathau').removeAttr('disabled');	
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
				if(data == AJAX_DONE) {
					//Dang ky thanh cong	
					message('Chọn nhà thầu thành công! Đang chuyển trang...',1);
					setTimeout("redirectPage()",redirect_time);
				} else {
					message('Hệ thống đang bận, vui lòng thử lại sau!',0);
				}
			},
			error: function(data){ $('#btChonnhathau').removeAttr('disabled');alert (data);}	
		});
	}
	$(document).ready(function() {
		document.title = "<?php echo $data['nhathau']["displayname"] ?>";
		$("input:submit, input:button", "body").button();
	});
</script>
