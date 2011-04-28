<table width="100%">
	<thead>
		<tr id="thead_paging">
			<td colspan="11" align="center" style="color:black">
				<div class="yt-uix-pager">
					<?php
					if($pagesbefore>1)
						echo '<button onclick="selectpage(1)" type="button" class=" yt-uix-button" ><span class="yt-uix-button-content">1</span></button> ...';
					while($pagesbefore<$pagesindex) {
						echo "<button onclick='selectpage($pagesbefore)' type='button' class=' yt-uix-button' ><span class='yt-uix-button-content'>$pagesbefore</span></button>";
						$pagesbefore++;
					}
					echo "<button type='button' class='yt-uix-pager-selected yt-uix-button' ><span class='yt-uix-button-content'>$pagesindex</span></button>";
					while($pagesnext>$pagesindex) {
						$pagesindex++;
						echo "<button onclick='selectpage($pagesindex)' type='button' class=' yt-uix-button' ><span class='yt-uix-button-content'>$pagesindex</span></button>";
					}
					if($pagesnext<$pageend)
						echo '... <button onclick="selectpage('.$pageend.')" type="button" class=" yt-uix-button" ><span class="yt-uix-button-content">'.$pageend.'</span></button>';
					?>
				</div>			
			</td>
		</tr>
		<tr class="ui-accordion-header ui-helper-reset ui-state-default ui-corner-all" style="font-weight:bold;height:20px;text-align:center;">
			<td>Tiêu đề</td>
			<td>Ngày post</td>
			<td>Ngày cập nhật</td>
			<td>Email</td>
			<td>Trạng thái</td>
			<td>Sửa</td>
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
				<td style="display:none"><?php echo $raovat["raovat"]["id"]?></td>
				<td align="left"><a class='link' href='<?php echo BASE_PATH."/raovat/view/".$raovat["raovat"]["id"]."/".$raovat["raovat"]["alias"] ?>'><?php echo $raovat["raovat"]["tieude"]?></a></td>
				<td align="center" ><?php echo $html->format_date($raovat["raovat"]["ngaypost"],'d/m/Y H:i:s') ?></td>
				<td align="center" ><?php echo $html->format_date($raovat["raovat"]["ngayupdate"],'d/m/Y H:i:s') ?></td>
				<td align="left"><?php  echo $raovat["raovat"]["raovat_email"] ?></td>
				<td align="center">
					<?php
					if($raovat["raovat"]["status"] == 1)
						echo 'Đang rao';
					else
						echo 'Đã ngưng';
					?>
				</td>
				<td align="center">
					<img style="cursor:pointer" onclick="editMyProject(<?php echo $raovat["raovat"]["id"]?>)" title="Sửa" alt="edit" src="<?php echo BASE_PATH ?>/public/images/icons/edit.png"/> 
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