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
<div class="boxes" id="dialogHosothau" >
	<fieldset id="dialog" class="window">
		<div class="ui-dialog-titlebar ui-widget-header ui-corner-top ui-helper-clearfix" style="text-align: center; font-size: 13pt; padding: 2px;margin-bottom:3px;" ><span id="title_dialog">Form Nhập Hồ Sơ Thầu</span>
		<a href="#" onclick="closeDialog('#dialogHosothau')" class="ui-dialog-titlebar-close ui-corner-all" role="button" unselectable="on" style="-moz-user-select: none; float: right;"><span class="ui-icon ui-icon-closethick" unselectable="on" style="-moz-user-select: none;">close</span></a>
		</div>
		<form id="formHosothau">
		<input type="hidden" name="hosothau_id" id="hosothau_id" value=""/>
		<input type="hidden" name="duan_id" id="duan_id" value=""/>
		<input type="hidden" name="nhathau_id" id="nhathau_id" value=""/>
		<fieldset>
			<legend><span style="font-weight:bold;">Thông Tin Hồ Sơ Thầu</span></legend>
			<table class="center" width="100%">
				<thead>
					<tr>
						<td colspan="4" id="msg">
						</td>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td width="90px" align="right">Giá thầu :</td>
						<td width="200px" align="left">
							<input type="text" name="hosothau_giathau" style="width:70%" value="" id="hosothau_giathau" tabindex=1/>
						</td>
						<td width="95px" align="right">Thời gian :</td>
						<td align="left">
							<input type="text" name="hosothau_thoigian" style="width:40%" value="" id="hosothau_thoigian" tabindex=2/>
						</td>
					</tr>
					<tr>
						<td align="right">MileStone :</td>
						<td align="left">
							<input type="text" name="hosothau_milestone" style="width:40%" value="" id="hosothau_milestone" tabindex=3/>
						</td>
						<td align="right">Trạng thái :</td>
						<td align="left">
							<select name="hosothau_trangthai" id="hosothau_trangthai">
								<option value="1">Mở</option>
								<option value="2">Đã trúng thầu</option>
								<option value="-1">Khóa</option>
							</select>
						</td>
					</tr>	
					<tr>
						<td align="left" colspan="4">
							Lời nhắn :<br/>
							<textarea spellcheck=false id="hosothau_content" name="hosothau_content" style="margin-top: 5px; width: 99%; font-family: verdana; font-size: 13px;" rows="5" tabindex=5></textarea>
						</td>
					</tr>
					<tr>
						<td colspan="4" align="center" height="50px">
							<input onclick="saveHosothau()" value="Lưu" type="button">
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
	<fieldset>
		<legend>Danh Sách Hồ Sơ Thầu</legend>
		<div id="datagrid">
			<table width="99%">
				<thead>
					<tr class="ui-accordion-header ui-helper-reset ui-state-default ui-corner-all" style="font-weight:bold;height:20px;text-align:center;">
						<td width="20px">#</td>
						<td>Dự án</td>
						<td>Username</td>
						<td>Giá thầu</td>
						<td>Thời gian</td>
						<td>Ngày gửi</td>
						<td>Trạng thái</td>
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
	function showDialogHosothau() {
		doReset();
		showDialog('#dialogHosothau',600);
		byId("hosothau_id").focus();
	}
	function selectpage(page) {
		loadListHosothaus(page);
	};
	function fillFormValues(cells) { 		
		byId("hosothau_id").value = $.trim($(cells.td_id).text());
		byId("hosothau_giathau").value = $.trim($(cells.td_giathau).text());
		byId("hosothau_thoigian").value = $.trim($(cells.td_thoigian).text());
		byId("hosothau_trangthai").value = $.trim($(cells.td_trangthai).text());
		byId("hosothau_milestone").value = $.trim($(cells.td_milestone).text());
		byId("duan_id").value = $.trim($(cells.td_duan_id).text());
		byId("nhathau_id").value = $.trim($(cells.td_nhathau_id).text());
		byId("hosothau_content").value = $.trim($(cells.td_content).text());
	}
	function setRowValues(cells) {
		$(cells.td_id).text(byId("hosothau_id").value);
		$(cells.td_giathau).text(byId("hosothau_giathau").value);
		$(cells.td_giathau_display).text(byId("hosothau_giathau").value+' VNĐ');
		$(cells.td_thoigian).text(byId("hosothau_thoigian").value);
		trangthai = byId("hosothau_trangthai").value;
		$(cells.td_trangthai).text(trangthai);
		if(trangthai=='-1') 
			$(cells.td_trangthai_display).text("Khóa");
		else if(trangthai=='2') 
			$(cells.td_trangthai_display).text("Đã trúng thầu");
		else
			$(cells.td_trangthai_display).text("Mở");
		$(cells.td_trangthai).text(byId("hosothau_trangthai").value);
		$(cells.td_milestone).text(byId("hosothau_milestone").value);
		$(cells.td_duan_id).text(byId("duan_id").value);
		$(cells.td_nhathau_id).text(byId("nhathau_id").value);
		$(cells.td_content).text(byId("hosothau_content").value);
	}
	function select_row(_this) {
		//jsdebug(_this);
		doReset();	
		showDialog('#dialogHosothau',600);
		var tr = _this;
		var cells = tr.cells;
		tr.style.backgroundColor = CONST_ROWSELECTED_COLOR;	
		objediting = tr;			
		fillFormValues(cells);
		return false;
	}
	function doReset() {
		$("#formHosothau")[0].reset(); //Reset form cua jquery, giu lai gia tri mac dinh cua cac field	
		if(objediting)
			objediting.style.backgroundColor = '';
		//Reset hidden field
		
		//Reset editor
		$("#hosothau_content").html("");
		//Bo cac field da set readonly
		$('#hosothau_id').removeAttr("readonly");
		$("#formHosothau :input").css('border-color','');
		byId("msg").innerHTML="";
	}
	function loadListHosothaus(page) {
		block("#datagrid");
		$.ajax({
			type : "GET",
			cache: false,
			url: url("/hosothau/listHosothau/"+page),
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
	function saveHosothau() {
		checkValidate=true;
		byId("hosothau_giathau").value = $.trim(byId("hosothau_giathau").value);
		byId("hosothau_thoigian").value = $.trim(byId("hosothau_thoigian").value);
		validate(['require','number'],'hosothau_giathau',["Vui lòng nhập giá thầu!","Vui lòng nhập kiểu số!"]);
		validate(['require','number'],'hosothau_thoigian',["Vui lòng nhập thời gian!","Vui lòng nhập kiểu số!"]);
		validate(['number'],'hosothau_milestone',["Vui lòng nhập kiểu số!"]);
		if(checkValidate == false)
			return;
		dataString = $("#formHosothau").serialize();
		byId("msg").innerHTML="";
		block("#dialogHosothau #dialog");
			//alert(dataString);return;
		$.ajax({
			type: "POST",
			cache: false,
			url : url("/hosothau/saveHosothau&"),
			data: dataString,
			success: function(data){
				unblock("#dialogHosothau #dialog");	
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/admin/login");
					return;
				}
				if(data == AJAX_DONE) {
					//Load luoi du lieu	
					message("Lưu dữ liệu thành công!",1);
					var cells = objediting.cells;
					setRowValues(cells);														
				} else {
					message('Lưu dữ liệu không thành công!',0);										
				}
			},
			error: function(data){ unblock("#dialogHosothau #dialog");alert (data);}	
		});
	}
	
	$(document).ready(function(){				
		$("#title_page").text("Quản Trị Hồ Sơ Thầu");
		loadListHosothaus(1);
	});
</script>