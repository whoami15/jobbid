<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title><?php echo isset($title)?$title:'Tìm Việc Làm Thêm - Việc Bán Thời Gian - Sàn Việc Làm - Làm Part Time' ?></title>
<link rel="shortcut icon" href="<?php echo BASE_PATH ?>/public/css/front/images/favico.ico" type="image/x-icon"/>
<meta name="google-site-verification" content="nwi63Vcpe4pc79r9h9D_VYVj3CmiNqto9eIt4jUshB0" />
<meta content="Vietnamese, Vietnam" name="language">
<meta name="robots" content="index, follow"/>
<meta content="<?php echo isset($description)?$description:'Jobbid.vn là sàn việc làm để bạn có thể gửi dự án đấu giá công khai, qua đó tìm được ứng viên thích hợp để thực hiện dự án của bạn.Các bạn có thể tìm kiếm được những công việc bán thời gian (part time) hoặc các dự án nhỏ phù hợp với khả năng của bạn.'?>" name="description"/>
<meta content="jobbid.vn,tim viec part time, tìm việc part time,sàn việc làm,viec ban thoi gian,viec lam tu do,san viec lam,viec ban thoi gian,du an, cong viec,tim viec ban thoi gian,viec lam tai nha,dau thau,dau thau du an, dau thau cong viec, thau du an, thau cong viec,tim viec lam them, lam them, viec part time,cong viec ban thoi gian,tim nha thau,tim viec,viec lam online, viec lam ban thoi gian, đấu giá dự án, đấu giá công việc, thầu dự án, thầu công việc, tìm việc làm thêm,làm thêm,việc part time,công việc tại nhà,công việc bán thời gian,dự án,công việc, đấu giá,tìm việc,việc làm onlien,việc làm bán thời gian,việc làm tại nhà, làm thêm online, làm thêm cho sinh viên, làm thêm trên mạng,việc bán thời gian,việc làm tự do" name="keywords"/>
<meta content="jobbid.vn" name="author"/>
<meta content="jobbid.vn" name="copyright"/>
<link href="<?php echo BASE_PATH ?>/public/css/front/jquery-ui.css" rel="stylesheet" type="text/css" />
<link href="<?php echo BASE_PATH ?>/public/css/front/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?php echo BASE_PATH ?>/public/css/front/menu_style.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/jquery_blockUI.js"></script>	
<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/constances.js"></script>	
<style type="text/css">
.textboxstyle{
	background-image:url('<?php echo BASE_PATH?>/public/images/icons/search_icon.gif');
	background-position: center center;
    background-repeat: no-repeat;
    cursor: pointer;
    float: left;
    height: 22px;
    position: relative;
    width: 22px;
}
</style>
<!--[if !IE]> 
<-->
<style type="text/css">
	fieldset {
		border:1px solid #C2C2C2;
		-moz-border-radius:5px 5px 5px 5px;
	}
</style>
<!--> 
<![endif]-->
</head>
<body>
<CENTER>
<div id="dhtmltooltip"></div>
<img alt="tooltiparrow" id="dhtmlpointer" src="<?php echo BASE_PATH ?>/public/images/icons/tooltiparrow.png" />
<img alt="tooltiparrow" id="dhtmlpointer2" src="<?php echo BASE_PATH ?>/public/images/icons/tooltiparrow2.png" />
<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/tooltip.js"></script>
<div id="wrapcontent">
	<div style="position:relative;float:left;width:100%">
		<div style="width:100%;height:150px">
			<?php 
			if(isset($banner)) {
				echo $banner['widget']['content'];
			}
			?>
		</div>
		<div id="top">
			<?php 
			if(isset($menu)) {
				echo '<div class="widget">';
				include (ROOT . DS . 'public' . DS . $menu['widget']['content']);
				echo '</div>';
			}
			?>
		</div>
		<div id="leftcol" >
			<div class='ui-tabs ui-widget ui-widget-content ui-corner-all' style="padding:0">
			<?php
			include (ROOT . DS . 'application' . DS . 'views' . DS . $this->_controller . DS . $this->_action . '.php');
			?>
			</div>
		</div>
		<div id="rightcol">
			<?php
			foreach($rightcol as $widget) {
				echo '<div class="ui-tabs ui-widget ui-widget-content ui-corner-all" style="text-align:left;padding:0">';
				if($widget['widget']['showtitle']==1)
					echo '<div class="ui-widget-header ui-helper-clearfix ui-corner-top" style="border:none;padding-left:5px">'.$widget['widget']['name'].'</div>';				
				if($widget['widget']['iscomponent']==1) {
					include (ROOT . DS . 'public' . DS . $widget['widget']['content']);
				} else {
					echo $widget['widget']['content'];
				}		
				echo '</div>';
			}
			?>	
		</div>	
		<div id="bottom">
		<?php
			foreach($footer as $widget) {
				echo '<div class="ui-tabs ui-widget ui-widget-content ui-corner-all" style="width: 100%;margin:0;padding:0; height: auto; position: relative; float: left;margin-bottom:5px">';
				if($widget['widget']['showtitle']==1)
					echo '<div class="ui-widget-header ui-helper-clearfix ui-corner-top" style="border:none;padding-left:5px">'.$widget['widget']['name'].'</div>';				
				if($widget['widget']['iscomponent']==1) {
					include (ROOT . DS . 'public' . DS . $widget['widget']['content']);
				} else {
					echo $widget['widget']['content'];
				}		
				echo '</div>';
			}
		?>	
		</div>
	</div>
</div>
<div id="dialogIntro" title="Chào Mừng Bạn Đến Với Jobbid.Vn" style="text-align:left">
	<table width="100%" border="thin">
		<thead>
		<tr class="ui-accordion-header ui-helper-reset ui-state-default ui-corner-all" style="font-weight:bold;height:20px;text-align:center;">
			<td style="width:50%">BẠN LÀ FREELANCER</td>
			<td>BẠN LÀ CHỦ DỰ ÁN</td>
		</tr>
		</thead>
		<tbody>
		<tr>
		<td valign="top">
		<br/>&nbsp;&nbsp; - Tìm được công việc làm thêm phù hợp với khả năng của mình.<br/>&nbsp;&nbsp; - Tận dụng được tối đa thời gian nhàn rỗi của bạn<br/>&nbsp;&nbsp; - <span style="color:rgb(255, 0, 0)">Nhận được email thông báo nếu có dự án, công việc mới</span><br/>&nbsp;&nbsp; - Luôn cập nhật những dự án, công việc mới.<br/>&nbsp;&nbsp; <span style="color:rgb(255, 0, 0)"><b>- Hoàn toàn miễn phí.</b></span><br/><br/>(bạn chỉ cần đăng ký 1 tài khoản và tạo 1 hồ sơ năng lực, chúng tôi sẽ dựa vào hồ sơ đó để gửi các dự án mới đến cho bạn)
		</td>
		<td valign="top">
		<br/>&nbsp;&nbsp; - Đăng dự án, công việc của bạn <span style="color:rgb(255, 0, 0)">(miễn phí)</span><br/>
		&nbsp;&nbsp; - Tìm được những cá nhân (hoặc công ty) ưu tú nhất để thực hiện dự án của bạn với chi phí và thời gian hợp lý nhất.<br/>
		&nbsp;&nbsp; - Gửi email cho bạn ngay khi có người muốn thầu dự án của bạn.<br/>
		&nbsp;&nbsp; <span style="color:rgb(255, 0, 0)"><b>- Hoàn toàn miễn phí.</b></span>
		</td>
		</tr>
		</tbody>
	</table>
</div>
</CENTER>
</body>
</html>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-21846705-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
<script type="text/javascript">
	var url_base = '<?php echo BASE_PATH ?>';
	if (!Array.indexOf) {
	  Array.prototype.indexOf = function (obj, start) {
		for (var i = (start || 0); i < this.length; i++) {
		  if (this[i] == obj) {
			return i;
		  }
		}
		return -1;
	  }
	}
	function url(url) {
		return url_base+url;
	}
	function byId(id) {
		return document.getElementById(id);
	}
	function block(id) {
		$(id).block({ 
			message: '<span style="color:white">Đang xử lý...</span>', 
			css: { 
				border: 'none', 
				padding: '15px', 
				backgroundColor: '#000', 
				'-webkit-border-radius': '10px', 
				'-moz-border-radius': '10px', 
				opacity: .5, 
				color: '#fff'
			} 
		}); 
	}
	function unblock(id) {
		$(id).unblock(); 
	}
	function boundTip(id,content,width,action) {
		if(width==null)
			width = 250;
		if(action==null) {
			$("#"+id).focus(function () {
				xTip = $(this).offset().left+$(this).width();
				yTip = $(this).offset().top;
				showtip(content,width);
			});
			$("#"+id).blur(function () {
				hidetip();
			});
		}
		if(action=="hover") {
			$("#"+id).hover(
				function () {
					xTip = $(this).offset().left+$(this).width();
					yTip = $(this).offset().top;
					showtip(content,width);
				}, 
				function () {
					hidetip();
				}
			);
		}
		
	}
	//Config
	var width_content;
	var editor_width = 499;
	var redirect_time = 2000; // 2giay
	<?php
	if(isset($_SESSION['popup_intro'])) {
		echo 'var autoOpen = false;';
	} else {
		echo 'var autoOpen = true;';
		$_SESSION['popup_intro'] = true;
	}
	
	?>
	$(document).ready(function(){
		$("#dialogIntro").dialog({
			autoOpen: autoOpen,
			minWidth: 800,
			modal: true,
			resizable :false,
			buttons: {
				Đóng: function() {
					$(this).dialog('close');
				}
			}
		});	
		//wleftcol = ($("#leftcol").height()==0)?0:$("#leftcol").width();
		//wrightcol = 250;
		//alert(wrightcol);
		//alert($("#wrapcontent").width());
	});
</script>