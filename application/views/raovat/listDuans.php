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
			<td>Tên dự án</td>
			<td>Lĩnh vực</td>
			<td>Người post</td>
			<td>Chủ dự án</td>
			<td>Prior</td>
			<td>Ngày Post</td>
			<td>Status</td>
			<td width="40px">Xử lý</td>
		</tr>
	</thead>
	<tfoot>
		<tr id="tfoot_paging"></tr>
	</tfoot>
	<tbody>
		<?php
		$i=0;
		foreach($lstDuan as $duan) {
			$i++;
			if($i%2==0)
				echo "<tr class='alternateRow'>";
			else 
				echo "<tr class='normalRow'>";
			?>
				<td id="td_id" align="center"><?php echo $duan["duan"]["id"]?></td>
				<td id="td_tenduan" align="left"><?php echo $duan["duan"]["tenduan"]?></td>
				<td id="td_linhvuc_id" style="display:none"><?php echo $duan["duan"]["linhvuc_id"]?></td>
				<td id="td_linhvuc_display" align="left"><?php echo $duan["linhvuc"]["tenlinhvuc"]?></td>
				<td id="td_costtype" style="display:none"><?php  echo $html->FormatMoney($duan["duan"]["costmin"])?> &#8250 <?php  echo $html->FormatMoney($duan["duan"]["costmax"])?></td>
				<td id="td_account_id" style="display:none"><?php echo $duan["duan"]["account_id"]?></td>
				<td id="td_account_display" align="center"><?php echo $duan["account"]["username"]?></td>
				<td id="td_employer" align="center"><?php echo $duan["duan"]["duan_email"]?></td>
				<td id="td_prior" align="center"><?php echo $duan["duan"]["prior"]?></td>
				<td id="td_views" style="display:none"><?php echo $duan["duan"]["views"]?></td>
				<td id="td_ngaypost" align="left"><?php echo $html->format_date($duan["duan"]["ngaypost"],'d/m/Y H:i:s') ?></td>
				<td id="td_ngayketthuc" style="display:none"><?php echo $html->format_date($duan["duan"]["ngayketthuc"],'d/m/Y') ?></td>
				<td id="td_alias" style="display:none"><?php echo $duan["duan"]["alias"]?></td>
				<td id="td_tinh_id" style="display:none"><?php echo $duan["duan"]["tinh_id"]?></td>
				<td id="td_isbid" style="display:none"><?php echo $duan["duan"]["isbid"]?></td>
				<td id="td_active" align="center">
					<?php 
					if($duan["duan"]["active"]==0) {
						echo "<div class='inactive' onclick='doActive(this)' title='Active'></div>";
					} else if ($duan["duan"]["nhathau_id"] != null) {
						echo "<div class='closed'  title='Đã chọn nhà thầu'></div>";
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