<style>
#lastnews_widget li {
	padding-bottom:8px;
}
</style>
<div id="lastnews_widget" style="margin:5px;">
<ul style="padding-left: 15px; margin: 0px;">
<?php
	$lastnews = $cache->get('lastnews');
	foreach($lastnews as $article) {
		$link = BASE_PATH.'/article/view/'.$article['id']."/".$article['alias'];
		echo '<li><a class="link" href="'.$link.'" title="'.$article['title'].'">'.$article['title'].'</a></li>';
	}
?>
</ul>
<p align="right" style="padding-right:5px"><a class="link" href="<?php echo BASE_PATH?>/article/danhsachbaiviet">Xem thêm...</a></p>
</div>