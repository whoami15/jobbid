<table width="100%">
	<thead>
		<tr id="thead_paging">
			<td colspan="11" align="center" style="color:black">
				<?php 
				if($pagesbefore>1)
					echo '<a class="link" style="padding-right:5px" href="#" onclick="selectpage(1)">1 ...</a>';
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
				if($pagesnext<$pageend)
					echo "<a class='link' style='padding-left:5px' href='#' onclick='selectpage($pageend)'>... $pageend</a>";
				?>
			</td>
		</tr>
		<tr class="ui-accordion-header ui-helper-reset ui-state-default ui-corner-all" style="font-weight:bold;height:20px;text-align:center;">
			<td>#</td>
			<td>Tên nhà thầu</td>
			<td style="width:100px">Đánh giá</td>
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
			echo ' style="cursor:pointer" onclick="location.href=\''.BASE_PATH.'/nhathau/xem_ho_so/'.$nhathau["nhathau"]["id"].'\'" >';
			?>
				<td align="center"><?php echo $i ?></td>
				<td align="left"><a class='link' href='<?php echo BASE_PATH ?>/nhathau/xem_ho_so/<?php echo $nhathau["nhathau"]["id"].'/'.$nhathau["nhathau"]['nhathau_alias'] ?>'><?php echo $nhathau["nhathau"]["displayname"]?></a></td>
				<td align="left" style="width:100px">
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