<div id="content" style="width:100%">
	<div class="ui-widget-header ui-helper-clearfix ui-corner-top" style="border:none;padding-left: 5px" id="content_title">Thông tin nhà thầu</div>
	<form>
	<input type="hidden" id="duan_id" name="duan_id" value="<?php echo $duan["id"] ?>"/>
	<input type="hidden" id="hosothau_id" value="<?php echo $hosothau_id ?>"/>
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
				<td align="center" colspan="2">
				<h2><?php echo $nhathau["displayname"] ?></h2> 
				</td>
			</tr>
			<tr height="30px">
				<td align="left" >
				<b>Đại diện cho :</b> 
				<?php 
				if($nhathau["type"]==1)
					echo 'Cá nhân';
				else
					echo 'Công ty';
				?>
				</td>
			</tr>
			<tr height="30px">
				<td align="left" >
				<span style="float:left;padding-right:10px"> <b>JobBid đánh giá :</b></span>
				<?php
				for($j=0;$j<$nhathau["diemdanhgia"];$j++) {
					echo '<span style="float:left" class="ratingStar filledRatingStar" id="ctl00_SampleContent_ThaiRating_Star_1">&nbsp;</span>';
				}
				if($nhathau["diemdanhgia"]>3) {
					echo "&nbsp;&nbsp;(Rất tốt)";
				} else if($nhathau["diemdanhgia"]>1) {
					echo "&nbsp;&nbsp;(Tốt)";
				} else if($nhathau["diemdanhgia"]>0){
					echo "&nbsp;&nbsp;(Khá)";
				} else {
					echo "(Chưa đánh giá)";
				}
				?>
				
				</td>
			</tr>
			<tr height="30px">
				<td align="left" >
				<b><span id="display_gpkd_cmnd"></span> :</b> <?php echo $nhathau["gpkd_cmnd"] ?>
				</td>
			</tr>
			<tr height="30px">
				<td align="left" >
				<b><span id="display_birthyear"></span> :</b> <?php echo $nhathau["birthyear"] ?>
				</td>
			</tr>
			<tr height="30px">
				<td align="left" >
				<b><span id="display_diachilienhe"></span> :</b> <?php echo $nhathau["diachilienhe"] ?>
				</td>
			</tr>
			<tr height="30px">
				<td align="left" >
				<b>Lĩnh vực :</b>
				</td>
			</tr>
			<tr align="left" >
				<td align="left" style="padding-left:50px">
				<?php 
				if(isset($lstLinhvucquantam)) {
					echo "<ul style='padding-left:15px'>";
					foreach($lstLinhvucquantam as $linhvuc) {
						echo "<li>".$linhvuc['linhvuc']['tenlinhvuc']."</li>";
					}
					echo "</ul>";
				}
				?>
				</td>
			</tr>
			<tr height="30px">
				<td align="left" >
				<b><span id="display_file"></span> :</b> <a class="link" target="_blank" href="<?php echo BASE_PATH.'/file/download/'.$file["id"] ?>"><?php echo $file["filename"] ?></a>
				</td>
			</tr>
			<tr height="30px">
				<td align="left" >
				<b>Mô tả thêm :</b>
				</td>
			</tr>
			<tr height="30px">
				<td align="left" style="padding-left:50px">
				<?php echo $nhathau["motachitiet"] ?>
				</td>
			</tr>
			<tr height="30px">
				<td align="left"><b>Email :</b><span style="color:red"> <?php echo $account["username"]?></span>
				</td>	
			</tr>
			<tr height="30px">
				<td align="left"><b>Số điện thoại :</b><span style="color:red"> <?php echo $account["sodienthoai"]?></span>
				</td>
			</tr>
			<tr height="30px">
				<td align="center" height="50px">
					<?php
					if($flag == true) {
						?>
						<input id="btChonnhathau" onclick="doChonnhathau()" value="Chọn Nhà Thầu Này" type="button" tabindex="11">
						<?php
					} 
					?>
				</td>
			</tr>
		</tbody>
	</table>
	<div class="ui-widget-header ui-helper-clearfix" style="border:none;padding-left: 5px;margin-top:10px" id="content_title">Các dự án đã hoàn thành trên JobBid</div>
		<div style="min-height:30px;width:100%">
		<ul id="">
		Chưa có dự án nào.
		</ul>
		</div>
	<div class="ui-widget-header ui-helper-clearfix" style="border:none;padding-left: 5px;margin-top:10px" id="content_title">Các dự án vừa trúng thầu</div>
		<div id="div_lstDuans" style="min-height:50px;width:100%">
		<ul id="ul_lstDuans">
		
		</ul>
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
	var display_gpkd_cmnd = '';
	var display_birthyear = '';
	var display_diachilienhe = '';
	var display_file = '';
	function changeType(value) {
		if(value==null)
			return;
		if(value == 1) {
			display_gpkd_cmnd = "Số CMND";
			display_birthyear = "Năm sinh";
			display_diachilienhe = "Địa chỉ liên hệ";
			display_file = "File mô tả kinh nghiệm";
		} else {
			display_gpkd_cmnd = "Giấy phép kinh doanh";
			display_birthyear = "Năm thành lập";
			display_diachilienhe = "Trụ sở chính";
			display_file = "File hồ sơ năng lực";
		}
		byId("display_gpkd_cmnd").innerHTML = display_gpkd_cmnd;
		byId("display_birthyear").innerHTML = display_birthyear;
		byId("display_diachilienhe").innerHTML = display_diachilienhe;
		byId("display_file").innerHTML = display_file;
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
		changeType(<?php echo $nhathau["type"] ?>);
		$("input:submit, input:button", "body").button();
		block("#div_lstDuans");
		$.ajax({
			type: "GET",
			cache: false,
			url : url("/duan/lstDuanByNhaThau&nhathau_id="+<?php echo $nhathau["id"] ?>),
			success: function(data){
				unblock("#div_lstDuans");
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/account/login");
					return;
				}
				if(data == AJAX_ERROR_SYSTEM) {
					message('Load danh sách dự án bị lỗi!',0);
					return;
				}
				byId("ul_lstDuans").innerHTML = "";
				var jsonObj = eval( "(" + data + ")" );
				var html = '';
				for(i=0;jsonObj[i]!=null;i++) {
					html += "<li><a class='link' href='"+url('/duan/view/'+jsonObj[i].id+'/'+jsonObj[i].alias)+"'>"+jsonObj[i].tenduan+"</a></li>";
				}
				if(html=='')
					html = 'Chưa có dự án nào.';
				$("#ul_lstDuans").append(html);
			},
			error: function(data){ unblock("#div_lstDuans");;alert (data);}	
		});
	});
</script>
