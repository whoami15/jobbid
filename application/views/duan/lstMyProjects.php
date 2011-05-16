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
			<td style="width:100px">Giá thầu TB</td>
			<td style="width:50px">Bid</td>
			<td style="width:120px">Lĩnh vực</td>
			<td style="width:110px">Còn</td>
			<td style="width:40px">Sửa</td>
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
				<td align="left"><a class='link' href='<?php echo BASE_PATH."/duan/view/".$duan["duan"]["id"]."/".$duan["duan"]["alias"] ?>'><?php echo $duan["duan"]["tenduan"]?></a></td>
				<td align="center" style="width:100px"><?php echo $html->FormatMoney($duan["duan"]["averagecost"])?></td>
				<td align="center" style="width:50px"><?php echo $duan["duan"]["bidcount"]?></td>
				<td align="left" style="width:120px"><?php  echo $duan["linhvuc"]["tenlinhvuc"] ?></td>
				<td align="center" style="width:110px">
					<?php 
					if($duan["duan"]["approve"]!=1)
						echo "Đang chờ duyệt";
					else if($duan["duan"]["nhathau_id"]!=null)
						echo "Đã đóng";
					else
						echo $html->getDaysFromSecond($duan["duan"]["active"]==1?$duan[""]["timeleft"]:0)
					?>
				</td>
				<td align="center" style="width:40px">
					<img style="cursor:pointer" onclick="editMyProject(<?php echo $duan["duan"]["id"]?>)" title="Sửa" alt="edit" src="<?php echo BASE_PATH ?>/public/images/icons/edit.png"/> 
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