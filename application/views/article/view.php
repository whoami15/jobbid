<div id="content">
	<div class="ui-widget-header ui-helper-clearfix ui-corner-all" style='text-align: left; padding-left: 10px; margin-left: -5px; width: 100%;' id="content_title">Content</div>
	<div style="width: 99%; padding: 5px; font-size: 15pt; font-weight: bold; text-align: left;">
	<?php
	if(isset($article)) {
		echo $article["article"]["title"];
	}
	?>
	</div><br/>
	<?php
	if(isset($article)) {
		echo $article["article"]["content"];
	}
	?>
	<p><strong><font size="2">Tin khác:</font></strong></p>
	<ul>
	<?php 
	foreach($lstArticlesOlder as $a) {
		$alink = BASE_PATH."/article/view/".$a["article"]["id"]."/".$a["article"]["alias"];
		?>
		<li>
		<a class="link" href="<?php echo $alink ?>"><?php echo $a["article"]["title"] ?></a> 
		</li>
		<?php
	}
	?>
	</ul>
</div>
<script>
	$(document).ready(function() {
		$("#tfoot_paging").html($("#thead_paging").html());
		menuid = '#news';
		$("#content_title").css("width",width_content-19);
		$("#content_title").text($("#menu "+menuid).text());
		$("#menu "+menuid).addClass("current");
	});
</script>
