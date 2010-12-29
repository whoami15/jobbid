<style>
	.divfloat1 {
		float:left;
		padding:5px 5px 5px 15px;
		position:relative;
		width:46%;
		text-align: left;
	}
	
</style>
<div id="content" style="width:100%;">
	<div class="ui-widget-header ui-helper-clearfix ui-corner-top" style="border:none;padding-left: 5px;text-align:center" id="content_title">How it works!</div>
	<div style="padding:20px">
	<img alt="project" style="cursor:pointer" id="help_project" src="<?php echo BASE_PATH ?>/public/images/icons/project.png"/>
	<img alt="project" src="<?php echo BASE_PATH ?>/public/images/icons/arrow.png"/>
	<img alt="project" style="cursor:pointer" id="help_bid" src="<?php echo BASE_PATH ?>/public/images/icons/bid.png"/>
	<img alt="project" src="<?php echo BASE_PATH ?>/public/images/icons/arrow.png"/>
	<img alt="project" style="cursor:pointer" id="help_select" src="<?php echo BASE_PATH ?>/public/images/icons/select.png"/>
	<img alt="project" src="<?php echo BASE_PATH ?>/public/images/icons/arrow.png"/>
	<img alt="project" style="cursor:pointer" id="help_payment" src="<?php echo BASE_PATH ?>/public/images/icons/payment.png"/><br/>
	<ul>
		<li><a href="http://www.jobbid.vn" class="link">Jobbid.vn</a> là nơi tin cậy để bạn có thể gửi dự án đấu giá công khai, qua đó tìm được ứng viên thích hợp để thực hiện dự án của bạn.</li>
		<li>Thông qua trang web, các bạn có thể tìm kiếm được những công việc bán thời gian hoặc các dự án nhỏ phù hợp với khả năng mà bạn có thể hoàn thành một cách tốt nhất.</li>
		<li>Là nơi lưu trữ, chia sẻ những dự án nhỏ.</li>
		<li>Là kênh thông tin tuyển dụng uy tín.</li>
	</ul>
	</div>
	<div  class="ui-widget-header ui-helper-clearfix" style="border:none;padding-left: 5px;margin-top:5px" id="content_title2">Các dự án mới nhất</div>
	<div id="datagrid" style="padding-top:10px;padding-bottom:10px;">
		<table width="100%">
			<thead>
				<tr class="ui-accordion-header ui-helper-reset ui-state-default ui-corner-all" style="font-weight:bold;height:20px;text-align:center;">
					<td>Tên dự án</td>
					<td width="100px">Giá thầu TB</td>
					<td>Bid</td>
					<td>Lĩnh vực</td>
					<td width="100px">Ngày bắt đầu</td>
					<td width="100px">Còn</td>
				</tr>
			</thead>
			<tbody>
				<?php
				$i=0;
				foreach($lstData1 as $duan) {
					$i++;
					if($i%2==0)
						echo "<tr class='alternateRow' height='30px'>";
					else 
						echo "<tr class='normalRow' height='30px'>";
					?>
						<td id="td_id" style="display:none"><?php echo $duan["duan"]["id"]?></td>
						<td id="td_tenduan" align="left"><a class='link' href='<?php echo BASE_PATH."/duan/view/".$duan["duan"]["id"]."/".$duan["duan"]["alias"] ?>'><?php echo $duan["duan"]["tenduan"]?></a></td>
						<td align="center" ><?php echo $html->FormatMoney($duan["duan"]["averagecost"])?></td>
						<td align="center" ><?php echo $html->FormatMoney($duan["duan"]["bidcount"])?></td>
						<td id="td_linhvuc" align="center"><?php  echo $duan["linhvuc"]["tenlinhvuc"] ?></td>
						<td id="td_ngaypost" align="center"><?php  echo $html->format_date($duan["duan"]["ngaypost"],'d/m/Y')?></td>
						<td id="td_lefttime"align="center"><?php echo $html->getDaysFromSecond($duan["duan"]["active"]==1?$duan[""]["timeleft"]:0)?></td>
					</tr>
					<?php
				}
				?>
			</tbody>
		</table>
	</div>
	<div  class="ui-widget-header ui-helper-clearfix" style="border:none;padding-left: 5px" id="content_title2">Tìm dự án theo lĩnh vực</div>	
	<div style="padding-top: 5px; padding-bottom: 5px; position: relative; float: left;">
	<?php
	foreach($lstLinhvuc as $e) {
		echo "<div class='divfloat1'><a href='".BASE_PATH."/linhvuc&linhvuc_id=".$e["linhvuc"]["id"]."' class='link'>".$e["linhvuc"]["tenlinhvuc"]."</a> (".$e["linhvuc"]["soduan"].")</div>";
	}
	?>
	</div>
</div>
<script>
	$(document).ready(function() {
		menuid = '#home';
		$("#menu "+menuid).addClass("current");
		boundTip("help_project","Chủ dự án sẽ đưa dự án cần tìm kiếm nhà thầu lên jobbid.vn");
		boundTip("help_bid","Các nhà thầu sẽ đưa ra mức giá và thời gian để thực hiện dự án này, để có thể tham gia đấu thầu.<br/>Các nhà thầu cần tạo 1 bộ hồ sơ nhà thầu trên jobbid.vn để chủ dự án có thể xem và lựa chọn ra nhà thầu tốt nhất.");
		boundTip("help_select","Chủ dự án sẽ so sánh các nhà thầu đã tham gia đấu giá dự án của mình và chọn ra 1 nhà thầu ưng ý nhất.");
		boundTip("help_payment","Chủ dự án và nhà thầu sẽ liên hệ với nhau để thỏa thuận về việc thực hiện dự án và thanh toán.");
	});
</script>