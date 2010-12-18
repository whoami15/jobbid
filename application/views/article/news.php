<div class="ui-widget-header ui-helper-clearfix ui-corner-all" style='text-align: left; padding-left: 10px; margin-left: -5px; width: 100%;' id="content_title">Content</div>
<table width="100%">
	<thead id="thead_paging">
		<tr>
			<td colspan="11" align="center" style="color:black">
				<?php
				if(isset($hasprev)) {
					$pageTmp = $pageindex-1;
					echo "<a class='link' href='".BASE_PATH."/article/news/$pageTmp'>Trước</a>";
				}
				echo "<span style='font-weight: bold; padding-left: 10px; font-size: 10pt; color: #F68618;'>$pageindex</span>";
				if(isset($hasnext)) {
					$pageTmp = $pageindex+1;
					echo "<a class='link' href='".BASE_PATH."/article/news/$pageTmp'>Sau</a>";
				}
				?>
			</td>
		</tr>
	</thead>
	<tfoot id="tfoot_paging">
		
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
<script>
	$(document).ready(function() {
		$("#tfoot_paging").html($("#thead_paging").html());
		menuid = '#news';
		$("#content_title").css("width",width_content-19);
		$("#content_title").text($("#menu "+menuid).text());
		$("#menu "+menuid).addClass("current");
	});
</script>