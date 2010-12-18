<div id="content">
	<?php
	if(empty($tintuc))
	{
		echo "Không tìm thấy tin tức.";
	}
	else
	{
	?>
		<table width="100%">
			<tbody>
				<tr class="tr_title">
					<td>
						THÔNG BÁO - TIN TỨC - KHUYẾN MÃI
					</td>
				</tr>
				<tr>
					<td align="center">
						<div style="padding-left:5px;padding-right:5px">
							<span class="titleMessage"><?php echo $tintuc['TinTuc']['tieude'] ?></span>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<div style="padding-left:5px;padding-right:5px">
							<?php echo $tintuc['TinTuc']['noidung'] ?>
						</div>
					</td>
				</tr>
			</tbody>
		</table>
	<?php
	}
	
	?>
</div>