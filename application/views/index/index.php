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
	<div class="ui-widget-header ui-helper-clearfix ui-corner-top" style="border:none;padding-left: 5px" id="content_title">Các dự án mới nhất</div>
	<div id="datagrid" style="padding-top:10px;padding-bottom:10px;">
		<table width="100%">
			<thead>
				<tr class="ui-accordion-header ui-helper-reset ui-state-default ui-corner-all" style="font-weight:bold;height:20px;text-align:center;">
					<td>Tên dự án</td>
					<td>Giá thầu TB</td>
					<td>Bid</td>
					<td>Lĩnh vực</td>
					<td>Ngày bắt đầu</td>
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
	<?php
	foreach($lstLinhvuc as $e) {
		echo "<div class='divfloat1'><a href='".BASE_PATH."/linhvuc&linhvuc_id=".$e["linhvuc"]["id"]."' class='link'>".$e["linhvuc"]["tenlinhvuc"]."</a> (".$e["linhvuc"]["soduan"].")</div>";
	}
	?>
</div>
<script>
	$(document).ready(function() {
		menuid = '#home';
		$("#menu "+menuid).addClass("current");
	});
</script>