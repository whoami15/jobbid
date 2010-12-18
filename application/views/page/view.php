<div id="content">
	<?php
	if(isset($page)) {
		echo $page["page"]["content"];
	}
	?>
</div>
<script>
	$(document).ready(function() {
		menuid = '#<?php echo $page["page"]["menu_id"] ?>';
		$("#menu "+menuid).addClass("current");
		$("#content_title").text($("#menu "+menuid).text());
	});
</script>