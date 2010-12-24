<table width="100%">
	<thead>
		<tr id="thead_paging">
			<td colspan="11" align="center" bgcolor="white" style="color:black">
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
			<td width="20px">#</td>
			<td>Dự án</td>
			<td>Giá thầu</td>
			<td>Thời gian</td>
			<td>Ngày gửi</td>
		</tr>
	</thead>
	<tfoot>
		<tr id="tfoot_paging"></tr>
	</tfoot>
	<tbody>
		<?php
		$i=0;
		foreach($lstHosothau as $hosothau) {
			$i++;
			if($i%2==0)
				echo '<tr class="alternateRow" style="cursor:pointer" onclick="select_row(this)">';
			else 
				echo '<tr class="normalRow" style="cursor:pointer" onclick="select_row(this)">';
			?>
				<td align="center"><?php echo $i?></td>
				<td ><?php echo $hosothau["duan"]["tenduan"]?></td>
				<td id="td_id" style="display:none"><?php echo $hosothau["hosothau"]["id"]?></td>
				<td id="td_content" style="display:none"><?php echo $hosothau["hosothau"]["content"]?></td>
				<td id="td_giathau_display" align="center"><?php  echo $html->FormatMoney($hosothau["hosothau"]["giathau"])?> VNĐ</td>
				<td id="td_giathau" style="display:none"><?php  echo $hosothau["hosothau"]["giathau"]?></td>
				<td id="td_thoigian" align="center"><?php echo $hosothau["hosothau"]["thoigian"]?></td>
				<td align="center"><?php echo $html->format_date($hosothau["hosothau"]["ngaygui"],'d/m/Y H:m:s') ?></td>
				<td id="td_milestone" style="display:none"><?php echo $hosothau["hosothau"]["milestone"]?></td>
				<td id="td_trangthai" style="display:none"><?php echo $hosothau["hosothau"]["trangthai"]?></td>
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