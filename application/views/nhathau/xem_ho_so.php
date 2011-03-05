<div id="content" style="width:100%">
	<div class="ui-widget-header ui-helper-clearfix ui-corner-top" style="border:none;padding-left: 5px" id="content_title">Thông tin ứng viên</div>
	<table class="center" width="100%">
		<tbody>
			<tr style="height:30px">
				<td align="center" colspan="2">
				<h2><?php echo $nhathau["displayname"] ?></h2> 
				</td>
			</tr>
			<tr style="height:30px">
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
			<tr style="height:30px">
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
			<tr style="height:30px">
				<td align="left" >
				<b><span id="display_gpkd_cmnd"></span> :</b> <?php echo $nhathau["gpkd_cmnd"] ?>
				</td>
			</tr>
			<tr style="height:30px">
				<td align="left" >
				<b><span id="display_birthyear"></span> :</b> <?php echo $nhathau["birthyear"] ?>
				</td>
			</tr>
			<tr style="height:30px">
				<td align="left" >
				<b><span id="display_diachilienhe"></span> :</b> <?php echo $nhathau["diachilienhe"] ?>
				</td>
			</tr>
			<tr style="height:30px">
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
			<tr style="height:30px">
				<td align="left" >
				<b><span id="display_file"></span> :</b> <a class="link" target="_blank" href="<?php echo BASE_PATH.'/file/download/'.$file["id"] ?>"><?php echo $file["filename"] ?></a>
				</td>
			</tr>
			<tr style="height:30px">
				<td align="left" >
				<b>Mô tả thêm :</b>
				</td>
			</tr>
			<tr style="height:30px">
				<td align="left" style="padding-left:50px">
				<?php echo $nhathau["motachitiet"] ?>
				</td>
			</tr>
			<tr style="height:30px">
				<td align="left">
				<b>Mời ứng viên này tham gia thầu dự án của bạn trên JobBid:</b><br/>
				<ul style='padding-left:15px;margin-left:15px' id="ul_myactivityproject">
					Hiện bạn chưa có dự án nào trên JobBid.vn, click chuột <a href="<?php echo BASE_PATH?>/duan/tao_du_an_buoc_1" class="link">vào đây</a> để tạo dự án mới cho bạn (<span style="color:red">hoàn toàn miễn phí</span>)
				</ul>
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
		<?php
		$i=0;
		foreach($lstDuanTrungThau as $duan) {
			$linkduan = BASE_PATH.'/duan/view/'.$duan['duan']['id'].'/'.$duan['duan']['alias'];
			$tenduan = $duan['duan']['tenduan'];
			echo "<li><a class='link' href='$linkduan'>$tenduan</a></li>";
			$i++;
		}
		if($i==0)
			echo 'Chưa có dự án nào.';
		?>
		</ul>
		</div>
</div>
<div id="dialogVerify" title="Xác Nhận Mời Thầu" style="text-align:left">
	<div id="msg"></div>
	Bạn muốn mời ứng viên <b><?php echo $nhathau["displayname"] ?></b> tham gia đấu thầu dự án <b><span id="xacnhanmoithau_tenduan"></span></b>?<br/><br/>
	<center>
	<form id="formMoithau">
	<input type="hidden" name="moithau_duan_id" id="moithau_duan_id" value="" />
	<input type="hidden" name="moithau_account_id" id="moithau_account_id" value="<?php echo $nhathau["account_id"] ?>" />
	<input id="btsubmit" type="button" value="Xác Nhận" onclick="saveMoithau()"/>
	<input type="button" value="Đóng" onclick="$('#dialogVerify').dialog('close')"/>
	</form>
	</center>
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
	function showDialogVerify(duan_id) {
		byId("msg").innerHTML = "";
		$('#btsubmit').removeAttr('disabled');
		byId("moithau_duan_id").value = duan_id;
		$("#xacnhanmoithau_tenduan").html(byId("moithau_"+duan_id).innerHTML);
		$("#dialogVerify").dialog("open");
	}
	function saveMoithau() {
		duan_id = byId("moithau_duan_id").value;
		account_id = byId("moithau_account_id").value;
		if(duan_id==null || account_id==null) {
			$("#dialogVerify").dialog("close");
			return;
		}
		$('#btsubmit').attr('disabled','disabled');
		byId("msg").innerHTML="<div class='loading'><span class='bodytext' style='padding-left:30px;'>Đang xử lý...</span></div>";
		$.ajax({
			type: "GET",
			cache: false,
			url : url("/nhathau/doAddMoiThau/"+account_id+"/"+duan_id),
			success: function(data){
				if(data == AJAX_ERROR_NOTLOGIN) {
					message("Lỗi! Bạn chưa đăng nhập!",0);
					return;
				}
				if(data == "ERROR_NOTACTIVE") {
					message("Lỗi! Tài khoản chưa được xác nhận!",0);
					return;
				}
				if(data == "ERROR_LOCKED") {
					message("Lỗi! Tài khoản này đã bị khóa!",0);
					return;
				}
				if(data == "ERROR_INVITED") {
					message("Bạn đã mời ứng viên này rồi!",0);
					return;
				}
				if(data == 'DONE') {
					message("Đã gửi thư mời thầu đến ứng viên này!",1);
				} else {
					$('#btsubmit').removeAttr('disabled');
					message("Hệ thống đang quá tải, vui lòng thử lại sau!",0);
				}
			},
			error: function(data){ $('#btsubmit').removeAttr('disabled');alert (data);}	
		});
	}
	$(document).ready(function() {
		//document.title = "Thông tin nhà thầu : <?php echo $nhathau["displayname"] ?>";
		changeType(<?php echo $nhathau["type"] ?>);
		$("input:submit, input:button", "body").button();
		$("#dialogVerify").dialog({
			autoOpen: false,
			minWidth: 500,
			modal: true,
			resizable :false
		});	
		block("#ul_myactivityproject");
		$.ajax({
			type: "GET",
			cache: false,
			url : url("/duan/lstMyActivityProject"),
			success: function(data){
				//alert(data);return;
				unblock("#ul_myactivityproject");
				if(data == AJAX_ERROR_NOTLOGIN) {
					$("#ul_myactivityproject").html("Vui lòng <a class='link' href='"+url('/account/login')+"'>đăng nhập</a> để hiển thị các dự án của bạn.");
					return;
				}
				if(data == "ERROR_NOTACTIVE") {
					$("#ul_myactivityproject").html("Lỗi! Tài khoản của bạn chưa được active.Vui lòng kiểm tra email để active tài khoản!");
					return;
				}
				if(data == "ERROR_LOCKED") {
					$("#ul_myactivityproject").html("Tài khoản này đã bị khóa, vui lòng liên hệ admin@jobbid.vn để mở lại!");
					return;
				}
				if(data != "NO_PROJECT") {
					$("#ul_myactivityproject").html(data);
				}
			},
			error: function(data){ unblock("#ul_myactivityproject");alert (data);}	
		});
	});
</script>
