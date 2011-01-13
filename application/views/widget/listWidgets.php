<table width="100%">
	<thead>
		<tr class="ui-accordion-header ui-helper-reset ui-state-default ui-corner-all" style="font-weight:bold;height:20px;text-align:center;">
			<td style="width:20px">#</td>
			<td>Tên widget</td>
			<td>Vị trí</td>
			<td style="width:50px">Thứ tự</td>
			<td style="width:50px">Title</td>
			<td style="width:50px">Component</td>
			<td style="width:50px">Active</td>
			<td style="width:50px">Xử lý</td>
		</tr>
	</thead>
	<tbody>
		<?php
		$i=0;
		foreach($lstWidgets as $widget) {
			$i++;
			if($i%2==0)
				echo "<tr class='alternateRow'>";
			else 
				echo "<tr class='normalRow'>";
			?>
				<td align="center"><?php echo $i?></td>
				<td id="td_name" align="left"><?php echo $widget["widget"]["name"]?></td>
				<td id="td_position" align="left"><?php echo $widget["widget"]["position"]?></td>
				<td id="td_order" align="center"><?php echo $widget["widget"]["order"]?></td>
				<td id="td_showtitle" align="center">
					<?php 
					if($widget["widget"]["showtitle"]==1) {
						echo "Y";
					} else {
						echo "N";
					}
					?>
				</td>
				<td id="td_iscomponent" align="center">
					<?php 
					if($widget["widget"]["iscomponent"]==1) {
						echo "Y";
					} else {
						echo "N";
					}
					?>
				</td>
				<td id="td_active" align="center">
					<?php 
					if($widget["widget"]["active"]==0) {
						echo "<div class='inactive' onclick='doActive(this)' title='Active Widget này'></div>";
					} else {
						echo "<div class='active' onclick='doUnActive(this)' title='Bỏ Active Widget này'></div>";
					}
					?>
				</td>
				<td id="td_id" style="display:none;"><?php echo $widget["widget"]["id"]?></td>
				<td align="center">
					<input type="button" onclick="select_row(this)" value="Chọn" />
				</td>
			</tr>
			<?php
		}
		?>
	</tbody>
</table>