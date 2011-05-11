<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/tiny_mce/jquery.tinymce.js"></script>
<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/utils.js"></script>
<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/costtype.js"></script>
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
<div class="boxes" id="dialogDuan" >
	<fieldset id="dialog" class="window">
		<div class="ui-dialog-titlebar ui-widget-header ui-corner-top ui-helper-clearfix" style="text-align: center; font-size: 13pt; padding: 2px;margin-bottom:3px;" ><span id="title_dialog">Form Nhập Dự Án</span>
		<a href="#" onclick="closeDialog('#dialogDuan')" class="ui-dialog-titlebar-close ui-corner-all" role="button" unselectable="on" style="-moz-user-select: none; float: right;"><span class="ui-icon ui-icon-closethick" unselectable="on" style="-moz-user-select: none;">close</span></a>
		</div>
		<form id="formDuan">
		<input type="hidden" name="duan_id" id="duan_id" value=""/>
		<fieldset>
			<legend><span style="font-weight:bold;">Thông Tin Dự Án</span></legend>
			<table class="center" width="100%">
				<thead>
					<tr>
						<td colspan="4" id="msg">
						</td>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td width="80px" align="right">Tên dự án :</td>
						<td align="left">
							<input type="text" name="duan_tenduan" style="width:90%" value="" id="duan_tenduan" onblur="fillAlias()" tabindex=1/><span style="color:red;font-weight:bold;cursor:pointer;" title="Bắt buộc nhập dữ liệu">*</span>
						</td>
						<td align="right">Alias :</td>
						<td align="left">
							<input type="text" name="duan_alias" style="width:90%" value="" id="duan_alias" tabindex=2/>
						</td>
					</tr>	
					<tr>
						<td align="right">Lĩnh vực :</td>
						<td align="left">
							<select name="duan_linhvuc_id" id="duan_linhvuc_id" tabindex=3>
								<?php
								foreach($lstLinhvuc as $linhvuc) {
									echo "<option value='".$linhvuc["linhvuc"]["id"]."'>".$linhvuc["linhvuc"]["tenlinhvuc"]."</option>";
								}
								?>
							</select>
						</td>	
						<td align="right">Tỉnh/TP :</td>
						<td align="left">
							<select name="duan_tinh_id" id="duan_tinh_id" tabindex=4>
								<?php
								foreach($lstTinh as $tinh) {
									echo "<option value='".$tinh["tinh"]["id"]."'>".$tinh["tinh"]["tentinh"]."</option>";
								}
								?>
							</select>
						</td>
					</tr>
					<tr>
						<td align="right">Ưu tiên :</td>
						<td align="left" >
							 <input type="text" name="duan_prior" id="duan_prior" style="width:20%" value="0" tabindex=5/>
						</td>	
						<td align="right">Ngày kết thúc thầu :</td>
						<td align="left" >
							<input  type="text" name="duan_ngayketthuc" id="duan_ngayketthuc"  tabindex=6/> <span style="color:red;font-weight:bold;cursor:pointer;" title="Bắt buộc nhập dữ liệu">*</span>
						</td>
					</tr>
					<tr>
						<td align="right">Chi phí :</td>
						<td align="left" >
							<input type="hidden" name="duan_costmin" id="duan_costmin" value="0"/>
							<input type="hidden" name="duan_costmax" id="duan_costmax" value="0"/>
							<select id="duan_cost" tabindex=7>
								<option value="">---Chọn chi phí---</option>
							</select> (VNĐ)
						</td>	
						<td align="right">Loại dự án</td>
						<td align="left" >
							<select id="duan_isbid" name="duan_isbid" tabindex=7>
								<option value="0">Liên hệ trực tiếp</option>
								<option value="1">Đấu thầu tự do</option>
							</select>
						</td>
					</tr>
					<tr>
						<td align="left" colspan="4">
							Thông tin chi tiết :(<a href="#" onclick="showImagesPanel()">Mở Gallery</a>)<br/>
							<textarea name="duan_thongtinchitiet" id="duan_thongtinchitiet" class="tinymce" tabindex=8></textarea>
						</td>
					</tr>
					<tr>
						<td colspan="4" align="center" height="50px">
							<input onclick="saveDuan()" value="Lưu" type="button" tabindex=9>
							<input onclick="deleteDuan()" value="Xóa" type="button" tabindex=9>
							<input onclick="convertRaovat()" value="Chuyển rao vặt" type="button" tabindex=9>
							<input onclick="doReset()" value="Reset" type="button" tabindex=10>
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
	<fieldset>
		<legend>Lọc kết quả</legend>
		<table>
		<tbody>
			<tr height="30px">
				<td width="80px">Từ khóa :</td>
				<td><input type="text" id="cond_keyword" style="width:200px" /></td>
				<td width="95px">Người đăng :</td>
				<td><input type="text" id="cond_account" style="width:200px" /></td>
				<td>
					<input type="checkbox" id="cond_exprired" /> Dự án hết hạn đấu giá<br/>
				</td>
			</tr>
			<tr height="30px">
			<td colspan="5" align="center">
				<input onclick="doFilter()" value="Tìm Kiếm" type="button">
			</td>
			</tr>
		</tbody>
		</table>
	</fieldset>
	<fieldset>
		<legend>Danh Sách Dự Án</legend>
		<div id="datagrid">
			<table width="99%">
				<thead>
					<tr class="ui-accordion-header ui-helper-reset ui-state-default ui-corner-all" style="font-weight:bold;height:20px;text-align:center;">
						<td>ID</td>
						<td>Tên dự án</td>
						<td>Lĩnh vực</td>
						<td>Người post</td>
						<td>Chủ dự án</td>
						<td>Prior</td>
						<td>Ngày Post</td>
						<td>Status</td>
						<td width="40px">Xử lý</td>
					</tr>
				</thead>
			</table>
		</div>
	</fieldset>
</div>
<script type="text/javascript">
	var objediting; //Object luu lai row dang chinh sua
	var searchString;
	var nPage = 1;
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
		value = byId("duan_tenduan").value;
		byId("duan_alias").value = remove_space(remove_accents(value));
	}
	function showDialogDuan() {
		doReset();
		showDialog('#dialogDuan',700);
	}
	function selectpage(page) {
		nPage = page;
		loadListDuans(page+searchString);
	};
	function fillFormValues(cells) { 		
		byId("duan_id").value = $.trim($(cells.td_id).text());
		byId("duan_tenduan").value = $.trim($(cells.td_tenduan).text());
		byId("duan_alias").value = $.trim($(cells.td_alias).text());
		byId("duan_linhvuc_id").value = $.trim($(cells.td_linhvuc_id).text());
		byId("duan_tinh_id").value = $.trim($(cells.td_tinh_id).text());
		byId("duan_ngayketthuc").value = $.trim($(cells.td_ngayketthuc).text());
		byId("duan_prior").value = $.trim($(cells.td_prior).text());
		byId("duan_isbid").value = $.trim($(cells.td_isbid).text());
	}
	function setRowValues(cells) {
		$(cells.td_id).text(byId("duan_id").value);
		$(cells.td_tenduan).text(byId("duan_tenduan").value);
		$(cells.td_alias).text(byId("duan_alias").value);
		$(cells.td_linhvuc_id).text(byId("duan_linhvuc_id").value);
		var tmp = byId("duan_linhvuc_id");
		$(cells.td_linhvuc_display).text(tmp[tmp.selectedIndex].textContent);
		$(cells.td_tinh_id).text(byId("duan_tinh_id").value);
		$(cells.td_ngayketthuc).text(byId("duan_ngayketthuc").value);
		$(cells.td_prior).text(byId("duan_prior").value);
		$(cells.td_isbid).text(byId("duan_isbid").value);
		var value = byId("duan_cost").value;
		if(value!="") {
			var tmp = byId("duan_cost");
			$(cells.td_costtype).text(tmp[tmp.selectedIndex].textContent);
		}
	}
	function select_row(_this) {
		//jsdebug(_this);
		doReset();	
		showDialog('#dialogDuan',700);
		var tr = _this.parentNode.parentNode;
		var cells = tr.cells;
		tr.style.backgroundColor = CONST_ROWSELECTED_COLOR;	
		objediting = tr;			
		fillFormValues(cells);
		block("#dialogDuan #dialog");
		$.ajax({
			type: "GET",
			cache: false,
			url: url("/duan/getThongtinchitietById/"+byId("duan_id").value),
			success: function(data){
				unblock("#dialogDuan #dialog");
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/admin/login");
					return;
				}
				$('#duan_thongtinchitiet').html(data);		
			},
			error: function(data){ unblock("#dialogDuan #dialog");alert (data);}	
		});
		return false;
	}
	function doReset() {
		$("#formDuan")[0].reset(); //Reset form cua jquery, giu lai gia tri mac dinh cua cac field	
		if(objediting)
			objediting.style.backgroundColor = '';
		//Reset hidden field
		byId("duan_id").value = '';
		//Reset editor
		$("#duan_thongtinchitiet").html("");
		//Bo cac field da set readonly
		$("#formDuan :input").css('border-color','');
		byId("msg").innerHTML="";
	}
	function loadListDuans(dataString) {
		block("#datagrid");
		$.ajax({
			type : "GET",
			cache: false,
			url: url("/duan/listDuans/"+dataString),
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
	function deleteDuan() {
		duan_id = byId("duan_id").value;
		if(duan_id=="")
			return;
		if(!confirm("Bạn muốn xóa dự án này?"))
			return;
		byId("msg").innerHTML="";
		block("#dialogDuan #dialog");
		$.ajax({
			type: "GET",
			cache: false,
			url : url("/duan/delete&duan_id="+duan_id),
			success: function(data){
				unblock("#dialogDuan #dialog");	
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/admin/login");
					return;
				}
				if(data == "DONE") {
					//Load luoi du lieu	
					
					loadListDuans(nPage+searchString);
					byId("duan_id").value = "";
					message("Xóa dự án thành công!",1);	
				} else {
					message('Xóa dự án không thành công!',0);					
				}
			},
			error: function(data){ unblock("#dialogDuan #dialog");alert (data);}	
		});
	}
	var isUpdate = false;
	function saveDuan() {
		checkValidate=true;
		validate(['require'],'duan_tenduan',["Vui lòng nhập tên dự án!"]);
		validate(['number'],'duan_prior',["Vui lòng nhập số!"]);
		validate(['require','checkdate'],'duan_ngayketthuc',["Vui lòng nhập ngày kết thúc"]);
		if(checkValidate == false)
			return;
		isUpdate = false;
		if(byId("duan_id").value!="") {
			if(!confirm("Bạn muốn cập nhật dự án này?"))
				return;
			isUpdate = true;
		}
		var value = byId("duan_cost").value;
		if(value!="") {
			byId("duan_costmin").value = arrCostType[value].min;
			byId("duan_costmax").value = arrCostType[value].max;
		}
		if(byId("duan_alias").value=="") {
			fillAlias();
		}
		dataString = $("#formDuan").serialize()+'&duan_data='+$("iframe").contents().find("body#tinymce").text();
		//alert(dataString);return;
		byId("msg").innerHTML="";
		block("#dialogDuan #dialog");
		$.ajax({
			type: "POST",
			cache: false,
			url : url("/duan/saveDuan&"),
			data: dataString,
			success: function(data){
				unblock("#dialogDuan #dialog");	
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/admin/login");
					return;
				}
				if(data == "DONE") {
					//Load luoi du lieu		
					if(isUpdate == true) {
						var cells = objediting.cells;
						setRowValues(cells);
					} else {
						loadListDuans('1'+searchString);
					}
					message("Lưu dự án thành công!",1);	
				} else {
					message('Lưu dự án không thành công!',0);					
				}
			},
			error: function(data){ unblock("#dialogDuan #dialog");alert (data);}	
		});
	}
	function doActive(_this) {
		var cells = _this.parentNode.parentNode.cells;
		block("#content");
		$.ajax({
			type: "GET",
			cache: false,
			url : url("/duan/activeDuan/"+$(cells.td_id).text()),
			success: function(data){
				unblock("#content");
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/admin/login");
					return;
				}
				if (data == AJAX_DONE) {					
					message("Active dự án thành công!",1);
					$(cells.td_active).html("<div class='active' onclick='doUnActive(this)' title='Unactive'></div>");
				} else {
					message("Active dự án không thành công!",0);
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
			url : url("/duan/unActiveDuan/"+$(cells.td_id).text()),
			success: function(data){
				unblock("#content");
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/admin/login");
					return;
				}
				if (data == AJAX_DONE) {					
					message("Bỏ Active dự án thành công!",1);
					$(cells.td_active).html("<div class='inactive' onclick='doActive(this)' title='Active'></div>");
				} else {
					message("Bỏ Active dự án không thành công!",0);
				}															
			},
			error: function(data){ alert (data);unblock("#content");}	
		});
	}
	function doFilter() {	
		searchString = "&cond_exprired="+byId("cond_exprired").checked+"&cond_keyword="+byId("cond_keyword").value+"&cond_account="+byId("cond_account").value;
		loadListDuans('1'+searchString);
	}
	function convertRaovat() {
		duan_id = byId("duan_id").value;
		if(duan_id==null)
			return;
		if(!confirm("Bạn muốn chuyển dự án này sang mục tin rao vặt?"))
			return;
		byId("msg").innerHTML="";
		block("#dialogDuan #dialog");
		$.ajax({
			type: "GET",
			cache: false,
			url : url("/raovat/duan2raovat/"+duan_id),
			success: function(data){
				unblock("#dialogDuan #dialog");	
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/admin/login");
					return;
				}
				if(data == "DONE") {
					//Load luoi du lieu		
					if(isUpdate == true) {
						var cells = objediting.cells;
						setRowValues(cells);
					} else {
						loadListDuans(nPage+searchString);
					}
					message("Chuyển dự án sang rao vặt thành công!",1);	
				} else {
					message('Thao tác không thành công!',0);					
				}
			},
			error: function(data){ unblock("#dialogDuan #dialog");alert (data);}	
		});
	}
	$(document).ready(function(){				
		$("#title_page").text("Quản Trị Dự Án");
		byId("cond_exprired").checked = false;
		for(i=0;arrCostType[i]!=null;i++) {
			$('#duan_cost').append("<option value="+arrCostType[i].id+" >"+arrCostType[i].costtype+"</option>");
		}
		$('#duan_ngayketthuc').datepicker({
			dateFormat: "dd/mm/yy",
			changeMonth: true,
			changeYear: true
		});
		$('#duan_thongtinchitiet').tinymce({
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
		searchString = '&cond_exprired=false';
		loadListDuans('1'+searchString);
	});
</script>