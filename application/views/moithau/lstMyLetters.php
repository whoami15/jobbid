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
					<td>Tên dự án</td>
					<td>Giá thầu TB</td>
					<td>Bid</td>
					<td>Còn</td>
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
						echo "<tr class='alternateRow'";
					else 
						echo "<tr class='normalRow'";
					if($duan['moithau']['hadread']==0)
						echo ' style="font-weight: bold;cursor:pointer"';
					else 
						echo 'style="cursor:pointer"';
					echo ' onclick="doRead('.$duan["moithau"]["id"].')" >';
					?>
						<td align="left"><a class='link' href='#'><?php echo $duan["duan"]["tenduan"]?></a></td>
						<td align="center" ><?php echo $html->FormatMoney($duan["duan"]["averagecost"])?></td>
						<td align="center" ><?php echo $html->FormatMoney($duan["duan"]["bidcount"])?></td>
						<td align="center">
							<?php 
							if($duan["duan"]["nhathau_id"]!=null)
								echo "Đã đóng";
							else
								echo $html->getDaysFromSecond($duan["duan"]["active"]==1?$duan[""]["timeleft"]:0)
							?>
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