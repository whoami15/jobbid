<style>
#lastnews_widget li {
	padding-bottom:8px;
}
</style>
<div id="lastnews_widget" style="margin:5px;">
<ul style="padding-left: 15px; margin: 0px;">
<?php
	$raovats = $cache->get('raovats');
	foreach($raovats as $raovat) {
		$link = BASE_PATH.'/raovat/view/'.$raovat['id']."/".$raovat['alias'];
		echo '<li><a class="link" href="'.$link.'" title=\''.$raovat['tieude'].'\'>'.$raovat['tieude'].'</a></li>';
	}
?>
</ul>
<p align="right" style="padding-right:5px"><a class="link" href="<?php echo BASE_PATH?>/raovat/danhsachraovat">Xem thêm...</a></p>
</div>