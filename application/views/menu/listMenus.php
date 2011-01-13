<table width="100%">
	<thead>
		<tr class="ui-accordion-header ui-helper-reset ui-state-default ui-corner-all" style="font-weight:bold;height:20px;text-align:center;">
			<td style="width:60px">ID Menu</td>
			<td>Tên Menu</td>
			<td>URL</td>
			<td>Thứ tự</td>
			<td>Active</td>
			<td style="width:40px">Xử lý</td>
		</tr>
	</thead>
	<tbody>
		<?php
		$i=0;
		foreach($lstMenus as $menu) {
			$i++;
			if($i%2==0)
				echo "<tr class='alternateRow'>";
			else 
				echo "<tr class='normalRow'>";
			?>
				<td id="td_id" align="center"><?php echo $menu["menu"]["id"]?></td>
				<td id="td_name" align="left"><?php echo $menu["menu"]["name"]?></td>
				<td id="td_url" align="left"><?php echo $menu["menu"]["url"]?></td>
				<td id="td_order" align="center"><?php echo $menu["menu"]["order"]?></td>
				<td id="td_active" align="center">
					<?php 
					if($menu["menu"]["active"]==0) {
						echo "<div class='inactive' onclick='doActive(this)' title='Active Menu này'></div>";
					} else {
						echo "<div class='active' onclick='doUnActive(this)' title='Bỏ Active Menu này'></div>";
					}
					?>
				</td>
				<td align="center">
					<input type="button" onclick="select_row(this)" value="Chọn" />
				</td>
			</tr>
			<?php
		}
		?>
	</tbody>
</table>