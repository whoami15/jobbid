<ul id="menu" style="padding-bottom:5px">
<?php
foreach($menuList as $menu) {
	echo "<li><a id='".$menu["menu"]["id"]."' class='menulink' href='".$menu["menu"]["url"]."'>".$menu["menu"]["name"]."</a></li>";
}
?>	
	<li style="float: right; margin-right: 5px;border:none">
	<div class="search">
		<form id="formsearch" method="post" action="<?php echo BASE_PATH?>/duan/search">
		<input type="text" class="txtsearch" name="keyword" id="keyword" value="<?php echo isset($_POST["keyword"])?$_POST["keyword"]:"" ?>"/>
		<div class="textboxstyle" title="Tìm kiếm" onclick="$('#formsearch').submit();"></div>
		</form>
	</div>
	</li>
</ul>