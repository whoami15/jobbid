<style>
	.tdLabel {
		text-align:right;
		width:130px;
	}
</style>
<div id="content" style="width:100%;">
	<div class="ui-widget-header ui-helper-clearfix ui-corner-all" style='text-align: left; padding-left: 10px; margin-left: -5px; width: 100%;' id="content_title">Kích hoạt tài khoản</div>
	<div style="width:100%">
	<center>
	<div class="divTable" style="width:100%">
		<div class="tr" style="border:none">
			<div class="td" id="msg"></div>
		</div>
		<div class="tr" style="border:none">
			<div class="td tdLabel" style="text-align:right;">Nhập Active Code :</div>
			<div class="td tdInput">
			<input type="text" name="active_code" id="active_code" style="width:50%" value="" tabindex=1/>&nbsp;&nbsp;<input id="btsubmit" type="button" value="Active" >
			</div>
		</div>
		<div class="tr" style="border:none;text-align:left">
			<div class="td">
			<a class="link" href="#">Bạn không nhận được mail kích hoạt?</a>
			</div>
		</div>
	</div>
	</center>
	</div>
</div>
<script>
	$(document).ready(function() {
		$("#content_title").css("width",width_content-19);
		$("input:submit, input:button", "body").button();
	});
</script>
