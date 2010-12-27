<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Đấu Giá Dự Án, Công Việc - Tìm Việc Làm Thêm</title>
<meta name="robots" content="index, follow">
<meta content="du an, cong viec,lam them tai nha,dau gia,dau gia du an, dau gia cong viec, thau du an, thau cong viec,tim viec lam them, lam them, viec parttime,cong viec ban thoi gian,tim nha thau,tim viec,viec lam online, viec lam ban thoi gian, đấu giá dự án, đấu giá công việc, thầu dự án, thầu công việc, tìm việc làm thêm,làm thêm,việc parttime,công việc tại nhà,công việc bán thời gian,tìm nhà thầu,dự án,công việc, đấu giá,tìm việc,việc làm onlien,việc làm bán thời gian,làm thêm tại nhà" name="description"/>
<meta content="du an, cong viec,lam them tai nha,dau gia,dau gia du an, dau gia cong viec, thau du an, thau cong viec,tim viec lam them, lam them, viec parttime,cong viec ban thoi gian,tim nha thau,tim viec,viec lam online, viec lam ban thoi gian, đấu giá dự án, đấu giá công việc, thầu dự án, thầu công việc, tìm việc làm thêm,làm thêm,việc parttime,công việc tại nhà,công việc bán thời gian,tìm nhà thầu,dự án,công việc, đấu giá,tìm việc,việc làm onlien,việc làm bán thời gian,làm thêm tại nhà" name="keywords"/>
<meta name="page-topic" content="du an, cong viec,lam them tai nha,dau gia,dau gia du an, dau gia cong viec, thau du an, thau cong viec,tim viec lam them, lam them, viec parttime,cong viec ban thoi gian,tim nha thau,tim viec,viec lam online, viec lam ban thoi gian, đấu giá dự án, đấu giá công việc, thầu dự án, thầu công việc, tìm việc làm thêm,làm thêm,việc parttime,công việc tại nhà,công việc bán thời gian,tìm nhà thầu,dự án,công việc, đấu giá,tìm việc,việc làm onlien,việc làm bán thời gian,làm thêm tại nhà"/>
<meta content="Job Bid, VIET NAM" name="author"/>
<meta content="Job Bid" name="copyright"/>
<link href="<?php echo BASE_PATH ?>/public/css/front/jquery-ui.css" rel="stylesheet" type="text/css" />
<link href="<?php echo BASE_PATH ?>/public/css/front/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?php echo BASE_PATH ?>/public/css/front/menu_style.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/jquery_blockUI.js"></script>	
<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/constances.js"></script>	
<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/config.js"></script>	
<style>
.ui-widget-header {
	font-size:14px;
	height:20px;
	padding-top:5px;
}
.ui-widget-content a {
	color:#0000ff;
}
.ui-widget {
	font-size:13px;
}
.link {
	color:blue;
	font-size:13px;
	text-align:left;
}
#datagrid .link {
	padding-left: 5px;
	padding-right:5px;
}
.link:hover {
	color: #F68618;
}
.link2 {
	color:gray !important;
}
.link2:hover {
	color: #fff !important;
}
.imgbanner {
	color:transparent !important;
}
input.ui-button {
	border:medium none;
	padding:1px 1em;
}
table.center {margin-left:auto; margin-right:auto;}
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
<style>
	fieldset {
		border:1px solid #C2C2C2;
		-moz-border-radius:5px 5px 5px 5px;
	}
</style>
<!--> 
<![endif]-->
<script>
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
			message: '<span style="color:white">Đang tải dữ liệu...</span>', 
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
	function boundTip(id,content,width) {
		if(width==null)
			width = 250;
		$("#"+id).hover(
			function () {
			showtip(content,width);
			}, 
			function () {
			hidetip();
			}
		);
	}
	var width_content;
	$(document).ready(function(){
		
		wleftcol = ($("#leftcol").height()==0)?0:$("#leftcol").width();
		wrightcol = ($("#rightcol").height()==0)?0:$("#rightcol").width();
		var tmp = 0;
		if(wleftcol!=0) {
			tmp+=5;
			$("#content").css("padding-left","5px");
		}
		if(wrightcol!=0) {
			tmp+=5;
			$("#content").css("padding-right","5px");
		}
		width_content = $("#wrapcontent").width()-wleftcol-wrightcol-tmp;
		$("#content").css('width', width_content);
		
	});
</script>
</head>
<body>
<center>
<div id="dhtmltooltip"></div>
<img alt="tooltiparrow" id="dhtmlpointer" src="<?php echo BASE_PATH ?>/public/images/icons/tooltiparrow.png" />
<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/tooltip.js"></script>
<div id="wrapcontent" name="top">
	<div style="position:relative;float:left;width:100%">
		<div style="width:1000px;height:150px">
			<?php 
			if(isset($banner)) {
				echo $banner["widget"]["content"];
			}
			?>
		</div>
		<div id="top">
			<?php 
			if(isset($menu)) {
				echo "<div class='widget'>";
				include (ROOT . DS . 'public' . DS . $menu["widget"]["content"]);
				echo "</div>";
			}
			?>
		</div>
		<div id="leftcol">
			<?php
			foreach($leftcol as $widget) {
				echo "<div class='ui-tabs ui-widget ui-widget-content ui-corner-all' style='text-align:left'>";
				if($widget["widget"]["showtitle"]==1)
					echo "<div class='ui-widget-header ui-helper-clearfix ui-corner-all' style='padding-left:10px'>".$widget["widget"]["name"]."</div>";				
				if($widget["widget"]["iscomponent"]==1) {
					include (ROOT . DS . 'public' . DS . $widget["widget"]["content"]);
				} else {
					echo $widget["widget"]["content"];
				}		
				echo "</div>";
			}
			?>	
		</div>
		<div id="content">
			<div class='ui-tabs ui-widget ui-widget-content ui-corner-all'>
			<div style="padding-left:5px;padding-right:5px;">
			<?php
			include (ROOT . DS . 'application' . DS . 'views' . DS . $this->_controller . DS . $this->_action . '.php');
			?>
			</div>
			</div>
		</div>
		<div id="rightcol">
			<?php
			foreach($rightcol as $widget) {
				echo "<div class='ui-tabs ui-widget ui-widget-content ui-corner-all' style='text-align:left'>";
				if($widget["widget"]["showtitle"]==1)
					echo "<div class='ui-widget-header ui-helper-clearfix ui-corner-all' style='padding-left:10px'>".$widget["widget"]["name"]."</div>";				
				if($widget["widget"]["iscomponent"]==1) {
					include (ROOT . DS . 'public' . DS . $widget["widget"]["content"]);
				} else {
					echo $widget["widget"]["content"];
				}		
				echo "</div>";
			}
			?>	
		</div>		
	</div>
	<div class='ui-tabs ui-widget ui-widget-content ui-corner-all' style="width: 1000px; height: auto; position: relative; float: left;">
			<?php 
			if(isset($footer)) {
				echo $footer["widget"]["content"];
			}
			?>
	</div>
	<div id="test">
		
	</div>
</div>
</body>
</html>
<script>

</script>
<input type="hidden" id="iduser" value="<?php echo $html->safevalue($_SESSION["user"]["account"]["id"]) ?>"/>
