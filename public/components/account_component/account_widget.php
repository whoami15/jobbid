<style>
#account_widget li {
	padding-bottom:5px;
}
</style>
<div id="account_widget" style="margin-top:5px;">
<?php 
	if(isset($_SESSION["user"])) {
		?>
		<p align="center">Xin chào <a class='link' href='#'><?php echo $_SESSION["user"]["account"]["username"] ?></a></p>
		<ul style="padding-left:15px">
			<?php
			if($_SESSION["user"]["account"]["role"]==1) {
				echo "<li><a id='vao_quan_tri' class='link' href='".BASE_PATH."/admin'>Vào trang quản trị</a></li>";
			}
			?>
			<li><a id="quan_ly_ho_so_ca_nhan" class="link" href="<?php echo BASE_PATH ?>/nhathau/view">Quản lý hồ sơ cá nhân</a></li>
			<li><a id="ds_ho_so_thau" class="link" href="<?php echo BASE_PATH ?>/hosothau/ds_ho_so_thau">Danh sách hồ sơ thầu</a></li>
			<li><a id="ds_du_an_quan_tam" class="link" href="<?php echo BASE_PATH ?>/duan/viewmarks">Các dự án quan tâm</a></li>
			<li><a id="ds_du_an_cua_toi" class="link" href="<?php echo BASE_PATH ?>/duan/viewMyprojects">Các dự án của tôi</a></li>
			<li><a class="link" href="<?php echo BASE_PATH ?>/account/doLogout/account">Thoát</a></li>
		</ul>
		<?php
	} else {
	?>
	<ul style="padding-left:15px">
		<li>Bạn chưa <a class="link" href="<?php echo BASE_PATH ?>/account/login">Đăng nhập.</a></li>
		<li><a class="link" href="<?php echo BASE_PATH ?>/account/register">Đăng ký</a> tài khoản miễn phí!</li>
	</ul>
	<?php
	}
?>
</div>
<script>
	$(document).ready(function(){
		
	});
</script>