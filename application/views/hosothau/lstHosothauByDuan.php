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
			<td>#</td>
			<td>Nhà thầu</td>
			<td>Giá thầu</td>
			<td >Đánh giá</td>
		</tr>
	</thead>
	<tfoot>
		<tr id="tfoot_paging"></tr>
	</tfoot>
	<tbody id="tbodyhosothau">
		<?php
		$i=0;
		foreach($lstHosthau as $hosothau) {
			$i++;
			if($i%2==0)
				echo "<tr class='alternateRow'>";
			else 
				echo "<tr class='normalRow'>";
			?>
				<td rowspan="2"><?php echo $i ?></td>
				<td align="center"><a id="hosothau_<?php echo $hosothau["hosothau"]["id"] ?>" class='link' onmouseover='showinfo(this)' onmouseout="hidetip()" href='<?php echo BASE_PATH ?>/nhathau/xem_ho_so/<?php echo $hosothau["nhathau"]["id"].'/'.$hosothau["nhathau"]['nhathau_alias'] ?>'><?php echo $hosothau["nhathau"]["displayname"]?></a></td>
				<td align="center"><?php echo $html->FormatMoney($hosothau["hosothau"]["giathau"])?> VNĐ</td>
				<td id="td_milestone" style="display:none"><?php echo $hosothau["hosothau"]["milestone"]?> %</td>
				<td id="td_thoigian"  style="display:none"><?php echo $hosothau["hosothau"]["thoigian"]?> ngày</td>
				<td id="td_timeofbid" style="display:none"><?php echo $html->getDaysFromSecond($hosothau[""]["timeofbid"]) ?></td>
				<td id="td_id" style="display:none"><?php echo $hosothau["hosothau"]["id"] ?></td>
				<td align="left">
				<div style="float: left;" id="ctl00_SampleContent_ThaiRating">
					<a style="text-decoration: none;" title="2" id="ctl00_SampleContent_ThaiRating_A" href="javascript:void(0)">
					<?php
					for($j=0;$j<$hosothau["nhathau"]["diemdanhgia"];$j++) {
						echo '<span style="float: left;" class="ratingStar filledRatingStar" id="ctl00_SampleContent_ThaiRating_Star_1">&nbsp;</span>';
					}
					?>
					</a>
				</div>
				</td>
			</tr>
			<?php
			if($i%2==0)
				echo "<tr class='alternateRow'>";
			else 
				echo "<tr class='normalRow'>";
			?>
				<td colspan="3" align="left">
					<span style="padding-left:5px"><?php echo $hosothau["hosothau"]["content"] ?></span><a class="link" href="<?php echo BASE_PATH."/hosothau/xem_ho_so/".$hosothau["hosothau"]["id"]."/".$duan_id ?>">(Xem chi tiết)</a>
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