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
			<td>ID</td>
			<td>Tiêu đề</td>
			<td>Account</td>
			<td>Email</td>
			<td>Số ĐT</td>
			<td width="40px">Status</td>
			<td width="40px">Xử lý</td>
		</tr>
	</thead>
	<tfoot>
		<tr id="tfoot_paging"></tr>
	</tfoot>
	<tbody>
		<?php
		$i=0;
		foreach($lstRaovat as $raovat) {
			$i++;
			if($i%2==0)
				echo "<tr class='alternateRow'>";
			else 
				echo "<tr class='normalRow'>";
			?>
				<td id="td_id" align="center"><?php echo $raovat["raovat"]["id"]?></td>
				<td id="td_tieude" align="left"><?php echo $raovat["raovat"]["tieude"]?></td>
				<td id="td_account" align="left"><?php echo $raovat["account"]["username"]?></td>
				<td id="td_email" align="left"><?php echo $raovat["raovat"]["raovat_email"]?></td>
				<td id="td_sodienthoai" align="left"><?php echo $raovat["raovat"]["raovat_sodienthoai"]?></td>
				<td id="td_alias" style="display:none"><?php echo $raovat["raovat"]["alias"]?></td>
				<td id="td_status" align="center">
					<?php 
					if($raovat["raovat"]["status"]==0) {
						echo "<div class='inactive' onclick='doActive(this)' title='Active'></div>";
					} else {
						echo "<div class='active' onclick='doUnActive(this)' title='Unactive'></div>";
					}
					?>
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