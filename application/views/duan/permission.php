<div id="content" style="width:100%;">
	<div class="ui-widget-header ui-helper-clearfix ui-corner-top" style="border:none;padding-left: 5px" id="content_title">THÔNG BÁO</div>
	<div id="msg" style="text-align:left">
	<div class='positive' style='margin-top:5px;margin-bottom:5px'><span class='bodytext' style='padding-left:30px;'>Bạn đã xác nhận đồng ý đăng dự án lên JobBid.vn thành công!</span></div><br/>
	Đang chuyển đến trang dự án của bạn...
	</div>
</div>
<script>
	function redirectViewProject() {
		location.href = "<?php echo $linkview ?>";
	}
	$(document).ready(function() {
		setTimeout("redirectViewProject()",redirect_time);
	});
</script>
