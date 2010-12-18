<style> 	
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
<div class="boxes" id="dialogMenu" >
	<fieldset id="dialog" class="window">
		<div class="ui-dialog-titlebar ui-widget-header ui-corner-top ui-helper-clearfix" style="text-align: center; font-size: 13pt; padding: 2px;margin-bottom:3px;" ><span id="title_dialog">Menu Form</span>
		<a href="#" onclick="closeDialog('#dialogMenu')" class="ui-dialog-titlebar-close ui-corner-all" role="button" unselectable="on" style="-moz-user-select: none; float: right;"><span class="ui-icon ui-icon-closethick" unselectable="on" style="-moz-user-select: none;">close</span></a>
		</div>
		<form id="formMenu">
		<fieldset>
			<legend><span style="font-weight:bold;">Thông Tin Menu</span></legend>
			<table class="center" width="100%">
				<thead>
					<tr>
						<td colspan="4" id="msg">
						</td>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td width="100px" align="left">Id Menu :</td>
						<td align="left">
							<input type="text" name="menu_id" id="menu_id"/>
							<span style="color:red;font-weight:bold;cursor:pointer;" title="Bắt buộc nhập dữ liệu">*</span>
						</td>										
					</tr>
					<tr>
						<td align="left">Tên Menu :</td>
						<td align="left">
							<input type="text" name="menu_name" id="menu_name"/>
							<span style="color:red;font-weight:bold;cursor:pointer;" title="Bắt buộc nhập dữ liệu">*</span>
						</td>										
					</tr>
					<tr>
						<td align="left">URL :</td>
						<td align="left">
							<input type="text" name="menu_url" id="menu_url" style="width:90%;"/>
							<span style="color:red;font-weight:bold;cursor:pointer;" title="Bắt buộc nhập dữ liệu">*</span>
						</td>										
					</tr>
					<tr>
						<td align="left">Thứ Tự :</td>
						<td align="left">
							<select name="menu_order" id="menu_order">
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
							</select>
						</td>										
					</tr>
					<tr>
						<td colspan="6" align="center" height="50px">
							<input onclick="saveMenu()" value="Lưu" type="button">
							<input onclick="deleteMenu()" value="Xóa" type="button">
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
			  <a href="#" onclick="showDialogMenu()"><span class="toplinks">THÊM MENU</span></a></span><br />
		  </div>
		</div>
	</div>
	<fieldset>
		<legend>Danh Sách Menu</legend>
		<div id="datagrid">
			<table width="99%">
				<thead>
					<tr class="ui-accordion-header ui-helper-reset ui-state-default ui-corner-all" style="font-weight:bold;height:20px;text-align:center;">
						<td width="20px">#</td>
						<td>Tên Menu</td>
						<td>URL</td>
						<td>Thứ tự</td>
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
	function showDialogMenu() {
		doReset();
		isUpdate = false;
		showDialog('#dialogMenu',500);
	}
	function fillFormValues(cells) { //Lấy giá trị từ row được chọn đưa lên form (click vào nút "Chọn")		
		byId("menu_id").value = $.trim($(cells.td_id).text());
		byId("menu_name").value = $.trim($(cells.td_name).text());
		byId("menu_order").value = $.trim($(cells.td_order).text());
		byId("menu_url").value = $.trim($(cells.td_url).text());	
		$("#menu_id").attr("readonly", true); 
		isUpdate = true;
	}
	function setRowValues(cells) { //Set giá trị từ form xuống row edit	
		$(cells.td_id).text(byId("menu_id").value);
		$(cells.td_name).text(byId("menu_name").value);
		$(cells.td_order).text(byId("menu_order").value);
		$(cells.td_url).text(byId("menu_url").value);			
	}
	function select_row(_this) {
		//jsdebug(_this);
		doReset();	
		showDialog("#dialogMenu");
		var tr = _this.parentNode.parentNode;
		var cells = tr.cells;
		tr.style.backgroundColor = CONST_ROWSELECTED_COLOR;	
		objediting = tr;			
		fillFormValues(cells);
		return false;
	}
	function doReset() {
		$("#formMenu")[0].reset(); //Reset form cua jquery, giu lai gia tri mac dinh cua cac field	
		if(objediting)
			objediting.style.backgroundColor = '';
		byId("menu_id").value="";
		$('#menu_id').removeAttr("readonly");
		$("#formMenu :input").css('border-color','');
		byId("msg").innerHTML="";
	}
	function loadListMenus() {
		block("#datagrid");
		$.ajax({
			type : "GET",
			cache: false,
			url: url("/menu/listMenus/true"),
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
	function saveMenu() {
		checkValidate=true;
		validate(['require'],'menu_id',["Vui lòng nhập ID Menu!"]);
		validate(['require'],'menu_name',["Vui lòng nhập tên Menu!"]);
		validate(['require'],'menu_url',["Vui lòng nhập URL!"]);
		if(checkValidate == false)
			return;
		dataString = $("#formMenu").serialize();
		byId("msg").innerHTML="";
		if(isUpdate==true) {
			if(!confirm("Bạn muốn cập nhật Menu này?"))
				return;
			block("#dialogMenu #dialog");
			//alert(dataString);return;
			$.ajax({
				type: "POST",
				cache: false,
				url : url("/menu/saveMenu&"),
				data: dataString,
				success: function(data){
					unblock("#dialogMenu #dialog");	
					if(data == AJAX_ERROR_NOTLOGIN) {
						location.href = url("/admin/login");
						return;
					}
					if(data == AJAX_DONE) {
						//Load luoi du lieu	
						message("Lưu Menu thành công!",1);
						var cells = objediting.cells;
						setRowValues(cells);														
					} else {
						message('Lưu Menu không thành công!',0);										
					}
				},
				error: function(data){ unblock("#dialogMenu #dialog");alert (data);}	
			});
		} else {
			block("#dialogMenu #dialog");
			$.ajax({
				type: "GET",
				cache: false,
				url : url("/menu/exist/"+byId("menu_id").value),
				success: function(data){
					if(data == AJAX_ERROR_NOTLOGIN) {
						location.href = url("/admin/login");
						return;
					}
					if(data == "0") {
						$.ajax({
							type: "POST",
							cache: false,
							url : url("/menu/saveMenu&"),
							data: dataString,
							success: function(data){
								unblock("#dialogMenu #dialog");	
								if(data == AJAX_ERROR_NOTLOGIN) {
									location.href = url("/admin/login");
									return;
								}
								if(data == AJAX_DONE) {
									//Load luoi du lieu	
									message("Lưu Menu thành công!",1);
									loadListMenus();													
								} else {
									message('Lưu Menu không thành công!',0);										
								}
							},
							error: function(data){ unblock("#dialogMenu #dialog");alert (data);}	
						});														
					} else if(data=="1") {
						unblock("#dialogMenu #dialog");
						message('ID Menu này đã tồn tại!',0);
						byId("menu_id").focus();
					} else {
						unblock("#dialogMenu #dialog");
						message('Lưu Menu không thành công!',0);										
					}
				},
				error: function(data){ unblock("#dialogMenu #dialog");alert (data);}	
			});
		}
	}
	function deleteMenu() {
		if(byId("menu_id").value=="") {
			alert("Vui lòng chọn menu cần xóa!");
			return;
		}
		if(!confirm("Bạn muốn xóa menu này?"))
			return;
		byId("msg").innerHTML="";
		block("#dialogMenu #dialog");
		$.ajax({
			type: "POST",
			cache: false,
			url : url("/menu/deleteMenu&id="+byId("menu_id").value),
			success: function(data){
				unblock("#dialogMenu #dialog");	
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/admin/login");
					return;
				}
				if(data == AJAX_ERROR_SYSTEM) {
					//Load luoi du lieu		
					message('Thao tác bị lỗi!',0);	
				} else {
					closeDialog('#dialogMenu');
					loadListMenus(1);
					message("Xóa menu thành công!",1);					
				}
			},
			error: function(data){ unblock("#dialogMenu #dialog");alert (data);}	
		});
	}
	function doActive(_this) {
		var cells = _this.parentNode.parentNode.cells;
		//alert($(cells.td_id).text());return;
		block("#content");
		$.ajax({
			type: "GET",
			cache: false,
			url : url("/menu/activeMenu/"+$(cells.td_id).text()),
			success: function(data){
				unblock("#content");
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/admin/login");
					return;
				}
				if (data == AJAX_DONE) {					
					message("Active Menu thành công!",1);
					$(cells.td_active).html("<div class='active' onclick='doUnActive(this)' title='Bỏ Active Menu này'></div>");
				} else {
					message("Active Menu không thành công!",0);
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
			url : url("/menu/unActiveMenu/"+$(cells.td_id).text()),
			success: function(data){
				unblock("#content");
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/admin/login");
					return;
				}
				if (data == AJAX_DONE) {					
					message("Bỏ Active Menu thành công!",1);
					$(cells.td_active).html("<div class='inactive' onclick='doActive(this)' title='Active Menu này'></div>");
				} else {
					message("Bỏ Active Menu không thành công!",0);
				}															
			},
			error: function(data){ alert (data);unblock("#content");}	
		});
	}
	$(document).ready(function(){				
		//$("#widget_content").css("width","300px");
		$("#title_page").text("Quản Trị Menu");
		loadListMenus();
	});
</script>