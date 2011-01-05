<div id="content" style="width:100%;">
	<div class="ui-widget-header ui-helper-clearfix ui-corner-top" style="border:none;padding-left: 5px" id="content_title">THÔNG BÁO</div>
	<fieldset style="margin-bottom: 10px; margin-top: 10px; text-align: center;">
		<legend><span style="font-weight:bold;">Thao tác thành công</span></legend>
		<div id="msg" style="text-align:left">
		<div class='positive' style='margin-top:5px;margin-bottom:5px'><span class='bodytext' style='padding-left:30px;'>Đã xác nhận tài khoản thành công!</span></div>
		</div>
	</fieldset>
</div>
<div id="dialogHelp" title="Hướng Dẫn Thành Viên Mới" style="text-align:left">
	+ Nếu bạn là nhà thầu muốn tham gia đấu thầu các dự án trên JobBid, vui lòng nhấn vào nút <span style="color:red;font-weight: bold;">Tạo Hồ Sơ Thầu</span>.<br/><br/>
	+ Nếu bạn là chủ dự án muốn post dự án ngay bây giờ, vui lòng nhấn vào nút <span style="color:red;font-weight: bold;">Tạo Dự Án</span>.
	<br/><br/>
	<center>
	<input id="btsubmit" type="button" value="Tạo Hồ Sơ Thầu" onclick="location.href=url('/nhathau/add')"/>
	<input id="btsubmit" type="button" value="Tạo Dự Án" onclick="location.href=url('/duan/add')"/>
	</center>
</div>
<script>
	$(document).ready(function() {
		$("#dialogHelp").dialog({
			autoOpen: true,
			minWidth: 500,
			modal: true,
			resizable :false,
		});	
		$("input:submit, input:button", "body").button();
	});
</script>
