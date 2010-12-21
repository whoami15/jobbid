<div id="content" style="width:100%;">
	<div class="ui-widget-header ui-helper-clearfix ui-corner-all" style='text-align: left; padding-left: 10px; margin-left: -5px; width: 100%;' id="content_title">THÔNG BÁO</div>
	<fieldset style="margin-bottom: 10px; margin-top: 10px; text-align: center;">
		<legend><span style="font-weight:bold;">Thao tác thành công</span></legend>
		<div id="msg" style="text-align:left">
		<div class='positive' style='margin-top:5px;margin-bottom:5px'><span class='bodytext' style='padding-left:30px;'><?php echo $msg ?></span></div>
		</div>
	</fieldset>
</div>
<script>
	$(document).ready(function() {
		$("#content_title").css("width",width_content-19);
	});
</script>
