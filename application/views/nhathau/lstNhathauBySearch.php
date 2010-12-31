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
			<td>Tên nhà thầu</td>
			<td width="100px">Đánh giá</td>
		</tr>
	</thead>
	<tfoot>
		<tr id="tfoot_paging"></tr>
	</tfoot>
	<tbody>
		<?php
		$i=0;
		foreach($lstNhathau as $nhathau) {
			$i++;
			if($i%2==0)
				echo "<tr class='alternateRow'";
			else 
				echo "<tr class='normalRow'";
			echo ' style="cursor:pointer" onclick="location.href=\''.BASE_PATH.'/nhathau/xem_ho_so/'.$nhathau["nhathau"]["id"].'\'" height="30px">';
			?>
				<td align="center"><?php echo $i ?></td>
				<td id="td_tennhathau" align="left"><a class='link' href='#'><?php echo $nhathau["nhathau"]["displayname"]?></a></td>
				<td align="left" width="100px">
					<div style="float: left;" id="ctl00_SampleContent_ThaiRating">
						<a style="text-decoration: none;" title="2" id="ctl00_SampleContent_ThaiRating_A" href="javascript:void(0)">
						<?php
						for($j=0;$j<$nhathau["nhathau"]["diemdanhgia"];$j++) {
							echo '<span style="float: left;" class="ratingStar filledRatingStar" id="ctl00_SampleContent_ThaiRating_Star_1">&nbsp;</span>';
						}
						?>
						</a>
					</div>
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