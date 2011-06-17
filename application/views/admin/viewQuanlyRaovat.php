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
<div class="boxes" id="dialogRaovat" >
	<fieldset id="dialog" class="window">
		<div class="ui-dialog-titlebar ui-widget-header ui-corner-top ui-helper-clearfix" style="text-align: center; font-size: 13pt; padding: 2px;margin-bottom:3px;" ><span id="title_dialog">Form Nhập Rao Vặt</span>
		<a href="#" onclick="closeDialog('#dialogRaovat')" class="ui-dialog-titlebar-close ui-corner-all" role="button" unselectable="on" style="-moz-user-select: none; float: right;"><span class="ui-icon ui-icon-closethick" unselectable="on" style="-moz-user-select: none;">close</span></a>
		</div>
		<form id="formRaovat">
		<input type="hidden" name="raovat_id" id="raovat_id" value=""/>
		<fieldset>
			<legend><span style="font-weight:bold;">Thông Tin Rao Vặt</span></legend>
			<table class="center" width="100%">
				<thead>
					<tr>
						<td colspan="4" id="msg">
						</td>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td width="80px" align="right">Tiêu đề :</td>
						<td align="left">
							<input type="text" name="raovat_tieude" style="width:90%" value="" id="raovat_tieude" onblur="fillAlias()" tabindex=1/>
						</td>
						<td align="right">Alias :</td>
						<td align="left">
							<input type="text" name="raovat_alias" style="width:90%" value="" id="raovat_alias" tabindex=2/>
						</td>
					</tr>	
					<tr>
						<td align="right">Email :</td>
						<td align="left">
							<input type="text" name="raovat_email" style="width:90%" value="" id="raovat_email" tabindex=2/>
						</td>	
						<td align="right">Số ĐT :</td>
						<td align="left">
							<input type="text" name="raovat_sodienthoai" style="width:90%" value="" id="raovat_sodienthoai" tabindex=2/>
						</td>
					</tr>
					<tr>
						<td align="right">VIP :</td>
						<td align="left">
							<select id="raovat_isvip" name="raovat_isvip">
								<option value="1">Yes</option>
								<option value="0">No</option>
							</select>
						</td>	
						<td align="right">Ngày hết vip :</td>
						<td align="left">
							<input  type="text" style="width:90%" name="raovat_expirevip" id="raovat_expirevip" />
						</td>
					</tr>
					<tr>
						<td align="right"></td>
						<td align="left">
						</td>
						<td align="right">Ngày hết hạn :</td>
						<td align="left">
							<input  type="text" style="width:90%" name="raovat_expiredate" id="raovat_expiredate" />
						</td>
					</tr>
					<tr>
						<td align="left" colspan="4">
							Nội dung :(<a href="#" onclick="showImagesPanel()">Mở Gallery</a>)<br/>
							<textarea name="raovat_noidung" id="raovat_noidung" class="tinymce" tabindex=8></textarea>
						</td>
					</tr>
					<tr>
						<td colspan="4" align="center" height="50px">
							<input onclick="saveRaovat()" value="Lưu" type="button" tabindex=9>
							<input onclick="deleteRaovat()" value="Xóa" type="button" tabindex=9>
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
				<td width="40px">ID :</td>
				<td><input type="text" id="cond_id" style="width:200px" /></td>
				<td width="95px">Người đăng :</td>
				<td><input type="text" id="cond_account" style="width:200px" /></td>
				<td align="left">
				<input onclick="doFilter()" value="Tìm Kiếm" type="button">
				</td>
			</tr>
		</tbody>
		</table>
	</fieldset>
	<fieldset>
		<legend>Danh Sách Rao Vặt</legend>
		<div id="datagrid">
			<table width="99%">
				<thead>
					<tr class="ui-accordion-header ui-helper-reset ui-state-default ui-corner-all" style="font-weight:bold;height:20px;text-align:center;">
						<td>ID</td>
						<td>Tiêu đề</td>
						<td>Account</td>
						<td>Email</td>
						<td>Số ĐT</td>
						<td>Status</td>
						<td>VIP</td>
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
		value = byId("raovat_tieude").value;
		byId("raovat_alias").value = remove_space(remove_accents(value));
	}
	function showDialogRaovat() {
		doReset();
		showDialog('#dialogRaovat',700);
	}
	function selectpage(page) {
		nPage = page;
		loadListRaovat(page+searchString);
	};
	function fillFormValues(cells) { 		
		byId("raovat_id").value = $.trim($(cells.td_id).text());
		byId("raovat_tieude").value = $.trim($(cells.td_tieude).text());
		byId("raovat_alias").value = $.trim($(cells.td_alias).text());
		byId("raovat_email").value = $.trim($(cells.td_email).text());
		byId("raovat_sodienthoai").value = $.trim($(cells.td_sodienthoai).text());
		if($.trim($(cells.td_isvip).text())=="Y")
			byId("raovat_isvip").value = '1';
		else
			byId("raovat_isvip").value = '0';
		byId("raovat_expirevip").value = $.trim($(cells.td_expirevip).text());
		byId("raovat_expiredate").value = $.trim($(cells.td_expiredate).text());
	}
	function setRowValues(cells) {
		$(cells.td_id).text(byId("raovat_id").value);
		$(cells.td_tieude).text(byId("raovat_tieude").value);
		$(cells.td_alias).text(byId("raovat_alias").value);
		$(cells.td_email).text(byId("raovat_email").value);
		$(cells.td_sodienthoai).text(byId("raovat_sodienthoai").value);
		if(byId("raovat_isvip").value == '1')
			$(cells.td_isvip).text("Y");
		else
			$(cells.td_isvip).text("N");
		$(cells.td_expirevip).text(byId("raovat_expirevip").value);
		$(cells.td_expiredate).text(byId("raovat_expiredate").value);
	}
	function select_row(_this) {
		//jsdebug(_this);
		doReset();	
		showDialog('#dialogRaovat',700);
		var tr = _this.parentNode.parentNode;
		var cells = tr.cells;
		tr.style.backgroundColor = CONST_ROWSELECTED_COLOR;	
		objediting = tr;			
		fillFormValues(cells);
		block("#dialogRaovat #dialog");
		$.ajax({
			type: "GET",
			cache: false,
			url: url("/raovat/getnoidungById/"+byId("raovat_id").value),
			success: function(data){
				unblock("#dialogRaovat #dialog");
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/admin/login");
					return;
				}
				$('#raovat_noidung').html(data);		
			},
			error: function(data){ unblock("#dialogRaovat #dialog");alert (data);}	
		});
		return false;
	}
	function doReset() {
		$("#formRaovat")[0].reset(); //Reset form cua jquery, giu lai gia tri mac dinh cua cac field	
		if(objediting)
			objediting.style.backgroundColor = '';
		//Reset hidden field
		byId("raovat_id").value = '';
		//Reset editor
		$("#raovat_noidung").html("");
		//Bo cac field da set readonly
		$("#formRaovat :input").css('border-color','');
		byId("msg").innerHTML="";
	}
	function loadListRaovat(dataString) {
		block("#datagrid");
		$.ajax({
			type : "GET",
			cache: false,
			url: url("/raovat/listRaovat/"+dataString),
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
	function deleteRaovat() {
		raovat_id = byId("raovat_id").value;
		if(raovat_id=="")
			return;
		if(!confirm("Bạn muốn xóa tin rao vặt này?"))
			return;
		byId("msg").innerHTML="";
		block("#dialogRaovat #dialog");
		$.ajax({
			type: "GET",
			cache: false,
			url : url("/raovat/delete&raovat_id="+raovat_id),
			success: function(data){
				unblock("#dialogRaovat #dialog");	
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/admin/login");
					return;
				}
				if(data == "DONE") {
					//Load luoi du lieu		
					loadListRaovat(nPage+searchString);
					byId("raovat_id").value = "";
					message("Xóa tin rao thành công!",1);	
				} else {
					message('Xóa tin rao không thành công!',0);					
				}
			},
			error: function(data){ unblock("#dialogRaovat #dialog");alert (data);}	
		});
	}
	var isUpdate = false;
	function saveRaovat() {
		isUpdate = false;
		if(byId("raovat_id").value!="") {
			if(!confirm("Bạn muốn cập nhật tin rao này?"))
				return;
			isUpdate = true;
		}
		fillAlias();
		dataString = $("#formRaovat").serialize()+'&raovat_data='+$("iframe").contents().find("body#tinymce").text();
		//alert(dataString);return;
		byId("msg").innerHTML="";
		block("#dialogRaovat #dialog");
		$.ajax({
			type: "POST",
			cache: false,
			url : url("/raovat/saveRaovat&"),
			data: dataString,
			success: function(data){
				unblock("#dialogRaovat #dialog");	
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
						loadListRaovat('1'+searchString);
					}
					message("Lưu tin rao thành công!",1);	
				} else {
					message('Lưu tin rao không thành công!',0);					
				}
			},
			error: function(data){ unblock("#dialogRaovat #dialog");alert (data);}	
		});
	}
	function doActive(_this) {
		var cells = _this.parentNode.parentNode.cells;
		block("#content");
		$.ajax({
			type: "GET",
			cache: false,
			url : url("/raovat/activeRaovat/"+$(cells.td_id).text()),
			success: function(data){
				unblock("#content");
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/admin/login");
					return;
				}
				if (data == AJAX_DONE) {					
					$(cells.td_status).html("<div class='active' onclick='doUnActive(this)' title='Unactive'></div>");
				} else {
					alert("Active tin rao không thành công!");
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
			url : url("/raovat/unActiveRaovat/"+$(cells.td_id).text()),
			success: function(data){
				unblock("#content");
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/admin/login");
					return;
				}
				if (data == AJAX_DONE) {					
					$(cells.td_status).html("<div class='inactive' onclick='doActive(this)' title='Active'></div>");
				} else {
					alert("Bỏ Active tin rao không thành công!");
				}															
			},
			error: function(data){ alert (data);unblock("#content");}	
		});
	}
	function doFilter() {	
		searchString = "&cond_id="+byId("cond_id").value+"&cond_account="+byId("cond_account").value;
		loadListRaovat('1'+searchString);
	}
	$(document).ready(function(){				
		$("#title_page").text("Quản Trị Tin Rao Vặt");
		$('#raovat_expirevip').datepicker({
			dateFormat: "dd/mm/yy",
			changeMonth: true,
			changeYear: true
		});
		$('#raovat_expiredate').datepicker({
			dateFormat: "dd/mm/yy",
			changeMonth: true,
			changeYear: true
		});
		$('#raovat_noidung').tinymce({
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
		searchString = '';
		loadListRaovat('1'+searchString);
	});
</script>