<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/utils.js"></script>
<style type="text/css">
	.tdLabel {
		text-align:right;
		width:305px;
	}
</style>
<div id="content" style="width:100%;">
	<form id="formDuan" method="POST" action="<?php echo BASE_PATH?>/duan/tao_du_an_buoc_2/<?php echo $duan_id?>" style="padding-top: 0px; padding-bottom: 10px;" >
	<div class="ui-widget-header ui-helper-clearfix ui-corner-top" style="border:none;padding-left: 5px" id="content_title">Tạo dự án - Bước 1</div>
		<center>
		<div class="divTable" style="width:100%">
			<div class="tr" style="border:none">
				<div class="td tdLabel" style="text-align:right;">Chọn hình thức đấu thầu cho dự án của bạn:</div>
				<div class="td tdInput">
				<span id="tip_freebid"><input type="radio" name="duan_isbid" id="duan_isbid" value="1" /> Đấu thầu tự do.</span><br/>
				<span id="tip_directcontact"><input type="radio" name="duan_isbid" id="duan_isbid" value="0"/> Liên hệ trực tiếp.</span>
				</div>
			</div>
			<div class="tr" style="border:none">
				<div class="td">
				<input id="btsubmit" type="submit" value="Qua Bước 2"  tabindex=9>
				</div>
			</div>
		</div>
		</center>
	</form>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		//document.title = "Tạo Dự Án - "+document.title;
		setCheckedValue(document.forms['formDuan'].elements['duan_isbid'], <?php echo $isbid ?>);
		$("#tfoot_paging").html($("#thead_paging").html());
		menuid = '#tao-du-an';
		$("#menu "+menuid).addClass("current");
		$("input:submit, input:button", "body").button();
		boundTip("tip_freebid","Cho phép các ứng viên đưa ra giá thầu và thời gian để thực hiện dự án này, từ đó bạn có thể lựa chọn ra ứng viên tốt nhất cho dự án của bạn. (thông tin liên lạc của bạn chỉ hiển thị đối với ứng viên nào trúng thầu dự án của bạn)",400,"hover");
		boundTip("tip_directcontact","Thông tin liên hệ của bạn sẽ được hiển thị để các ứng viên liên hệ trực tiếp với bạn. (chức năng đấu thầu sẽ không còn nếu bạn chọn hình thức này)",400,"hover");

	});
</script>
