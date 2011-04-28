<div id="content" style="width:100%;">
	<div class="ui-widget-header ui-helper-clearfix ui-corner-top" style="border:none;padding-left: 5px" id="content_title">Thông báo</div>
	<table width="99%" style="padding-top:10px;padding-bottom:10px">
		<tbody>
			<tr>
				<td align="left">
				<fieldset>
				<legend><span style="font-weight:bold">Thông báo từ website</span></legend>
				<div class='positive' style='margin-top:5px'><span class='bodytext' style='padding-left:30px;'>Bạn đã đăng tin rao vặt thành công!</span></div><br/>
				Chúng tôi đã tạo cho bạn 1 tài khoản với tên đăng nhập là <span style="color:red;font-weight: bold;"><?php echo $_GET["email"] ?></span> và gửi 1 email xác nhận đến địa chỉ mail <a href="#" class="link"><?php echo $_GET["email"] ?></a>, vui lòng kiểm tra email (có thể nằm trong spam) để xác nhận tài khoản của bạn.<br/>
				<font color="red">Lưu ý : Tin rao này chỉ được đăng khi bạn đã xác nhận tài khoản.</font>
				</fieldset>
				</td>
			</tr>
		</tbody>
	</table>
</div>
<script>
	$(document).ready(function() {
	});
</script>
