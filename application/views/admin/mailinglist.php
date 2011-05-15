<div style="padding-top:10px;font-size:14px" >
	<fieldset>
		<table class="center" width="100%">
		<thead>
			<tr>
				<td colspan="4" id="msg">
				</td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td colspan="4">
				<input type="text" name="email" align="center" id="email" style="width: 60%; height: 30px; margin-left: 180px;" onfocus="this.select()"/>
				</td>
			</tr>
			<tr>
				<td colspan="4" align="center" height="50px">
					<input id="btSaveEmail" onclick="saveEmail()" value="Thêm" type="button">
					<input id="btDoSearch" onclick="doSearch()" value="Tìm Kiếm" type="button">
				</td>
			</tr>
		</tbody>
	</table>
	</fieldset>
	<fieldset>
		<legend>Danh Sách Email</legend>
		<p align="left">
			<img style="cursor:pointer" src="<?php echo BASE_PATH ?>/public/images/icons/export.png" alt="export txt file" title="Export Mail List" onclick="doExport()"/>
		</p>
		<div id="datagrid">
			<table width="99%">
				<thead>
					<tr class="ui-accordion-header ui-helper-reset ui-state-default ui-corner-all" style="font-weight:bold;height:20px;text-align:center;">
						<td width="20px">ID</td>
						<td>Email</td>
						<td width="40px">Xử lý</td>
					</tr>
				</thead>
			</table>
		</div>
	</fieldset>
</div>
<script type="text/javascript">
	function message(msg,type) {
		if(type==1) { //Thong diep thong bao
			str = "<div class='positive'><span class='bodytext' style='padding-left:30px;'><strong>"+msg+"</strong></span></div>";
			byId("msg").innerHTML = str;
		} else if(type == 0) { //Thong diep bao loi
			str = "<div class='negative'><span class='bodytext' style='padding-left:30px;'><strong>"+msg+"</strong></span></div>";
			byId("msg").innerHTML = str;
		}
	}
	function selectpage(page) {
		loadListEmail(byId("email").value,page);
	};

	function doReset() {
		byId("email").value="";
		$("#email").css('border-color','');
		byId("msg").innerHTML="";
	}
	function loadListEmail(keyword,page) {
		block("#datagrid");
		$.ajax({
			type : "GET",
			cache: false,
			url: url("/email/listEmail/"+page+"&keyword="+keyword),
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
	function saveEmail() {
		checkValidate=true;
		validate(['require','email'],'email',["Vui lòng nhập Email!",'Email không hợp lệ!']);
		if(checkValidate == false)
			return;
		$('#btSaveEmail').attr('disabled','disabled');
		byId("msg").innerHTML="Saving....";
		$.ajax({
			type: "GET",
			cache: false,
			url : url("/email/saveEmail&email="+byId("email").value),
			success: function(data){
				$('#btSaveEmail').removeAttr('disabled');
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/admin/login");
					return;
				}
				if(data == AJAX_DONE) {
					//Load luoi du lieu		
					byId("email").value = "";
					message("Lưu email thành công!",1);
					loadListEmail('',1);
				} else if (data == AJAX_ERROR_EXIST) {
					message('Email này đã tồn tại!',0);	
					byId("email").focus();
				} else {
					message('Lưu email không thành công!',0);										
				}
			},
			error: function(data){ $('#btSaveEmail').removeAttr('disabled');alert (data);}	
		});
	}
	function doSearch() {
		byId("msg").innerHTML="";
		selectpage(1);
	}
	function doRemove(_this) {
		if(_this==null) 
			return;
		if(!confirm("Bạn muốn xóa email này?"))
			return;
		var tr = _this.parentNode.parentNode;
		var cells = tr.cells;
		tr.style.backgroundColor = CONST_ROWSELECTED_COLOR;	
		byId("msg").innerHTML="Removing....";
		var parent = $(cells).parent();
		$.ajax({
			type: "GET",
			cache: false,
			url : url("/email/deleteEmail/"+$.trim($(cells.td_id).text())),
			success: function(data){
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/admin/login");
					return;
				}
				if(data == AJAX_DONE) {
					//Load luoi du lieu	
					message("Xóa email thành công!",1);
					parent.fadeOut('slow', function() {$(this).remove();}); 
				} else {
					alert('Xóa email không thành công!');										
				}
			},
			error: function(data){ unblock("#dialogSkill #dialog");alert (data);}	
		});
	}
	function doExport() {
		block("#content");
		byId("msg").innerHTML="Exporting....";
		location.href = url("/email/doExport");
		message("Export email thành công!",1);
		unblock("#content");
	}
	$(document).ready(function(){				
		$("#title_page").text("Quản Trị Mailing List");
		loadListEmail('',1);
	});
</script>