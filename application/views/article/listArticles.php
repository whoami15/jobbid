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
			<td>Tiêu đề</td>
			<td>Ngày cập nhật</td>
			<td>Người cập nhật</td>
			<td width="30px">Xem</td>
			<td>Active</td>
			<td width="40px">Xử lý</td>
		</tr>
	</thead>
	<tfoot>
		<tr id="tfoot_paging"></tr>
	</tfoot>
	<tbody>
		<?php
		$i=0;
		foreach($lstArticles as $article) {
			$i++;
			if($i%2==0)
				echo "<tr class='alternateRow'>";
			else 
				echo "<tr class='normalRow'>";
			?>
				<td align="center"><?php echo $i?></td>
				<td id="td_title" align="left"><?php echo $article["article"]["title"]?></td>
				<td id="td_datemodified" align="left"><?php  echo $html->format_date($article["article"]["datemodified"],'d/m/Y H:i:s')?></td>
				<td id="td_usermodified" align="left"><?php echo $article["article"]["usermodified"]?></td>
				<td id="td_viewcount" align="center"><?php echo $article["article"]["viewcount"]?></td>
				<td id="td_active" align="center">
					<?php 
					if($article["article"]["active"]==0) {
						echo "<div class='inactive' onclick='doActive(this)' title='Active Page này'></div>";
					} else {
						echo "<div class='active' onclick='doUnActive(this)' title='Bỏ Active Page này'></div>";
					}
					?>
				</td>
				<td id="td_id" style="display:none;"><?php echo $article["article"]["id"]?></td>
				<td id="td_alias" style="display:none;"><?php echo $article["article"]["alias"]?></td>
				<td id="td_imagedes" style="display:none;"><?php echo $article["article"]["imagedes"]?></td>
				<td id="td_contentdes" style="display:none;"><?php echo $article["article"]["contentdes"]?></td>
				<td align="center">
					<input type="button" onclick="select_row(this)" value="Chọn" />
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