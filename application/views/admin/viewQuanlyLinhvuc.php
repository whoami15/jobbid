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
<div class="boxes" id="dialogLinhvuc" >
	<fieldset id="dialog" class="window">
		<div class="ui-dialog-titlebar ui-widget-header ui-corner-top ui-helper-clearfix" style="text-align: center; font-size: 13pt; padding: 2px;margin-bottom:3px;" ><span id="title_dialog">Form Nhập Lĩnh Vực</span>
		<a href="#" onclick="closeDialog('#dialogLinhvuc')" class="ui-dialog-titlebar-close ui-corner-all" role="button" unselectable="on" style="-moz-user-select: none; float: right;"><span class="ui-icon ui-icon-closethick" unselectable="on" style="-moz-user-select: none;">close</span></a>
		</div>
		<form id="formLinhvuc">
		<fieldset>
			<legend><span style="font-weight:bold;">Thông Tin Lĩnh Vực</span></legend>
			<table class="center" width="100%">
				<thead>
					<tr>
						<td colspan="4" id="msg">
						</td>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td width="70px" align="left">Id :</td>
						<td align="left">
							<input type="text" name="linhvuc_id" id="linhvuc_id" style="width:90%"  tabindex="1"/><span style="color:red;font-weight:bold;cursor:pointer;" title="Bắt buộc nhập dữ liệu">*</span>
						</td>
					</tr>	
					<tr>		
						<td width="115px" align="left">Tên lĩnh vực :</td>
						<td align="left">
							<input type="text" name="linhvuc_tenlinhvuc" id="linhvuc_tenlinhvuc" style="width:90%" tabindex="2"/><span style="color:red;font-weight:bold;cursor:pointer;" title="Bắt buộc nhập dữ liệu">*</span>
						</td>
						
					</tr>
					<tr>
						<td colspan="4" align="center" height="50px">
							<input onclick="saveLinhvuc()" value="Lưu" type="button">
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
			  <a href="#" onclick="showDialogLinhvuc()"><span class="toplinks">THÊM LĨNH VỰC</span></a></span><br />
		  </div>
		</div>
	</div>
	<fieldset>
		<legend>Danh Sách Lĩnh Vực</legend>
		<div id="datagrid">
			<table width="99%">
				<thead>
					<tr class="ui-accordion-header ui-helper-reset ui-state-default ui-corner-all" style="font-weight:bold;height:20px;text-align:center;">
						<td width="20px">#</td>
						<td>Id</td>
						<td>Tên</td>
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
	function showDialogLinhvuc() {
		doReset();
		isUpdate = false;
		showDialog('#dialogLinhvuc',400);
		byId("linhvuc_id").focus();
	}
	function selectpage(page) {
		loadListLinhvucs(page);
	};
	function fillFormValues(cells) { 		
		byId("linhvuc_id").value = $.trim($(cells.td_id).text());
		byId("linhvuc_tenlinhvuc").value = $.trim($(cells.td_tenlinhvuc).text());	
		$("#linhvuc_id").attr("readonly", true); 
		isUpdate = true;		
	}
	function setRowValues(cells) {
		$(cells.td_id).text(byId("linhvuc_id").value);
		$(cells.td_tenlinhvuc).text(byId("linhvuc_tenlinhvuc").value);					
	}
	function select_row(_this) {
		//jsdebug(_this);
		doReset();	
		showDialog('#dialogLinhvuc',400);
		var tr = _this.parentNode.parentNode;
		var cells = tr.cells;
		tr.style.backgroundColor = CONST_ROWSELECTED_COLOR;	
		objediting = tr;			
		fillFormValues(cells);
		return false;
	}
	function doReset() {
		$("#formLinhvuc")[0].reset(); //Reset form cua jquery, giu lai gia tri mac dinh cua cac field	
		if(objediting)
			objediting.style.backgroundColor = '';
		byId("linhvuc_id").value="";
		$('#linhvuc_id').removeAttr("readonly");
		$("#formLinhvuc :input").css('border-color','');
		byId("msg").innerHTML="";
	}
	function loadListLinhvucs(page) {
		block("#datagrid");
		$.ajax({
			type : "GET",
			cache: false,
			url: url("/linhvuc/listLinhvucs/"+page),
			success : function(data){	
				//alert(data);
				unblock("#datagrid");
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/admin/login");
					return;
				}
				$("#datagrid").html(data);
				$("input:submit, input:button", "#datagrid").button();	
			},
			error: function(data){ 
				unblock("#datagrid");
				alert (data);
			}			
		});
	}
	var isUpdate = false;
	function saveLinhvuc() {
		checkValidate=true;
		validate(['require'],'linhvuc_id',["Vui lòng nhập ID lĩnh vực!"]);
		validate(['require'],'linhvuc_tenlinhvuc',["Vui lòng nhập tên lĩnh vực!"]);
		if(checkValidate == false)
			return;
		dataString = $("#formLinhvuc").serialize();
		byId("msg").innerHTML="";
		if(isUpdate==true) {
			if(!confirm("Bạn muốn cập nhật lĩnh vực này?"))
				return;
			block("#dialogLinhvuc #dialog");
			//alert(dataString);return;
			$.ajax({
				type: "POST",
				cache: false,
				url : url("/linhvuc/saveLinhvuc&"),
				data: dataString,
				success: function(data){
					unblock("#dialogLinhvuc #dialog");	
					if(data == AJAX_ERROR_NOTLOGIN) {
						location.href = url("/admin/login");
						return;
					}
					if(data == AJAX_DONE) {
						//Load luoi du lieu	
						message("Lưu lĩnh vực thành công!",1);
						var cells = objediting.cells;
						setRowValues(cells);														
					} else {
						message('Lưu lĩnh vực không thành công!',0);										
					}
				},
				error: function(data){ unblock("#dialogLinhvuc #dialog");alert (data);}	
			});
		} else {
			block("#dialogLinhvuc #dialog");
			$.ajax({
				type: "GET",
				cache: false,
				url : url("/linhvuc/exist/"+byId("linhvuc_id").value),
				success: function(data){
					if(data == "0") {
						$.ajax({
							type: "POST",
							cache: false,
							url : url("/linhvuc/saveLinhvuc&"),
							data: dataString,
							success: function(data){
								unblock("#dialogLinhvuc #dialog");	
								if(data == AJAX_ERROR_NOTLOGIN) {
									location.href = url("/admin/login");
									return;
								}
								if(data == AJAX_DONE) {
									//Load luoi du lieu	
									message("Lưu lĩnh vực thành công!",1);
									loadListLinhvucs(1);													
								} else {
									message('Lưu lĩnh vực không thành công!',0);										
								}
							},
							error: function(data){ unblock("#dialogLinhvuc #dialog");alert (data);}	
						});														
					} else if(data=="1") {
						unblock("#dialogLinhvuc #dialog");
						message('ID lĩnh vực này đã tồn tại!',0);
						byId("linhvuc_id").focus();
					} else {
						unblock("#dialogLinhvuc #dialog");
						message('Lưu lĩnh vực không thành công!',0);										
					}
				},
				error: function(data){ unblock("#dialogLinhvuc #dialog");alert (data);}	
			});
		}
	}
	function deleteLinhvuc(_this) {
		if(_this==null) 
			return;
		if(!confirm("Bạn muốn xóa lĩnh vực này?"))
			return;
		var tr = _this.parentNode.parentNode;
		var cells = tr.cells;
		tr.style.backgroundColor = CONST_ROWSELECTED_COLOR;	
		objediting = tr;
		block("#dialogLinhvuc #dialog");
		var parent = $(cells).parent();
		$.ajax({
			type: "GET",
			cache: false,
			url : url("/linhvuc/deleteLinhvuc&linhvuc_id="+$.trim($(cells.td_id).text())),
			success: function(data){
				unblock("#dialogLinhvuc #dialog");	
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/admin/login");
					return;
				}
				if(data == AJAX_DONE) {
					//Load luoi du lieu	
					parent.fadeOut('slow', function() {$(this).remove();}); 
				} else {
					alert('Xóa lĩnh vực không thành công!');										
				}
			},
			error: function(data){ unblock("#dialogLinhvuc #dialog");alert (data);}	
		});
	}
	$(document).ready(function(){				
		$("#title_page").text("Quản Trị Lĩnh Vực");
		loadListLinhvucs(1);
	});
</script>