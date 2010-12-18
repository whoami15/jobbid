<table width="450px" >
	<tbody>
		<tr>
			<td >
				<div style="height:340px;overflow:auto;">
				<ul>
				<?php
				foreach($lstLinhvucquantam as $linhvuc) {
					echo "<li>".$linhvuc['linhvuc']['tenlinhvuc']."</li>";
				}
				?>
				</ul>
				</div>
			</td>
		</tr>
	</tbody>
</table>