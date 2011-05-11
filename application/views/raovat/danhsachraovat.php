<?php
	$linktmp = BASE_PATH.'/raovat/danhsachraovat';
?>
<div id="content" style="width:100%">
<div class="ui-widget-header ui-helper-clearfix ui-corner-top" style="border:none;padding-left: 5px" id="content_title">Danh Sách Tin Rao Vặt</div>
<table width="99%">
	<thead>
		<tr id="thead_paging">
			<td colspan="11" align="center" style="color:black">
				<?php 
				if($pagesbefore>1)
					echo '<a class="link" style="padding-right:5px" href="'.$linktmp.'">1 ...</a>';
				while($pagesbefore<$pagesindex) {
					echo "<a class='link' href='$linktmp/$pagesbefore'>$pagesbefore</a>";
					$pagesbefore++;
				}
				?>
				<span style="font-weight:bold;color:red"><?php echo $pagesindex ?></span>
				<?php 
				while($pagesnext>$pagesindex) {
					$pagesindex++;
					echo "<a class='link' href='$linktmp/$pagesindex'>$pagesindex</a>";
				}
				if($pagesnext<$pageend)
					echo "<a class='link' style='padding-right:5px' href='$linktmp/$pageend'>... $pageend</a>";
				?>
			</td>
		</tr>
	</thead>
	<tfoot>
		<tr id="tfoot_paging"></tr>
	</tfoot>
	<tbody>		
		<?php
		foreach($lstRaovat as $raovat) {
			$alink = BASE_PATH."/raovat/view/".$raovat["raovat"]["id"]."/".$raovat["raovat"]["alias"];
			$atitle = $raovat["raovat"]["tieude"];
			$aintro = trimString(HTML2Text($raovat["raovat"]["noidung"]),200);
			?>
			<tr>
				<td align="left">
					<a href="<?php echo $alink ?>">
						<div class="first_text" style="min-height: 60px;">
							<span class="avata"><?php echo $atitle ?></span>
							<div class="cat_intro" style="padding-left: 10px;color: gray;"><?php echo $aintro ?></div>
						</div>
					</a>
				</td>				
			</tr>
			<?php
		}
		?>
	</tbody>
</table>
</div>
<script>
	$(document).ready(function() {
		$("#tfoot_paging").html($("#thead_paging").html());
		menuid = '#dang-tin-rao-vat';
		$("#menu "+menuid).addClass("current");
	});
</script>