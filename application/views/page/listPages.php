<table width="100%">
	<thead>
		<tr class="ui-accordion-header ui-helper-reset ui-state-default ui-corner-all" style="font-weight:bold;height:20px;text-align:center;">
			<td width="20px">#</td>
			<td>Tiêu đề</td>
			<td>URL View</td>
			<td>Menu</td>
			<td width="110px">Ngày cập nhật</td>
			<td width="110px">Người cập nhật</td>
			<td>Active</td>
			<td width="40px">Xử lý</td>
		</tr>
	</thead>
	<tbody>
		<?php
		$i=0;
		foreach($lstPages as $page) {
			$i++;
			$urlview = BASE_PATH."/page/view/".$page["page"]["id"]."/".$page["page"]["alias"];
			if($i%2==0)
				echo "<tr class='alternateRow'>";
			else 
				echo "<tr class='normalRow'>";
			?>
				<td align="center"><?php echo $i?></td>
				<td id="td_title" align="left"><?php echo $page["page"]["title"]?></td>
				<td id="td_urlview" align="left"><?php echo $urlview ?></td>
				<td id="td_menu" align="left"><?php echo $page["page"]["menu_id"]?></td>
				<td id="td_datemodified" align="left"><?php  echo $html->format_date($page["page"]["datemodified"],'d/m/Y H:i:s')?></td>
				<td id="td_usermodified" align="left"><?php echo $page["page"]["usermodified"]?></td>
				<td id="td_active" align="center">
					<?php 
					if($page["page"]["active"]==0) {
						echo "<div class='inactive' onclick='doActive(this)' title='Active Page này'></div>";
					} else {
						echo "<div class='active' onclick='doUnActive(this)' title='Bỏ Active Page này'></div>";
					}
					?>
				</td>
				<td id="td_id" style="display:none;"><?php echo $page["page"]["id"]?></td>
				<td id="td_alias" style="display:none;"><?php echo $page["page"]["alias"]?></td>
				<td align="center">
					<input type="button" onclick="select_row(this)" value="Chọn" />
				</td>
			</tr>
			<?php
		}
		?>
	</tbody>
</table>