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
			<td>Tên dự án</td>
			<td>Giá thầu</td>
			<td>Ngày gửi</td>
		</tr>
	</thead>
	<tfoot>
		<tr id="tfoot_paging"></tr>
	</tfoot>
	<tbody>
		<?php
		$i=0;
		foreach($lstHosthau as $hosothau) {
			$i++;
			if($i%2==0)
				echo "<tr class='alternateRow' height='30px'>";
			else 
				echo "<tr class='normalRow' height='30px'>";
			?>
				<td id="td_tenduan" align="left"><a class='link' href='<?php echo BASE_PATH."/duan/view/".$hosothau["duan"]["id"]."/".$hosothau["duan"]["alias"] ?>'><?php echo $hosothau["duan"]["tenduan"]?></a></td>
				<td align="center" ><?php echo $html->FormatMoney($hosothau["hosothau"]["giathau"])?> VNĐ</td>
				<td align="center" ><?php echo $html->format_date($hosothau["hosothau"]["ngaygui"],'d/m/Y H:i:s')?></td>
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