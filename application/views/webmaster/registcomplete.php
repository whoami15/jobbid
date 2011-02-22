<div id="content" style="width:100%;">
	<div class="ui-widget-header ui-helper-clearfix ui-corner-top" style="border:none;padding-left: 5px" id="content_title">Bước 4: Hoàn tất đăng ký</div>
	<ul>
		<li>Nếu bạn là freelancer, bạn cần phải <span style="color:red;font-weight: bold;">Tạo Hồ Sơ</span> ứng viên để tham gia đấu thầu các dự án trên jobbid.vn.<br/> <span class="sample">(chủ dự án sẽ dựa vào hồ sơ ứng viên của bạn để quyết định có chọn bạn hay không)</span></li>
		<li style="padding-top:5px">Nếu bạn cần đăng dự án của bạn ngay bây giờ, vui lòng nhấn vào nút <span style="color:red;font-weight: bold;">Tạo Dự Án</span>.</li>
	</ul>
		<br/><br/>
		<center>
		<input id="btsubmit" type="button" value="Tạo Hồ Sơ" onclick="location.href=url('/nhathau/add')"/>
		<input id="btsubmit" type="button" value="Tạo Dự Án" onclick="location.href=url('/duan/add')"/>
		<input id="btsubmit" type="button" value="Bỏ Qua" onclick="location.href=url('/')"/>
		</center>
</div>
<script>
	$(document).ready(function() {
		$("input:submit, input:button", "body").button();
	});
</script>
