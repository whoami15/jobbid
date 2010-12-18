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
<div class="boxes" id="dialogAccount" >
	<fieldset id="dialog" class="window">
		<div class="ui-dialog-titlebar ui-widget-header ui-corner-top ui-helper-clearfix" style="text-align: center; font-size: 13pt; padding: 2px;margin-bottom:3px;" ><span id="title_dialog">Tài Khoản Form</span>
		<a href="#" onclick="closeDialog('#dialogAccount')" class="ui-dialog-titlebar-close ui-corner-all" role="button" unselectable="on" style="-moz-user-select: none; float: right;"><span class="ui-icon ui-icon-closethick" unselectable="on" style="-moz-user-select: none;">close</span></a>
		</div>
		<form id="formAccount">
		<input type="hidden" name="account_id" id="account_id" />
		<fieldset>
			<legend><span style="font-weight:bold;">Thông Tin Tài Khoản</span></legend>
			<table class="center" width="100%">
				<thead>
					<tr>
						<td colspan="4" id="msg">
						</td>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td width="75px" align="right">Username :</td>
						<td align="left">
							<input type="text" name="account_username" id="account_username" style="width:90%"  tabindex="1"/><span style="color:red;font-weight:bold;cursor:pointer;" title="Bắt buộc nhập dữ liệu">*</span>
						</td>	
						<td width="130px" align="right">Mật khẩu :</td>
						<td align="left">
							<input type="password" name="account_password" id="account_password" style="width:90%" tabindex="2"/><span style="color:red;font-weight:bold;cursor:pointer;" title="Bắt buộc nhập dữ liệu">*</span>
						</td>
						
					</tr>
					<tr>
						<td align="right">Role :</td>
						<td align="left">
							<select name="account_role" id="account_role" tabindex="3">
								<option value="1" selected>Quản trị hệ thống</option>
								<option value="2">Người dùng</option>
							</select>
						</td>	
						<td align="right">Point :</td>
						<td align="left">
							<input type="text" name="account_point" id="account_point" style="width:90%"  tabindex="4" value="0"/><span style="color:red;font-weight:bold;cursor:pointer;" title="Bắt buộc nhập dữ liệu">*</span>
						</td>
					</tr>
					<tr>
						<td align="right">Họ tên :</td>
						<td align="left">
							<input type="text" name="account_hoten" id="account_hoten" style="width:90%"  tabindex="5"/>
						</td>	
						<td align="right">Ngày sinh :</td>
						<td align="left">
							<input type="text" name="account_ngaysinh" id="account_ngaysinh" style="width:90%"  tabindex="6"/>
						</td>
					</tr>
					<tr>
						<td align="right">Địa chỉ :</td>
						<td align="left">
							<input type="text" name="account_diachi" id="account_diachi" style="width:90%"  tabindex="7"/>
						</td>	
						<td align="right">Số điện thoại :</td>
						<td align="left">
							<input type="text" name="account_sodienthoai" id="account_sodienthoai" style="width:90%"  tabindex="8"/><span style="color:red;font-weight:bold;cursor:pointer;" title="Bắt buộc nhập dữ liệu">*</span>
						</td>
					</tr>
					<tr>
						<td align="right">Email :</td>
						<td align="left">
							<input type="text" name="account_email" id="account_email" style="width:90%"  tabindex="7"/><span style="color:red;font-weight:bold;cursor:pointer;" title="Bắt buộc nhập dữ liệu">*</span>
						</td>	
						<td align="right"></td>
						<td align="left">
							
						</td>
					</tr>
					<tr>
						<td colspan="4" align="center" height="50px">
							<input onclick="saveAccount()" value="Lưu" type="button">
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
			  <a href="#" onclick="showDialogAccount()"><span class="toplinks">THÊM TÀI KHOẢN</span></a></span><br />
		  </div>
		</div>
	</div>
	<fieldset>
		<legend>Danh Sách Tài Khoản</legend>
		<div id="datagrid">
			<table width="99%">
				<thead>
					<tr class="ui-accordion-header ui-helper-reset ui-state-default ui-corner-all" style="font-weight:bold;height:20px;text-align:center;">
						<td width="20px">#</td>
						<td>Username</td>
						<td>Họ tên</td>
						<td>Email</td>
						<td>Point</td>
						<td>Last Login</td>
						<td>Quyền</td>
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
	function showDialogAccount() {
		doReset();
		showDialog('#dialogAccount',600);
	}
	function selectpage(page) {
		loadListAccounts(page);
	};
	function fillFormValues(cells) { //Lấy giá trị từ row được chọn đưa lên form (click vào nút "Chọn")		
		byId("account_id").value = $.trim($(cells.td_id).text());
		byId("account_username").value = $.trim($(cells.td_username).text());		
		byId("account_hoten").value = $.trim($(cells.td_hoten).text());		
		byId("account_ngaysinh").value = $.trim($(cells.td_ngaysinh).text());		
		byId("account_diachi").value = $.trim($(cells.td_diachi).text());		
		byId("account_sodienthoai").value = $.trim($(cells.td_sodienthoai).text());		
		byId("account_email").value = $.trim($(cells.td_email).text());		
		byId("account_point").value = $.trim($(cells.td_point).text());		
		switch($.trim($(cells.td_role).text())) {
			case "Quản trị hệ thống":
				byId("account_role").value = 1;
				break;
			default:
				byId("account_role").value = 2;
				break;
		}		
	}
	function setRowValues(cells) { //Set giá trị từ form xuống row edit	
		$(cells.td_id).text(byId("account_id").value);
		$(cells.td_username).text(byId("account_username").value);			
		$(cells.td_hoten).text(byId("account_hoten").value);			
		$(cells.td_ngaysinh).text(byId("account_ngaysinh").value);			
		$(cells.td_diachi).text(byId("account_diachi").value);			
		$(cells.td_sodienthoai).text(byId("account_sodienthoai").value);			
		$(cells.td_email).text(byId("account_email").value);			
		$(cells.td_point).text(byId("account_point").value);			
		switch(byId("account_role").value) {
			case "1":
				$(cells.td_role).text("Quản trị hệ thống");
				break;
			default:
				$(cells.td_role).text("Người dùng");
				break;
		}		
	}
	function select_row(_this) {
		//jsdebug(_this);
		doReset();	
		showDialog('#dialogAccount',600);
		var tr = _this.parentNode.parentNode;
		var cells = tr.cells;
		tr.style.backgroundColor = CONST_ROWSELECTED_COLOR;	
		objediting = tr;			
		fillFormValues(cells);
		return false;
	}
	function doReset() {
		$("#formAccount")[0].reset(); //Reset form cua jquery, giu lai gia tri mac dinh cua cac field	
		if(objediting)
			objediting.style.backgroundColor = '';
		byId("account_id").value="";
		$("#formAccount :input").css('border-color','');
		byId("msg").innerHTML="";
	}
	function loadListAccounts(page) {
		block("#datagrid");
		$.ajax({
			type : "GET",
			cache: false,
			url: url("/account/listAccounts/"+page),
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
	function saveAccount() {
		checkValidate=true;
		validate(['require'],'account_username',["Vui lòng nhập Username!"]);
		if(byId("account_id").value=="") {
			validate(['require',5],'account_password',["Vui lòng nhập Password!","Password phải lớn hơn 5 ký tự"]);
		} else {
			if(byId("account_password").value!="") {
				validate([5],'account_password',["Password phải lớn hơn 5 ký tự"]);
			}
		}
		validate(['require','number'],'account_point',["Vui lòng nhập Point!","Vui lòng nhập kiểu số!"]);
		validate(['require'],'account_sodienthoai',["Vui lòng nhập số điện thoại!"]);
		validate(['require'],'account_email',["Vui lòng nhập email!"]);
		if(checkValidate == false)
			return;
		isUpdate = false;
		if(byId("account_id").value!="") {
			if(!confirm("Bạn muốn cập nhật Tài Khoản này?"))
				return;
			isUpdate = true;
		}
		dataString = $("#formAccount").serialize();
		//alert(dataString);return;
		byId("msg").innerHTML="";
		block("#dialogAccount #dialog");
		$.ajax({
			type: "POST",
			cache: false,
			url : url("/account/saveAccount&"),
			data: dataString,
			success: function(data){
				unblock("#dialogAccount #dialog");	
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/admin/login");
					return;
				}
				if(data == AJAX_DONE) {
					//Load luoi du lieu		
					message("Lưu Tài Khoản thành công!",1);
					if(isUpdate == true) {
						var cells = objediting.cells;
						setRowValues(cells);
					} else {
						loadListAccounts(1);
					}														
				} else if (data == AJAX_ERROR_EXIST) {
					message('Username này đã tồn tại!',0);	
					byId("account_username").focus();
				} else if (data == AJAX_ERROR_NOTEXIST) {
					message('Username này không tồn tại!',0);										
					byId("account_username").focus();
				} else {
					message('Lưu Tài Khoản không thành công!',0);										
				}
			},
			error: function(data){ unblock("#dialogAccount #dialog");alert (data);}	
		});
	}
	function doActive(_this) {
		var cells = _this.parentNode.parentNode.cells;
		block("#content");
		$.ajax({
			type: "GET",
			cache: false,
			url : url("/account/activeAccount/"+$(cells.td_id).text()),
			success: function(data){
				unblock("#content");
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/admin/login");
					return;
				}
				if (data == AJAX_DONE) {					
					message("Active Tài Khoản thành công!",1);
					$(cells.td_active).html("<div class='active' onclick='doUnActive(this)' title='Bỏ Active Tài Khoản này'></div>");
				} else {
					message("Active Tài Khoản không thành công!",0);
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
			url : url("/account/unActiveAccount/"+$(cells.td_id).text()),
			success: function(data){
				unblock("#content");
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/admin/login");
					return;
				}
				if (data == AJAX_DONE) {					
					message("Bỏ Active Tài Khoản thành công!",1);
					$(cells.td_active).html("<div class='inactive' onclick='doActive(this)' title='Active Tài Khoản này'></div>");
				} else {
					message("Bỏ Active Tài Khoản không thành công!",0);
				}															
			},
			error: function(data){ alert (data);unblock("#content");}	
		});
	}
	$(document).ready(function(){				
		$("#title_page").text("Quản Trị Tài Khoản");
		$('#account_ngaysinh').datepicker({
			dateFormat: "dd/mm/yy",
			changeMonth: true,
			changeYear: true
		});
		loadListAccounts(1);
	});
</script>