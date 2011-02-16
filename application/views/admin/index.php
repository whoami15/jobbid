<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/tiny_mce/jquery.tinymce.js"></script>
<style type="text/css">
	.multiselect {  
		height:400px;
		width:350px;  
	} 
 	.errorMessage{
 		color: red;
 		font-weight: bold;
 	}  	
	.input {
		width:86%;
	}
	.infoMessage {
		color:green !important;
		font-weight:bold;
	}
	select {
		margin-right:-5px;
	}
	.select {
		width:86%;
	}
	
</style>
<div class="boxes" id="dialogWidget" >
	<fieldset id="dialog" class="window">
		<div class="ui-dialog-titlebar ui-widget-header ui-corner-top ui-helper-clearfix" style="text-align: center; font-size: 13pt; padding: 2px;margin-bottom:3px;" ><span id="title_dialog">Widget Form</span>
		<a href="#" onclick="closeDialog('#dialogWidget')" class="ui-dialog-titlebar-close ui-corner-all" role="button" unselectable="on" style="-moz-user-select: none; float: right;"><span class="ui-icon ui-icon-closethick" unselectable="on" style="-moz-user-select: none;">close</span></a>
		</div>
		<form id="formWidget">
	<input type="hidden" name="widget_id" id="widget_id" />
		<fieldset>
			<legend><span style="font-weight:bold;">Thông Tin Widget</span></legend>
			<table class="center" width="65%">
				<thead>
					<tr>
						<td colspan="4" id="msg">
						</td>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td width="100px" align="left">Tên Widget :</td>
						<td align="left">
							<input type="text" name="widget_name" id="widget_name"/>
						</td>
						<td width="100px" align="left">Vị trí :</td>
						<td align="left">
							<select name="widget_position" id="widget_position">
								<option value="banner" selected>Banner</option>
								<option value="menu">Menu</option>
								<option value="leftcol">Cột Trái</option>
								<option value="rightcol">Cột Phải</option>
								<option value="footer">Footer</option>
							</select>
						</td>
					</tr>
					<tr>
						<td align="left">Thứ tự :</td>
						<td align="left">
							<select name="widget_order" id="widget_order">
								<option value="1" selected>1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
								<option value="6">6</option>
								<option value="7">7</option>
								<option value="8">8</option>
								<option value="9">9</option>
								<option value="10">10</option>
								<option value="11">11</option>
								<option value="12">12</option>
								<option value="13">13</option>
								<option value="14">14</option>
								<option value="15">15</option>
								<option value="16">16</option>
								<option value="17">17</option>
								<option value="18">18</option>
							</select>
						</td>
						<td align="left">
							<input type="checkbox" id="widget_showtitle"/>&nbsp;Hiện title
						</td>
						<td align="left">
							<input type="checkbox" id="widget_iscomponent"/>&nbsp;Component
						</td>
					</tr>
					<tr>
						<td colspan="4" align="left">
						Nội dung : <br/>
						<textarea name="widget_content" id="widget_content" class="tinymce"></textarea>
						</td>
					</tr>
					<tr>
						<td colspan="6" align="center" style="height:50px">
							<input onclick="saveWidget()" value="Lưu" type="button"> 
							<input onclick="deleteWidget()" value="Xóa" type="button">
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
<div style="padding-top:1px;font-size:14px" >
	<div style="text-align:left;padding:10px;width:90%;float:left;">
		<div id="top_icon" style="padding-top:0;">
		  <div align="center">
			<div><a href="#"><img src="<?php echo BASE_PATH ?>/public/images/icons/add_icon.png" alt="big_settings" width="25" height="26" border="0" /></a></div>
					<span class="toplinks">
			  <a href="#" onclick="showDialogWidget()"><span class="toplinks">THÊM WIDGET</span></a></span><br />
		  </div>
		</div>
		<div id="top_icon" style="padding-top:0;">
		  <div align="center">
			<div><a href="#"><img src="<?php echo BASE_PATH ?>/public/images/icons/layout_icon.png" alt="big_settings" width="25" height="26" border="0" /></a></div>
					<span class="toplinks">
			  <a href="#" onclick="viewLayout()"><span class="toplinks">XEM LAYOUT</span></a></span><br />
		  </div>
		</div>
	</div>
	<fieldset>
		<legend>Danh Sách Widget</legend>
		<div id="datagrid">
			<table width="99%">
				<thead>
					<tr class="ui-accordion-header ui-helper-reset ui-state-default ui-corner-all" style="font-weight:bold;height:20px;text-align:center;">
						<td width="10px">#</td>
						<td>Tên widget</td>
						<td>Vị trí</td>
						<td>Thứ tự</td>
						<td>Hiện title</td>
						<td>Component</td>
						<td>Active</td>
						<td>Xử lý</td>
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
	function showDialogWidget() {
		doReset();
		showDialog('#dialogWidget');
	}
	function fillFormValues(cells) { //Lấy giá trị từ row được chọn đưa lên form (click vào nút "Chọn")		
		byId("widget_id").value = $.trim($(cells.td_id).text());
		byId("widget_name").value = $.trim($(cells.td_name).text());
		byId("widget_position").value = $.trim($(cells.td_position).text());
		byId("widget_order").value = $.trim($(cells.td_order).text());
		var showtitle = $.trim($(cells.td_showtitle).text());
		if(showtitle == "Y") {
			byId("widget_showtitle").checked = true;
		} else {
			byId("widget_showtitle").checked = false;
		}
		var iscomponent = $.trim($(cells.td_iscomponent).text());
		if(iscomponent == "Y") {
			byId("widget_iscomponent").checked = true;
		} else {
			byId("widget_iscomponent").checked = false;
		}
	}
	function setRowValues(cells) { //Set giá trị từ form xuống row edit	
		$(cells.td_id).text(byId("widget_id").value);
		$(cells.td_name).text(byId("widget_name").value);
		$(cells.td_position).text(byId("widget_position").value);
		$(cells.td_order).text(byId("widget_order").value);	
		if(byId("widget_showtitle").checked == true) {
			$(cells.td_showtitle).text("Y");
		} else {
			$(cells.td_showtitle).text("N");
		}
		if(byId("widget_iscomponent").checked == true) {
			$(cells.td_iscomponent).text("Y");
		} else {
			$(cells.td_iscomponent).text("N");
		}
	}
	function select_row(_this) {
		//jsdebug(_this);
		doReset();	
		showDialog("#dialogWidget");
		var tr = _this.parentNode.parentNode;
		var cells = tr.cells;
		tr.style.backgroundColor = CONST_ROWSELECTED_COLOR;	
		objediting = tr;			
		fillFormValues(cells);
		block("#dialogWidget #dialog");
		$.ajax({
			type: "GET",
			cache: false,
			url : url("/widget/getContentById/"+ $.trim($(cells.td_id).text())),
			success: function(data){
				unblock("#dialogWidget #dialog");
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/admin/login");
					return;
				}
				$('#widget_content').html(data);		
			},
			error: function(data){ unblock("#dialogWidget #dialog");alert (data);}	
		});
		return false;
	}
	function doReset() {
		$("#formWidget")[0].reset(); //Reset form cua jquery, giu lai gia tri mac dinh cua cac field	
		if(objediting)
			objediting.style.backgroundColor = '';
		byId("widget_id").value="";
		$('#widget_content').html("");
		$("#formWidget :input").css('border-color','');
		byId("msg").innerHTML="";
	}
	function loadListWidgets() {
		block("#datagrid");
		$.ajax({
			type : "GET",
			cache: false,
			url: url("/widget/listWidgets/true"),
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
	function saveWidget() {
		isUpdate = false;
		if(byId("widget_id").value!="") {
			if(!confirm("Bạn muốn cập nhật Widget này?"))
				return;
			isUpdate = true;
		}		
		dataString = $("#formWidget").serialize();
		if(byId("widget_showtitle").checked == true) {
			dataString+="&widget_showtitle=1";
		} else {
			dataString+="&widget_showtitle=0";
		}
		if(byId("widget_iscomponent").checked == true) {
			dataString+="&widget_iscomponent=1";
		} else {
			dataString+="&widget_iscomponent=0";
		}
		//alert(dataString);return;
		block("#dialogWidget #dialog");
		$.ajax({
			type: "POST",
			cache: false,
			url : url("/widget/saveWidget&"),
			data: dataString,
			success: function(data){
				unblock("#dialogWidget #dialog");				
				if(data == AJAX_DONE) {
					//Load luoi du lieu	
					message("Lưu Widget thành công!",1);					
					if(isUpdate == true) {
						var cells = objediting.cells;
						setRowValues(cells);
					} else {
						loadListWidgets();
					}														
				} else {
					message('Lưu Widget không thành công!',0);										
				}
			},
			error: function(data){ unblock("#dialogWidget #dialog");alert (data);}	
		});
	}
	function deleteWidget() {
		if(byId("widget_id").value=="") {
			alert("Vui lòng chọn widget cần xóa!");
			return;
		}
		if(!confirm("Bạn muốn xóa widget này?"))
			return;
		byId("msg").innerHTML="";
		block("#dialogWidget #dialog");
		$.ajax({
			type: "GET",
			cache: false,
			url : url("/widget/deleteWidget&id="+byId("widget_id").value),
			success: function(data){
				unblock("#dialogWidget #dialog");	
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/admin/login");
					return;
				}
				if(data == AJAX_ERROR_SYSTEM) {
					//Load luoi du lieu		
					message('Thao tác bị lỗi!',0);	
				} else {
					closeDialog('#dialogWidget');
					loadListWidgets(1);
					message("Xóa widget thành công!",1);					
				}
			},
			error: function(data){ unblock("#dialogWidget #dialog");alert (data);}	
		});
	}
	function doActive(_this) {
		var cells = _this.parentNode.parentNode.cells;
		block("#content");
		$.ajax({
			type: "GET",
			cache: false,
			url : url("/widget/activeWidget/"+$(cells.td_id).text()),
			success: function(data){
				unblock("#content");
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/admin/login");
					return;
				}
				if (data == AJAX_DONE) {					
					message("Active Widget thành công!",1);
					$(cells.td_active).html("<div class='active' onclick='doUnActive(this)' title='Bỏ Active Widget này'></div>");
				} else {
					message("Active Widget không thành công!",0);
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
			url : url("/widget/unActiveWidget/"+$(cells.td_id).text()),
			success: function(data){
				unblock("#content");
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/admin/login");
					return;
				}
				if (data == AJAX_DONE) {					
					message("Bỏ Active Widget thành công!",1);
					$(cells.td_active).html("<div class='inactive' onclick='doActive(this)' title='Active Widget này'></div>");
				} else {
					message("Bỏ Active Widget không thành công!",0);
				}															
			},
			error: function(data){ alert (data);unblock("#content");}	
		});
	}
	var isChangeLayout = false;
	function viewLayout() {
		isChangeLayout = false;
		$("#dialog_panel").html("");
		$("#dialog_panel").dialog({
			width: 630,
			height:530,
			title:"Quản Lý Layout",
			close: function() {
				if(isChangeLayout==true)
					loadListWidgets();
			},
			buttons: {
				Save: function() {
					dataString = "";
					var top = $("#layout_top").children();
					for(i=0;i<top.length;i++) {
						dataString += "&id[]="+top[i].id+"&position[]=top&order[]="+i;
					}
					var left = $("#layout_leftcol").children();
					for(i=0;i<left.length;i++) {
						dataString += "&id[]="+left[i].id+"&position[]=leftcol&order[]="+i;
					}
					var right = $("#layout_rightcol").children();
					for(i=0;i<right.length;i++) {
						dataString += "&id[]="+right[i].id+"&position[]=rightcol&order[]="+i;
					}
					var bottom = $("#layout_bottom").children();
					for(i=0;i<bottom.length;i++) {
						dataString += "&id[]="+bottom[i].id+"&position[]=bottom&order[]="+i;
					}
					//jsdebug(top);
					//alert(dataString);
					block("#dialog_panel");
					$.ajax({
						type: "POST",
						cache: false,
						url : url("/widget/saveLayout"),
						data: dataString,
						success: function(data){
							unblock("#dialog_panel");
							if(data == AJAX_ERROR_NOTLOGIN) {
								location.href = url("/admin/login");
								return;
							}
							if (data == AJAX_DONE) {					
								layout_msg("Lưu Layout thành công!",1);
								isChangeLayout = true;
							} else {
								layout_msg("Lưu Layout không thành công!",0);
							}															
						},
						error: function(data){ alert (data);unblock("#dialog_panel");}	
					});
				},
				Close: function() {
					$(this).dialog('close');
				}
			}
		});
		$("#dialog_panel").dialog("open");
		block("#dialog_panel");
		$.ajax({
			type: "GET",
			cache: false,
			url : url("/widget/layout"),
			success: function(data){
				unblock("#dialog_panel");
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/admin/login");
					return;
				}
				$("#dialog_panel").html(data);															
			},
			error: function(data){ alert (data);unblock("#dialog_panel");}	
		});
	}
	
	$(document).ready(function(){
		$("#title_page").text("Quản Trị Widget");
		$('#widget_content').tinymce({
			// Location of TinyMCE script
			script_url : url_base+'/public/js/tiny_mce/tiny_mce.js',
			// General options
			theme : "advanced",
			width : 300,
			plugins : "pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",

			// Theme options
			theme_advanced_buttons1 : "newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
			theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,code,|,preview,|,forecolor,backcolor",
			theme_advanced_buttons3 : "tablecontrols,emotions,media",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "bottom",
			theme_advanced_resizing : true,
			relative_urls : false,
			convert_urls : false,
			// Example content CSS (should be your site CSS)
			content_css : "css/content.css"
		});
		
		//$("#widget_content").css("width","300px");
		loadListWidgets();
	});
</script>