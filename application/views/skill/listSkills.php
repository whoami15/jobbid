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
			<td>Tên Skill</td>
			<td>Lĩnh vực</td>
			<td style="width:50px">Xử lý</td>
		</tr>
	</thead>
	<tfoot>
		<tr id="tfoot_paging"></tr>
	</tfoot>
	<tbody>
		<?php
		$i=0;
		foreach($lstSkills as $skill) {
			$i++;
			if($i%2==0)
				echo "<tr class='alternateRow'>";
			else 
				echo "<tr class='normalRow'>";
			?>
				<td align="center"><?php echo $i?></td>
				<td id="td_skillname" align="left"><?php echo $skill["skill"]["skillname"]?></td>
				<td id="td_linhvuc_id" style="display:none;"><?php echo $skill["skill"]["linhvuc_id"]?></td>
				<td id="td_linhvuc_display" align="left"><?php echo $skill["linhvuc"]["tenlinhvuc"]?></td>
				<td id="td_id" style="display:none;"><?php echo $skill["skill"]["id"]?></td>
				<td align="center">
					<img style="cursor:pointer" onclick="select_row(this)" title="Chỉnh sửa" alt="edit" src="<?php echo BASE_PATH ?>/public/images/icons/edit.png"/> 
					<img style="cursor:pointer" onclick="deleteSkill(this)" title="Xóa" alt="remove" src="<?php echo BASE_PATH ?>/public/images/icons/remove.png"/> 
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