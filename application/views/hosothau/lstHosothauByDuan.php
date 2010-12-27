<table width="100%">
	<thead>
		<tr id="thead_paging">
			<td colspan="11" align="center" style="color:black">
				<a class="link" style="padding-right:5px" href='#' onclick="selectpage(1)">Begin</a>
				<?php 
				while($pagesbefore<$pagesindex) {
					echo "<a class='link' href='#' onclick='selectpage($pagesbefore)'>$pagesbefore</a>";
					$pagesbefore++;
				}
				?>
				<span style="font-weight:bold;color:red"><?php echo $pagesindex ?></span>
				<?php 
				while($pagesnext>$pagesindex) {
					$pagesindex++;
					echo "<a class='link' href='#' onclick='selectpage($pagesindex)'>$pagesindex</a>";
				}
				?>
				<a class="link" style="padding-left:5px" href='#' onclick="selectpage(<?php echo $pageend ?>)">...<?php echo $pageend ?></a>			
			</td>
		</tr>
		<tr class="ui-accordion-header ui-helper-reset ui-state-default ui-corner-all" style="font-weight:bold;height:20px;text-align:center;">
			<td>#</td>
			<td>Nhà thầu</td>
			<td>Giá thầu</td>
			<td width="100px">Đánh giá</td>
		</tr>
	</thead>
	<tfoot>
		<tr id="tfoot_paging"></tr>
	</tfoot>
	<tbody id="tbodyhosothau">
		<?php
		$i=0;
		foreach($lstHosthau as $hosothau) {
			$i++;
			if($i%2==0)
				echo "<tr class='alternateRow' height='30px'>";
			else 
				echo "<tr class='normalRow' height='30px'>";
			?>
				<td rowspan="2"><?php echo $i ?></td>
				<td align="center"><a class='link' onmouseover='showinfo(this)' onmouseout="hidetip()" href='<?php echo BASE_PATH."/hosothau/xem_ho_so/".$hosothau["hosothau"]["id"]."/".$duan_id ?>'><?php echo $hosothau["nhathau"]["displayname"]?></a></td>
				<td align="center"><?php echo $html->FormatMoney($hosothau["hosothau"]["giathau"])?> VNĐ</td>
				<td id="td_milestone" style="display:none"><?php echo $hosothau["hosothau"]["milestone"]?> %</td>
				<td id="td_thoigian"  style="display:none"><?php echo $hosothau["hosothau"]["thoigian"]?> ngày</td>
				<td id="td_timeofbid" style="display:none"><?php echo $html->getDaysFromSecond($hosothau[""]["timeofbid"]) ?></td>
				<td id="td_id" style="display:none"><?php echo $hosothau["hosothau"]["id"] ?></td>
				<td align="left" width="100px">
				<div style="float: left;" id="ctl00_SampleContent_ThaiRating">
					<a style="text-decoration: none;" title="2" id="ctl00_SampleContent_ThaiRating_A" href="javascript:void(0)">
					<?php
					for($j=0;$j<$hosothau["nhathau"]["diemdanhgia"];$j++) {
						echo '<span style="float: left;" class="ratingStar filledRatingStar" id="ctl00_SampleContent_ThaiRating_Star_1">&nbsp;</span>';
					}
					?>
					</a>
				</div>
				</td>
			</tr>
			<?php
			if($i%2==0)
				echo "<tr class='alternateRow' height='30px'>";
			else 
				echo "<tr class='normalRow' height='30px'>";
			?>
				<td colspan="3" align="left">
					<span style="padding-left:5px"><?php echo $hosothau["hosothau"]["content"] ?></span>
				</td>
				</tr>
			<?php
		}
		?>
	</tbody>
</table>
<script>
	$(document).ready(function() {
		$("#tfoot_paging").html($("#thead_paging").html());
	});
</script>