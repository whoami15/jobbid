<div id="content" style="width:100%;">
	<div class="ui-widget-header ui-helper-clearfix ui-corner-all" style='text-align: left; padding-left: 10px; margin-left: -5px; width: 100%;' id="content_title">Thông báo</div>
	<table width="99%" style="padding-top:10px;padding-bottom:10px">
		<tbody>
			<tr>
				<td align="left">
				<fieldset>
				<legend><span style="font-weight:bold">Thông báo từ website</span></legend>
				<div class='positive' style='margin-top:5px'><span class='bodytext' style='padding-left:30px;'>Bạn đã đăng ký thành viên thành công!</span></div><br/>
				Bạn có thể sử dụng nick <a class="link" href="<?php echo BASE_PATH ?>/account/login&username=<?php echo $_GET["username"] ?>"><?php echo $_GET["username"] ?></a> để đăng nhập vào tài khoản cá nhân của mình.
				</fieldset>
				</td>
			</tr>
		</tbody>
	</table>
</div>
<script>
	$(document).ready(function() {
		$("#content_title").css("width",width_content-19);
	});
</script>
