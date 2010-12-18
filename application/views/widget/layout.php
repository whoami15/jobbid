<div id="layout_msg"></div>
<center>
<div id="layout_wrapcontent">
	<div id="layout_top">
		Banner + Menu
	</div>
	<div id="layout_leftcol">
		<?php
		foreach($leftcol as $widget) {
			echo "<div id='".$widget["widget"]["id"]."' class='layout_widget'>".$widget["widget"]["name"]."</div>";
		}
		?>
	</div>
	<div style="float:left;padding:28px">
	Content Here!
	</div>
	<div id="layout_rightcol">
		<?php
		foreach($rightcol as $widget) {
			echo "<div id='".$widget["widget"]["id"]."' class='layout_widget'>".$widget["widget"]["name"]."</div>";
		}
		?>
	</div>
	<div id="layout_bottom">
		<?php
		if(isset($footer)) {
			echo $footer["widget"]["name"];
		}
		?>
	</div>
</div>
</center>
<script>
function layout_msg(msg,type) {
	if(type==1) { //Thong diep thong bao
		str = "<div class='positive'><span class='bodytext' style='padding-left:30px;'><strong>"+msg+"</strong></span></div>";
		byId("layout_msg").innerHTML = str;
	} else if(type == 0) { //Thong diep bao loi
		str = "<div class='negative'><span class='bodytext' style='padding-left:30px;'><strong>"+msg+"</strong></span></div>";
		byId("layout_msg").innerHTML = str;
	}
}
$(function() {
	$( "#layout_leftcol" ).sortable({
		revert: true
	});
	$( "#layout_rightcol" ).sortable({
		revert: true
	});
	$( "#layout_bottom" ).sortable({
		revert: true
	});
});
</script>