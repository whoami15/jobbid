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
			<td>Username</td>
			<td>Họ tên</td>
			<td>Email</td>
			<td>Point</td>
			<td>Last Login</td>
			<td>Quyền</td>
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
		foreach($lstAccounts as $account) {
			$i++;
			if($i%2==0)
				echo "<tr class='alternateRow'>";
			else 
				echo "<tr class='normalRow'>";
			?>
				<td align="center"><?php echo $i?></td>
				<td id="td_username" align="left"><?php echo $account["account"]["username"]?></td>
				<td id="td_hoten" align="left"><?php echo $account["account"]["hoten"]?></td>
				<td id="td_email" align="left"><?php echo $account["account"]["email"]?></td>
				<td id="td_point" align="left"><?php echo $account["account"]["point"]?></td>
				<td id="td_lastlogin" align="left"><?php  echo $html->format_date($account["account"]["lastlogin"],'d/m/Y H:i:s')?></td>
				<td id="td_role" align="center">
				<?php 
					switch($account["account"]["role"]) {
						case 1:
							echo "Quản trị hệ thống";
							break;
						default:
							echo "Người dùng";
							break;
					}
				?>
				</td>
				<td id="td_active" style="display:none;"><?php echo $account["account"]["active"]?></td>
				<td id="td_active_display" align="center">
					<?php 
					if($account["account"]["active"]==0) {
						echo "<div class='inactive' title='Chưa active'></div>";
					} else if($account["account"]["active"]==-1) {
						echo "<div class='locked' title='Đã khóa'></div>";
					} else {
						echo "<div class='active' title='Đã active'></div>";
					}
					?>
				</td>
				<td id="td_id" style="display:none;"><?php echo $account["account"]["id"]?></td>
				<td id="td_ngaysinh" style="display:none;"><?php echo $html->format_date($account["account"]["ngaysinh"],'d/m/Y')?></td>
				<td id="td_diachi" style="display:none;"><?php echo $account["account"]["diachi"]?></td>
				<td id="td_sodienthoai" style="display:none;"><?php echo $account["account"]["sodienthoai"]?></td>
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