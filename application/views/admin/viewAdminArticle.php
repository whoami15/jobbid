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
<div class="boxes" id="dialogArticle" >
	<fieldset id="dialog" class="window">
		<div class="ui-dialog-titlebar ui-widget-header ui-corner-top ui-helper-clearfix" style="text-align: center; font-size: 13pt; padding: 2px;margin-bottom:3px;" ><span id="title_dialog">Tin Tức Form</span>
		<a href="#" onclick="closeDialog('#dialogArticle')" class="ui-dialog-titlebar-close ui-corner-all" role="button" unselectable="on" style="-moz-user-select: none; float: right;"><span class="ui-icon ui-icon-closethick" unselectable="on" style="-moz-user-select: none;">close</span></a>
		</div>
		<form id="formArticle">
		<input type="hidden" name="article_id" id="article_id" />
		<fieldset>
			<legend><span style="font-weight:bold;">Thông Tin Tin Tức</span></legend>
			<table class="center" width="80%">
				<thead>
					<tr>
						<td colspan="4" id="msg">
						</td>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td width="95px" align="left">Tiêu Đề :</td>
						<td align="left">
							<input type="text" name="article_title" id="article_title" style="width:95%" onblur="fillAlias()"/>
							<span style="color:red;font-weight:bold;cursor:pointer;" title="Bắt buộc nhập dữ liệu">*</span>
						</td>										
					</tr>
					<tr>
						<td align="left">URL Alias :</td>
						<td align="left">
							<input type="text" name="article_alias" id="article_alias" style="width:95%"/>
						</td>										
					</tr>
					<tr>
						<td align="left">Hình đại diện :</td>
						<td align="left">
							<input type="text" name="article_imagedes" id="article_imagedes" style="width:75%"/>
							<a href="#" onclick="showImagesPanel()">Mở Gallery</a>
						</td>										
					</tr>
					<tr>
						<td  align="left">Tóm tắt :</td>
						<td align="left">
							<textarea name="article_contentdes" id="article_contentdes" rows="2" cols="59"></textarea>
						</td>
					</tr>					
					<tr>
						<td colspan="2" align="left">
						Nội dung : <br/>
						<textarea name="article_content" id="article_content" class="tinymce"></textarea>
						</td>
					</tr>					
					<tr>
						<td colspan="6" align="center" height="50px">
							<input onclick="saveArticle()" value="Lưu" type="button">
							<input onclick="deleteArticle()" value="Xóa" type="button">
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
			  <a href="#" onclick="showDialogArticle()"><span class="toplinks">THÊM TIN</span></a></span><br />
		  </div>
		</div>
	</div>
	<fieldset>
		<legend>Danh Sách Tin Tức</legend>
		<div id="datagrid">
			<table width="99%">
				<thead>
					<tr class="ui-accordion-header ui-helper-reset ui-state-default ui-corner-all" style="font-weight:bold;height:20px;text-align:center;">
						<td width="20px">#</td>
						<td>Tiêu đề</td>
						<td>Ngày cập nhật</td>
						<td>Người cập nhật</td>
						<td>Lượt xem</td>
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
		value = byId("article_title").value;
		byId("article_alias").value = remove_space(remove_accents(value));
	}
	function showDialogArticle() {
		doReset();
		showDialog('#dialogArticle');
	}
	function selectpage(page) {
		loadListArticles(page);
	};
	function fillFormValues(cells) { //Lấy giá trị từ row được chọn đưa lên form (click vào nút "Chọn")		
		byId("article_id").value = $.trim($(cells.td_id).text());
		byId("article_title").value = $.trim($(cells.td_title).text());		
		byId("article_alias").value = $.trim($(cells.td_alias).text());		
		byId("article_imagedes").value = $.trim($(cells.td_imagedes).text());		
		byId("article_contentdes").value = $.trim($(cells.td_contentdes).text());		
	}
	function setRowValues(cells) { //Set giá trị từ form xuống row edit	
		$(cells.td_id).text(byId("article_id").value);
		$(cells.td_title).text(byId("article_title").value);			
		$(cells.td_alias).text(byId("article_alias").value);			
		$(cells.td_imagedes).text(byId("article_imagedes").value);			
		$(cells.td_contentdes).text(byId("article_contentdes").value);			
	}
	function select_row(_this) {
		//jsdebug(_this);
		doReset();	
		showDialog("#dialogArticle");
		var tr = _this.parentNode.parentNode;
		var cells = tr.cells;
		tr.style.backgroundColor = CONST_ROWSELECTED_COLOR;	
		objediting = tr;			
		fillFormValues(cells);
		block("#dialogArticle #dialog");
		$.ajax({
			type: "GET",
			cache: false,
			url : url("/article/getContentById/"+ $.trim($(cells.td_id).text())),
			success: function(data){
				unblock("#dialogArticle #dialog");
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/admin/login");
					return;
				}
				$('#article_content').html(data);		
			},
			error: function(data){ unblock("#dialogArticle #dialog");alert (data);}	
		});
		return false;
	}
	function doReset() {
		$("#formArticle")[0].reset(); //Reset form cua jquery, giu lai gia tri mac dinh cua cac field	
		if(objediting)
			objediting.style.backgroundColor = '';
		byId("article_id").value="";
		$('#article_content').html("");
		$("#formArticle :input").css('border-color','');
		byId("msg").innerHTML="";
	}
	function loadListArticles(page) {
		block("#datagrid");
		$.ajax({
			type : "GET",
			cache: false,
			url: url("/article/listArticles/"+page),
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
	function saveArticle() {
		checkValidate=true;
		validate(['require'],'article_title',["Vui lòng nhập tiêu đề!"]);
		if(checkValidate == false)
			return;
		isUpdate = false;
		if(byId("article_id").value!="") {
			if(!confirm("Bạn muốn cập nhật Tin Tức này?"))
				return;
			isUpdate = true;
		}
		if(byId("article_alias").value=="") {
			fillAlias();
		}
		dataString = $("#formArticle").serialize();
		//alert(dataString);return;
		byId("msg").innerHTML="";
		block("#dialogArticle #dialog");
		$.ajax({
			type: "POST",
			cache: false,
			url : url("/article/saveArticle&"),
			data: dataString,
			success: function(data){
				unblock("#dialogArticle #dialog");
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/admin/login");
					return;
				}
				if(data == AJAX_ERROR_SYSTEM) {
					//Load luoi du lieu		
					message('Lưu Tin Tức không thành công!',0);	
				} else {
					if(isUpdate == true) {
						var cells = objediting.cells;
						var jsonObj = eval( "(" + data + ")" );
						$(cells.td_datemodified).text(jsonObj.datemodified);
						$(cells.td_usermodified).text(jsonObj.usermodified);
						setRowValues(cells);
					} else {
						loadListArticles(1);
					}
					message("Lưu Tin Tức thành công!",1);					
				}
			},
			error: function(data){ unblock("#dialogArticle #dialog");alert (data);}	
		});
	}
	function deleteArticle() {
		if(byId("article_id").value=="") {
			alert("Vui lòng chọn tin cần xóa!");
			return;
		}
		if(!confirm("Bạn muốn xóa tin này?"))
			return;
		byId("msg").innerHTML="";
		block("#dialogArticle #dialog");
		$.ajax({
			type: "POST",
			cache: false,
			url : url("/article/deleteArticle&id="+byId("article_id").value),
			success: function(data){
				unblock("#dialogArticle #dialog");	
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/admin/login");
					return;
				}
				if(data == AJAX_ERROR_SYSTEM) {
					//Load luoi du lieu		
					message('Thao tác bị lỗi!',0);	
				} else {
					closeDialog('#dialogArticle');
					loadListArticles(1);
					message("Xóa tin thành công!",1);					
				}
			},
			error: function(data){ unblock("#dialogArticle #dialog");alert (data);}	
		});
	}
	function doActive(_this) {
		var cells = _this.parentNode.parentNode.cells;
		block("#content");
		$.ajax({
			type: "GET",
			cache: false,
			url : url("/article/activeArticle/"+$(cells.td_id).text()),
			success: function(data){
				unblock("#content");
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/admin/login");
					return;
				}
				if (data == AJAX_DONE) {					
					message("Active Tin Tức thành công!",1);
					$(cells.td_active).html("<div class='active' onclick='doUnActive(this)' title='Bỏ Active Tin Tức này'></div>");
				} else {
					message("Active Tin Tức không thành công!",0);
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
			url : url("/article/unActiveArticle/"+$(cells.td_id).text()),
			success: function(data){
				unblock("#content");
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/admin/login");
					return;
				}
				if (data == AJAX_DONE) {					
					message("Bỏ Active Tin Tức thành công!",1);
					$(cells.td_active).html("<div class='inactive' onclick='doActive(this)' title='Active Tin Tức này'></div>");
				} else {
					message("Bỏ Active Tin Tức không thành công!",0);
				}															
			},
			error: function(data){ alert (data);unblock("#content");}	
		});
	}
	$(document).ready(function(){				
		$("#title_page").text("Quản Trị Tin Tức");
		$('#article_content').tinymce({
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
		loadListArticles(1);
	});
</script>