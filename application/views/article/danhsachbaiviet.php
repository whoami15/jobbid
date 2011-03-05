<?php
	$linktmp = BASE_PATH.'/article/danhsachbaiviet';
?>
<div id="content" style="width:100%">
<div class="ui-widget-header ui-helper-clearfix ui-corner-top" style="border:none;padding-left: 5px" id="content_title">Trao đổi - Chia Sẻ - Thảo Luận</div>
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
		foreach($lstArticles as $article) {
			$alink = BASE_PATH."/article/view/".$article["article"]["id"]."/".$article["article"]["alias"];
			$atitle = $article["article"]["title"];
			$aimage = $article["article"]["imagedes"];
			$aintro = $article["article"]["contentdes"];
			?>
			<tr>
				<td align="left">
					<div class="first_text">
						<div class="cat_box1"><a href="<?php echo $alink ?>" title="<?php echo $atitle ?>" class="left"><img alt="<?php echo $atitle ?>" src="<?php echo $aimage ?>"></a>
						</div>
						<a href="<?php echo $alink ?>" class="avata"><?php echo $atitle ?></a>
						<div class="cat_intro"><?php echo $aintro ?></div>
					</div>
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
	});
</script>