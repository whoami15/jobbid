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
			<td style="width:20px">#</td>
			<td>Username</td>
			<td>Tên hiển thị</td>
			<td>GPKD(CMND)</td>
			<td style="width:50px">Point</td>
			<td style="width:85px">Nhận Email</td>
			<td style="width:85px">Lĩnh vực</td>
			<td style="width:40px">Xử lý</td>
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
				echo "<tr class='alternateRow'>";
			else 
				echo "<tr class='normalRow'>";
			?>
				<td align="center"><?php echo $i?></td>
				<td id="td_id" style="display:none"><?php echo $nhathau["nhathau"]["id"]?></td>
				<td id="td_account_id" style="display:none"><?php echo $nhathau["account"]["id"]?></td>
				<td id="td_type" style="display:none"><?php echo $nhathau["nhathau"]["type"]?></td>
				<td id="td_username" align="center"><?php echo $nhathau["account"]["username"]?></td>
				<td id="td_displayname" align="left"><?php echo $nhathau["nhathau"]["displayname"]?></td>
				<td id="td_gpkd_cmnd" align="center"><?php echo $nhathau["nhathau"]["gpkd_cmnd"]?></td>
				<td id="td_diemdanhgia" align="center"><?php echo $nhathau["nhathau"]["diemdanhgia"]?></td>
				<td id="td_nhanemail" align="center"><?php echo $nhathau["nhathau"]["nhanemail"]==1?"Y":"N"?></td>
				<td align="center">
					<input type="button" onclick="showLinhvucquantam('<?php echo $nhathau["nhathau"]["id"]?>')" value="Xem" />
				</td>
				<td align="center">
					<img style="cursor:pointer" onclick="select_row(this)" title="Chỉnh sửa" alt="edit" src="<?php echo BASE_PATH ?>/public/images/icons/edit.png"/>
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