<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/tiny_mce/jquery.tinymce.js"></script>
<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/utils.js"></script>
<style type="text/css"> 	
	.input {
		width:86%;
	}
	select {
		margin-right:-5px;
	}
	.select {
		width:86%;
	}
	
</style>
<div class="boxes" id="dialogPage" >
	<fieldset id="dialog" class="window">
		<div class="ui-dialog-titlebar ui-widget-header ui-corner-top ui-helper-clearfix" style="text-align: center; font-size: 13pt; padding: 2px;margin-bottom:3px;" ><span id="title_dialog">Page Form</span>
		<a href="#" onclick="closeDialog('#dialogPage')" class="ui-dialog-titlebar-close ui-corner-all" role="button" unselectable="on" style="-moz-user-select: none; float: right;"><span class="ui-icon ui-icon-closethick" unselectable="on" style="-moz-user-select: none;">close</span></a>
		</div>
		<form id="formPage">
		<input type="hidden" name="page_id" id="page_id" />
		<fieldset>
			<legend><span style="font-weight:bold;">Thông Tin Page</span></legend>
			<table class="center" width="80%">
				<thead>
					<tr>
						<td colspan="4" id="msg">
						</td>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td width="75px" align="left">Tiêu Đề :</td>
						<td align="left">
							<input type="text" name="page_title" id="page_title" style="width:95%" onblur="fillAlias()"/>
							<span style="color:red;font-weight:bold;cursor:pointer;" title="Bắt buộc nhập dữ liệu">*</span>
						</td>										
					</tr>
					<tr>
						<td align="left">URL Alias :</td>
						<td align="left">
							<input type="text" name="page_alias" id="page_alias" style="width:95%"/>
						</td>										
					</tr>
					<tr>
						<td align="left">Menu :</td>
						<td align="left">
							<select name="page_menu" id="page_menu">
								<option value="0">--Chọn Menu--</option>
								<?php
								foreach($lstMenus as $menu) {
									echo "<option value='".$menu["menu"]["id"]."'>".$menu["menu"]["name"]."</option>";
								}
								?>
							</select>
						</td>										
					</tr>
					<tr>
						<td colspan="2" align="left">
						Nội dung : (<a href="#" onclick="showImagesPanel()">Mở Gallery</a>)<br/>
						<textarea name="page_content" id="page_content" class="tinymce"></textarea>
						</td>
					</tr>					
					<tr>
						<td colspan="6" align="center" height="50px">
							<input onclick="savePage()" value="Lưu" type="button">
							<input onclick="deletePage()" value="Xóa" type="button">
							<input onclick="doReset()" value="Reset" type="button">
						</td>
					</tr>
				</tbody>
			</table>
		</fieldset>
	</form>
	</fieldset>
	<div id="mask"></div>
</div>
<div style="padding-top:10px;font-size:14px" >
	<div style="text-align:left;padding:10px;width:90%;float:left;">
		<div id="top_icon" style="padding-top:0;">
		  <div align="center">
			<div><a href="#"><img src="<?php echo BASE_PATH ?>/public/images/icons/add_icon.png" alt="big_settings" width="25" height="26" border="0" /></a></div>
					<span class="toplinks">
			  <a href="#" onclick="showDialogPage()"><span class="toplinks">THÊM PAGE</span></a></span><br />
		  </div>
		</div>
	</div>
	<fieldset>
		<legend>Danh Sách Page</legend>
		<div id="datagrid">
			<table width="99%">
				<thead>
					<tr class="ui-accordion-header ui-helper-reset ui-state-default ui-corner-all" style="font-weight:bold;height:20px;text-align:center;">
						<td width="20px">#</td>
						<td>Tiêu đề</td>
						<td>URL View</td>
						<td>Menu</td>
						<td width="110px">Ngày cập nhật</td>
						<td width="110px">Người cập nhật</td>
						<td>Active</td>
						<td width="40px">Xử lý</td>
					</tr>
				</thead>
			</table>
		</div>
	</fieldset>
</div>
<script type="text/javascript">
	var objediting; //Object luu lai row dang chinh sua
	function message(msg,type) {
		if(type==1) { //Thong diep thong bao
			str = "<div class='positive'><span class='bodytext' style='padding-left:30px;'><strong>"+msg+"</strong></span></div>";
			byId("msg").innerHTML = str;
		} else if(type == 0) { //Thong diep bao loi
			str = "<div class='negative'><span class='bodytext' style='padding-left:30px;'><strong>"+msg+"</strong></span></div>";
			byId("msg").innerHTML = str;
		}
	}
	function fillAlias() {
		value = byId("page_title").value;
		byId("page_alias").value = remove_space(remove_accents(value));
	}
	function showDialogPage() {
		doReset();
		showDialog('#dialogPage');
	}
	function fillFormValues(cells) { //Lấy giá trị từ row được chọn đưa lên form (click vào nút "Chọn")		
		byId("page_id").value = $.trim($(cells.td_id).text());
		byId("page_title").value = $.trim($(cells.td_title).text());		
		byId("page_alias").value = $.trim($(cells.td_alias).text());		
		byId("page_menu").value = $.trim($(cells.td_menu).text());		
	}
	function setRowValues(cells) { //Set giá trị từ form xuống row edit	
		$(cells.td_id).text(byId("page_id").value);
		$(cells.td_title).text(byId("page_title").value);			
		$(cells.td_alias).text(byId("page_alias").value);			
		$(cells.td_menu).text(byId("page_menu").value);			
		$(cells.td_urlview).text("page/view/"+byId("page_id").value+"/"+byId("page_alias").value);			
	}
	function select_row(_this) {
		//jsdebug(_this);
		doReset();	
		showDialog("#dialogPage");
		var tr = _this.parentNode.parentNode;
		var cells = tr.cells;
		tr.style.backgroundColor = CONST_ROWSELECTED_COLOR;	
		objediting = tr;			
		fillFormValues(cells);
		block("#dialogPage #dialog");
		$.ajax({
			type: "GET",
			cache: false,
			url : url("/page/getContentById/"+ $.trim($(cells.td_id).text())),
			success: function(data){
				unblock("#dialogPage #dialog");
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/admin/login");
					return;
				}
				$('#page_content').html(data);		
			},
			error: function(data){ unblock("#dialogPage #dialog");alert (data);}	
		});
		return false;
	}
	function doReset() {
		$("#formPage")[0].reset(); //Reset form cua jquery, giu lai gia tri mac dinh cua cac field	
		if(objediting)
			objediting.style.backgroundColor = '';
		byId("page_id").value="";
		$('#page_content').html("");
		$("#formPage :input").css('border-color','');
		byId("msg").innerHTML="";
	}
	function loadListPages() {
		block("#datagrid");
		$.ajax({
			type : "GET",
			cache: false,
			url: url("/page/listPages/true"),
			success : function(data){	
				//alert(data);
				unblock("#datagrid");
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/admin/login");
				} else {
					$("#datagrid").html(data);
					$("input:submit, input:button", "#datagrid").button();	
				}
				
			},
			error: function(data){ 
				unblock("#datagrid");
				alert (data);
			}			
		});
	}
	var isUpdate = false;
	function savePage() {
		checkValidate=true;
		validate(['require'],'page_title',["Vui lòng nhập tiêu đề Trang!"]);
		if(checkValidate == false)
			return;
		isUpdate = false;
		if(byId("page_id").value!="") {
			if(!confirm("Bạn muốn cập nhật Page này?"))
				return;
			isUpdate = true;
		}
		if(byId("page_alias").value=="") {
			fillAlias();
		}
		dataString = $("#formPage").serialize();
		//alert(dataString);return;
		byId("msg").innerHTML="";
		block("#dialogPage #dialog");
		$.ajax({
			type: "POST",
			cache: false,
			url : url("/page/savePage&"),
			data: dataString,
			success: function(data){
				unblock("#dialogPage #dialog");	
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/admin/login");
					return;
				}
				if(data == AJAX_ERROR_SYSTEM) {
					//Load luoi du lieu		
					message('Lưu Page không thành công!',0);
				} else {
					if(isUpdate == true) {
						var cells = objediting.cells;
						var jsonObj = eval( "(" + data + ")" );
						$(cells.td_datemodified).text(jsonObj.datemodified);
						$(cells.td_usermodified).text(jsonObj.usermodified);
						setRowValues(cells);
					} else {
						loadListPages();
					}
					message("Lưu Page thành công!",1);					
				}
			},
			error: function(data){ unblock("#dialogPage #dialog");alert (data);}	
		});
	}
	function deletePage() {
		if(byId("page_id").value=="") {
			alert("Vui lòng chọn page cần xóa!");
			return;
		}
		if(!confirm("Bạn muốn xóa page này?"))
			return;
		byId("msg").innerHTML="";
		block("#dialogPage #dialog");
		$.ajax({
			type: "GET",
			cache: false,
			url : url("/page/deletePage&id="+byId("page_id").value),
			success: function(data){
				unblock("#dialogPage #dialog");	
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/admin/login");
					return;
				}
				if(data == AJAX_ERROR_SYSTEM) {
					//Load luoi du lieu		
					message('Thao tác bị lỗi!',0);	
				} else {
					closeDialog('#dialogPage');
					loadListPages(1);
					message("Xóa page thành công!",1);					
				}
			},
			error: function(data){ unblock("#dialogPage #dialog");alert (data);}	
		});
	}
	function doActive(_this) {
		var cells = _this.parentNode.parentNode.cells;
		block("#content");
		$.ajax({
			type: "GET",
			cache: false,
			url : url("/page/activePage/"+$(cells.td_id).text()),
			success: function(data){
				unblock("#content");
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/admin/login");
					return;
				}
				if (data == AJAX_DONE) {					
					message("Active Page thành công!",1);
					$(cells.td_active).html("<div class='active' onclick='doUnActive(this)' title='Bỏ Active Page này'></div>");
				} else {
					message("Active Page không thành công!",0);
				}															
			},
			error: function(data){ alert (data);unblock("#content");}	
		});
	}
	function doUnActive(_this) {
		var cells = _this.parentNode.parentNode.cells;
		block("#content");
		$.ajax({
			type: "GET",
			cache: false,
			url : url("/page/unActivePage/"+$(cells.td_id).text()),
			success: function(data){
				unblock("#content");
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/admin/login");
					return;
				}
				if (data == AJAX_DONE) {					
					message("Bỏ Active Page thành công!",1);
					$(cells.td_active).html("<div class='inactive' onclick='doActive(this)' title='Active Page này'></div>");
				} else {
					message("Bỏ Active Page không thành công!",0);
				}															
			},
			error: function(data){ alert (data);unblock("#content");}	
		});
	}
	$(document).ready(function(){				
		$("#title_page").text("Quản Trị Page");
		$('#page_content').tinymce({
			script_url : url_base+'/public/js/tiny_mce/tiny_mce.js',
			theme : "advanced",
			width : 300,
			plugins : "pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",
			theme_advanced_buttons1 : "newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
			theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,code,|,preview,|,forecolor,backcolor",
			theme_advanced_buttons3 : "tablecontrols,emotions,media",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "bottom",
			theme_advanced_resizing : true,
			relative_urls : false,
			convert_urls : false,
			content_css : "css/content.css"
		});
		loadListPages();
	});
</script>