<div id="content" style="width:100%">
	<div class="ui-widget-header ui-helper-clearfix ui-corner-all" style='text-align: left; padding-left: 10px; margin-left: -5px; width: 100%;' id="content_title"></div>
	<input type="hidden" id="duan_id" value="<?php echo $duan["id"] ?>"/>
	<input type="hidden" id="hosothau_id" value="<?php echo $hosothau_id ?>"/>
	<fieldset style="margin-top:10px">
		<legend>Thông tin nhà thầu</legend>
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
					<span style="float:left;padding-right:10px"> <b>BidJob đánh giá :</b></span>
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
			</tbody>
		</table>
	</fieldset>
	<fieldset style="margin-bottom: 10px; margin-top: 10px;">
		<legend>Các dự án đã hoàn thành trên BidJob</legend>
		<div style="min-height:30px;width:100%">
		<ul id="">
		Chưa có dự án nào.
		</ul>
		</div>
	</fieldset>
	<fieldset style="margin-bottom: 10px; margin-top: 10px;">
		<legend>Các dự án vừa trúng thầu</legend>
		<div id="div_lstDuans" style="min-height:50px;width:100%">
		<ul id="ul_lstDuans">
		
		</ul>
		</div>
	</fieldset>
	<fieldset style="margin-bottom: 10px; margin-top: 10px;">
		<legend>Thông tin cá nhân</legend>
		<?php
		if(isset($_SESSION["user"])) {
			if($flag>0) {
			?>
			<form id="formAccount" style="padding-top: 10px; padding-bottom: 10px;">
			<table class="center" width="500px">
				<tbody>
					<tr height="30px">
						<td width="150px" align="right"><b>Username :</b></td>
						<td align="left">
							<a href="#" class="link"><?php echo $account["username"]?></a>
						</td>
					</tr>
					<tr height="30px">
						<td align="right"><b>Họ tên :</b></td>
						<td align="left">
							<?php echo $account["hoten"]?>
						</td>
					</tr>
					<tr height="30px">	
						<td align="right"><b>Ngày sinh :</b></td>
						<td align="left">
							<?php echo $html->format_date($account["ngaysinh"],'d/m/Y')?>
						</td>
					</tr>
					<tr height="30px">
						<td align="right"><b>Địa chỉ :</b></td>
						<td align="left">
							<?php echo $account["diachi"]?>
						</td>	
					</tr>
					<tr height="30px">
						<td align="right"><b>Email :</b></td>
						<td align="left">
							<?php echo $account["email"]?>
						</td>	
					</tr>
					<tr height="30px">
						<td align="right"><b>Số điện thoại :</b></td>
						<td align="left">
							<?php echo $account["sodienthoai"]?>
						</td>
					</tr>
					<tr height="30px">
						<td colspan="4" align="center" height="50px">
							<?php
							if($flag > 1) {
								?>
								<input id="btChonnhathau" onclick="doChonnhathau()" value="Chọn Nhà Thầu Này" type="button" tabindex="11">
								<?php
							} 
							?>
						</td>
					</tr>
				</tbody>
			</table>
			</form>
			<?php
			} else {
				echo '<div style="text-align:center">Bạn chỉ được xem thông tin cá nhân nhà thầu này khi người này tham gia đấu thầu dự án của bạn.</div>';
			}
		} else {
			?>
			<div style="text-align:center">Vui lòng <a class="link" href="<?php echo BASE_PATH ?>/account/login">đăng nhập</a> để xem thông tin cá nhân của nhà thầu này</div>
			<?php
		}
		?>
	</fieldset>
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
	var display_file = '';
	function changeType(value) {
		if(value == 1) {
			display_gpkd_cmnd = "Số CMND";
			display_file = "File mô tả kinh nghiệm";
		} else {
			display_gpkd_cmnd = "Giấy phép kinh doanh";
			display_file = "File hồ sơ năng lực";
		}
		byId("display_gpkd_cmnd").innerHTML = display_gpkd_cmnd;
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
				$('#btChonnhathau').removeAttr('disabled');	
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/account/login");
					return;
				}
				if(data == "ERROR_FORBIDDEN") {
					message('Bạn không phải là chủ dự án này!',0);
					return;
				}
				if(data == AJAX_DONE) {
					//Dang ky thanh cong	
					message('Chọn nhà thầu thành công! Đang chuyển trang...',1);
					setTimeout("redirectPage()",redirect_time);
				} else {
					message('Thao tác bị lỗi, vui lòng thử lại!',0);
				}
			},
			error: function(data){ $('#btChonnhathau').removeAttr('disabled');alert (data);}	
		});
	}
	$(document).ready(function() {
		changeType(<?php echo $nhathau["type"] ?>);
		$("#content_title").css("width",width_content-19);
		$("#content_title").text("Xem Hồ Sơ Nhà Thầu");
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
