<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="shortcut icon" href="<?php echo BASE_PATH ?>/public/css/backend/images/favico.ico" type="image/x-icon">
		<title>My CMS</title>         
		<link href="<?php echo BASE_PATH ?>/public/css/backend/jquery-ui-1.8.5.custom.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo BASE_PATH ?>/public/css/backend/admin_style.css" rel="stylesheet" type="text/css" />
		<style type="text/css">
		input.ui-button {
			border:medium none;
			padding:1px 1em;
		}
		</style>
		<!--[if !IE]> 
		<-->
		<style type="text/css">
			fieldset {
				border:1px solid #A6C9E2;
				-moz-border-radius:5px 5px 5px 5px;
			}
		</style>
		<!--> 
		<![endif]-->
		<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/jquery-1.4.2.min.js"></script>
		<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/jquery-ui.js"></script>
		<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/jquery_blockUI.js"></script>		
		<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/constances.js"></script>	
		<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/dropmenu.js" ></script>
		<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/sprinkle.js"></script>
		<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/validator.js"></script>
		<script type="text/javascript">
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
			function byId(id) {
				return document.getElementById(id);
			}
			function jsdebug(data) {
				alert(data);
			}
		</script>
    </head>	
<body>
<center>
<div id="wrapcontent">
<div style="float: left; background-color: white;width:100%;">
<div id="logo">
  <div align="center"><br />
    <img src="<?php echo BASE_PATH ?>/public/images/logo.png" alt="logo" width="116" height="34" /><br />
  </div>
</div>
<div id="arrows"></div>
<div class="bodytext" id="hello">Xin chào <a href="#"><?php echo $_SESSION["account"]["username"] ?></a> <img src="<?php echo BASE_PATH ?>/public/images/icons/user.png" alt="user_icon" height="26" border="0" /><br />
</div>
<div id="top_icon">
  <div align="center" class="toplinks">
    <div><a href="<?php echo BASE_PATH ?>"><img src="<?php echo BASE_PATH ?>/public/images/icons/big_visitsite.png" alt="big_visitsite" width="30" height="26" border="0" /></a></div>
      <a href="<?php echo BASE_PATH ?>"><span class="toplinks">VISIT SITE</span></a></div>
</div>
<div onclick="showImagesPanel()" id="top_icon">
  <div align="center">
    <div><a href="#"><img src="<?php echo BASE_PATH ?>/public/images/icons/image.jpg" alt="big_users" height="26" border="0" /></a></div>
<span class="toplinks">
      <a href="#" ><span class="toplinks">IMAGES</span></a></span></div>
  <br />
</div>
<div id="top_icon">
  <div align="center">
    <div><a href="<?php echo BASE_PATH ?>/admin/settings"><img src="<?php echo BASE_PATH ?>/public/images/icons/big_settings.png" alt="big_settings" width="25" height="26" border="0" /></a></div>
			<span class="toplinks">
      <a href="<?php echo BASE_PATH ?>/admin/settings"><span class="toplinks">SETTINGS</span></a></span><br />
  </div>
</div>
<div id="top_icon">
  <div align="center">
    <div><a href="<?php echo BASE_PATH ?>/account/doLogout"><img src="<?php echo BASE_PATH ?>/public/images/icons/big_logout.png" alt="big_logout" width="25" height="26" border="0" /></a></div>
<span class="toplinks">
      <a href="<?php echo BASE_PATH ?>/account/doLogout"><span class="toplinks">LOG OUT</span></a></span><br />
  </div>
</div>
</div>
<div id="leftcolumn">
  <div id="navigation"><img src="<?php echo BASE_PATH ?>/public/images/title_bg.png" alt="titlebg" width="180" height="49" />
    <div class="toplinks style1" id="navigationtitle"><strong>DANH SÁCH CHỨC NĂNG</strong><br /> <!--// Title -->
      <br />
      <table width="190" border="0">
        <tr>
          <td width="18" align="center"><img src="<?php echo BASE_PATH ?>/public/images/icons/widget_icon.png" alt="dashboard" width="16" height="13" /></td>
          <td width="130" class="navigation"><a href="<?php echo BASE_PATH ?>/admin/index" >Quản Trị Widget</a></td>
        </tr>
        <tr>
          <td align="center"><img src="<?php echo BASE_PATH ?>/public/images/icons/articles.png" alt="articles" width="16" height="13" /></td>
          <td class="navigation"><a href="<?php echo BASE_PATH ?>/admin/viewAdminMenu" >Quản Trị Menu</a></td> 
        </tr>
        <tr>
          <td align="center"><img src="<?php echo BASE_PATH ?>/public/images/icons/gallery.png" alt="galleries" width="18" height="12" /></td>
          <td class="navigation" ><a href="#" onclick="showImagesPanel()"  >Thư Viện Hình Ảnh</a></td>
        </tr>
        <tr>
          <td align="center"><img src="<?php echo BASE_PATH ?>/public/images/icons/calendar.png" alt="calendar" width="15" height="15" /></td>
          <td class="navigation"><a href="<?php echo BASE_PATH ?>/admin/viewAdminPage" >Quản Lý Trang</a></td>
        </tr>
		<tr>
          <td align="center"><img src="<?php echo BASE_PATH ?>/public/images/icons/articles.png" alt="articles" width="15" height="15" /></td>
          <td class="navigation"><a href="<?php echo BASE_PATH ?>/admin/viewAdminArticle" >Quản Lý Tin Tức</a></td>
        </tr>
        <tr>
          <td align="center"><img src="<?php echo BASE_PATH ?>/public/images/icons/users.png" alt="users" width="16" height="18" /></td>
          <td class="navigation"><a href="<?php echo BASE_PATH ?>/admin/viewAdminAccount">Quản Lý Account</a></td>
        </tr>
		<tr>
          <td align="center"><img src="<?php echo BASE_PATH ?>/public/images/icons/users.png" alt="users" width="16" height="18" /></td>
          <td class="navigation"><a href="<?php echo BASE_PATH ?>/admin/viewQuanlyLinhvuc">Quản Lý Lĩnh Vực</a></td>
        </tr>
		<tr>
          <td align="center"><img src="<?php echo BASE_PATH ?>/public/images/icons/users.png" alt="users" width="16" height="18" /></td>
          <td class="navigation"><a href="<?php echo BASE_PATH ?>/admin/viewQuanlySkill">Quản Lý Skill</a></td>
        </tr>
		<tr>
          <td align="center"><img src="<?php echo BASE_PATH ?>/public/images/icons/users.png" alt="users" width="16" height="18" /></td>
          <td class="navigation"><a href="<?php echo BASE_PATH ?>/admin/viewQuanlyNhathau">Quản Lý Nhà Thầu</a></td>
        </tr>
		<tr>
          <td align="center"><img src="<?php echo BASE_PATH ?>/public/images/icons/users.png" alt="users" width="16" height="18" /></td>
          <td class="navigation"><a href="<?php echo BASE_PATH ?>/admin/viewQuanlyDuan">Quản Lý Dự Án</a></td>
        </tr>
		<tr>
          <td align="center"><img src="<?php echo BASE_PATH ?>/public/images/icons/users.png" alt="users" width="16" height="18" /></td>
          <td class="navigation"><a href="<?php echo BASE_PATH ?>/admin/viewQuanlyHosothau">Quản Lý Hồ Sơ Thầu</a></td>
        </tr>
		<tr>
          <td align="center"><img src="<?php echo BASE_PATH ?>/public/images/icons/users.png" alt="users" width="16" height="18" /></td>
          <td class="navigation"><a href="<?php echo BASE_PATH ?>/admin/viewCongcuPR">Công Cụ PR</a></td>
        </tr>
        <tr>
          <td align="center"><img src="<?php echo BASE_PATH ?>/public/images/icons/statistics.png" alt="statistics" width="14" height="16" /></td>
          <td class="navigation"><a href="#">Statistics</a></td> <!--// Statistics -->
        </tr>
        <tr>
          <td align="center"><img src="<?php echo BASE_PATH ?>/public/images/icons/settings.png" alt="settings" width="14" height="14" /></td>
          <td class="navigation"><a href="#">Settings</a></td> <!--// Settings -->
        </tr>
        <tr>
          <td align="center"><img src="<?php echo BASE_PATH ?>/public/images/icons/support.png" alt="support" width="16" height="16" /></td>
          <td class="navigation"><a href="3.html">Help &amp; Support</a></td> <!--// Support -->
        </tr>
      </table>
      <br />
    </div>
  </div>
</div>
<div id="content"> 
  <table width="100%" border="0">
    <tr>
      <th height="25px" valign="middle" bgcolor="#E5E5E5" scope="col"><h1 align="left" id="title_page" class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all" style="font-size:13pt;height:25px;padding-left:10px;padding-top:5px;">Welcome to your Admin Panel</h1></th> <!--// H1 title -->
    </tr>
    <tr>
      <td bgcolor="#FFFFFF" id="content_page">
		<?php
		include (ROOT . DS . 'application' . DS . 'views' . DS . $this->_controller . DS . $this->_action . '.php');
		?>
	  </td>
    </tr>
  </table> 
</div>
<div id="dialog_panel"></div>	
</center>

</body>
</html>  
<script type="text/javascript">
	var url_base = '<?php echo BASE_PATH ?>';
	function url(url) {
		return url_base+url;
	}
	function showImagesPanel() {
		$("#dialog_panel").html("");
		$("#dialog_panel").dialog({
			width: 835,
			height:566,
			title:"Thư Viện Hình Ảnh",
			buttons: {}
		});
		$("#dialog_panel").dialog("open");
		block("#dialog_panel");
		$.ajax({
			type: "GET",
			cache: false,
			url : url("/image"),
			success: function(data){
				unblock("#dialog_panel");
				$("#dialog_panel").html(data);
				$("input:submit, input:button", "#dialog_panel").button();					
			},
			error: function(data){ alert (data);unblock("#dialog_panel");}	
		});
	}
	$(document).ready(function() {
		var sitename = '<?php echo SITE_NAME ?>';
		document.title = sitename+' - Trang Quản Trị';
		$("#content").css('width',$(document).width()-230);
	});
	
	function showDialog(id,width,title,height) {
		var maskHeight = $(document).height();
		var maskWidth = $(window).width();
		var winH = $(window).height();
		var winW = $(window).width();
		if(width != null) {
			$(id + ' #dialog').css('width',  width);
		} else {
			width = 500;
		}
		if(height != null) {
			$(id + ' #dialog').css('height',  height);
		}
		if(title != null) {
			$(id + ' #title_dialog').html(title);
		}
		$(id + ' #dialog').css('top',  10);
		$(id + ' #dialog').css('left', (winW-$(id + ' #dialog').width())/2);
		//Set heigth and width to mask to fill up the whole screen
		$(id+' #mask').css({'width':maskWidth,'height':maskHeight,'opacity':0.5});
		$(id+' #mask').show();
		
		$(id + ' #dialog').fadeIn('fast'); 
	}
	function closeDialog(id) {
		if(id != null) {
			$(id+' #mask').hide();
			$(id + ' .window').hide();
		} else {
			$('#mask').hide();
			$('.window').hide();
		}
		
	}	
	$(document).ready(function(){
		wleftcol = ($("#leftcol").height()==0)?0:$("#leftcol").width();
		wrightcol = ($("#rightcol").height()==0)?0:$("#rightcol").width();
		$("#content").css('max-width',$("#wrapcontent").width()-wleftcol-wrightcol);
		$("#dialog_panel").dialog({
			autoOpen: false,
			minWidth: 200,
			modal: true,
			resizable :true
		});	
		$("input:submit, input:button", "body").button();
	});
</script>