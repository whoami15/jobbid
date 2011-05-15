<table width="100%">
	<thead>
		<tr class="ui-accordion-header ui-helper-reset ui-state-default ui-corner-all" style="font-weight:bold;height:20px;text-align:center;">
			<td width="10px">ID</td>
			<td>Email</td>
			<td>Password</td>
			<td>SMTP</td>
			<td width="40px">Port</td>
			<td width="50px">Xử lý</td>
		</tr>
	</thead>
	<tbody>
		<?php
		$i=0;
		foreach($senders as $sender) {
			$i++;
			if($i%2==0)
				echo "<tr class='alternateRow'>";
			else 
				echo "<tr class='normalRow'>";
			?>
				<td id="td_id" align="center"><?php echo $sender["id"]?></td>
				<td id="td_email" align="left"><?php echo $sender["email"]?></td>
				<td id="td_password" align="left"><?php echo $sender["password"]?></td>
				<td id="td_smtp" align="center"><?php echo $sender["smtp"]?></td>
				<td id="td_port" align="center"><?php echo $sender["port"]?></td>
				<td align="center">
					<img style="cursor:pointer" onclick="selectSender(<?php echo $isPre ?>,this)" title="Chỉnh sửa" alt="edit" src="<?php echo BASE_PATH ?>/public/images/icons/edit.png"/>
					<img style="cursor:pointer" onclick="removeEmail(<?php echo $isPre ?>,<?php echo $sender["id"]?>)" title="Xóa" alt="remove" src="<?php echo BASE_PATH ?>/public/images/icons/remove.png"/>
				</td>
			</tr>
			<?php
		}
		?>
	</tbody>
</table>