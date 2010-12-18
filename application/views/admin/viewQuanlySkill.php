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
<div class="boxes" id="dialogSkill" >
	<fieldset id="dialog" class="window">
		<div class="ui-dialog-titlebar ui-widget-header ui-corner-top ui-helper-clearfix" style="text-align: center; font-size: 13pt; padding: 2px;margin-bottom:3px;" ><span id="title_dialog">Skill Form</span>
		<a href="#" onclick="closeDialog('#dialogSkill')" class="ui-dialog-titlebar-close ui-corner-all" role="button" unselectable="on" style="-moz-user-select: none; float: right;"><span class="ui-icon ui-icon-closethick" unselectable="on" style="-moz-user-select: none;">close</span></a>
		</div>
		<form id="formSkill">
		<input type="hidden" name="skill_id" id="skill_id" />
		<fieldset>
			<legend><span style="font-weight:bold;">Thông Tin Skill</span></legend>
			<table class="center" width="100%">
				<thead>
					<tr>
						<td colspan="4" id="msg">
						</td>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td width="75px" align="right">Tên Skill :</td>
						<td align="left">
							<input type="text" name="skill_skillname" id="skill_skillname" style="width:90%"  tabindex="1"/><span style="color:red;font-weight:bold;cursor:pointer;" title="Bắt buộc nhập dữ liệu">*</span>
						</td>	
					</tr>
					<tr>
						<td align="right">Lĩnh vực :</td>
						<td align="left">
							<select name="skill_linhvuc_id" id="skill_linhvuc_id" tabindex=2>
								<?php
								foreach($lstLinhvuc as $linhvuc) {
									echo "<option value='".$linhvuc["linhvuc"]["id"]."'>".$linhvuc["linhvuc"]["tenlinhvuc"]."</option>";
								}
								?>
							</select>
						</td>
					</tr>
					<tr>
						<td colspan="4" align="center" height="50px">
							<input onclick="saveSkill()" value="Lưu" type="button">
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
			  <a href="#" onclick="showDialogSkill()"><span class="toplinks">THÊM SKILL</span></a></span><br />
		  </div>
		</div>
	</div>
	<fieldset>
		<legend>Danh Sách Skill</legend>
		<div id="datagrid">
			<table width="99%">
				<thead>
					<tr class="ui-accordion-header ui-helper-reset ui-state-default ui-corner-all" style="font-weight:bold;height:20px;text-align:center;">
						<td width="20px">#</td>
						<td>Tên Skill</td>
						<td>Lĩnh vực</td>
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
	function showDialogSkill() {
		doReset();
		showDialog('#dialogSkill',400);
		byId("skill_skillname").focus();
	}
	function selectpage(page) {
		loadListSkills(page);
	};
	function fillFormValues(cells) { //Lấy giá trị từ row được chọn đưa lên form (click vào nút "Chọn")		
		byId("skill_id").value = $.trim($(cells.td_id).text());
		byId("skill_skillname").value = $.trim($(cells.td_skillname).text());		
		byId("skill_linhvuc_id").value = $.trim($(cells.td_linhvuc_id).text());		
	}
	function setRowValues(cells) { //Set giá trị từ form xuống row edit	
		$(cells.td_id).text(byId("skill_id").value);
		$(cells.td_skillname).text(byId("skill_skillname").value);			
		$(cells.td_linhvuc_id).text(byId("skill_linhvuc_id").value);	
		var tmp = byId("skill_linhvuc_id");
		$(cells.td_linhvuc_display).text(tmp[tmp.selectedIndex].textContent);
	}
	function select_row(_this) {
		//jsdebug(_this);
		doReset();	
		showDialog('#dialogSkill',400);
		var tr = _this.parentNode.parentNode;
		var cells = tr.cells;
		tr.style.backgroundColor = CONST_ROWSELECTED_COLOR;	
		objediting = tr;			
		fillFormValues(cells);
		return false;
	}
	function doReset() {
		$("#formSkill")[0].reset(); //Reset form cua jquery, giu lai gia tri mac dinh cua cac field	
		if(objediting)
			objediting.style.backgroundColor = '';
		byId("skill_id").value="";
		$("#formSkill :input").css('border-color','');
		byId("msg").innerHTML="";
	}
	function loadListSkills(page) {
		block("#datagrid");
		$.ajax({
			type : "GET",
			cache: false,
			url: url("/skill/listSkills/"+page),
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
	function saveSkill() {
		checkValidate=true;
		validate(['require'],'skill_skillname',["Vui lòng nhập tên Skill!"]);
		if(checkValidate == false)
			return;
		isUpdate = false;
		if(byId("skill_id").value!="") {
			if(!confirm("Bạn muốn cập nhật Skill này?"))
				return;
			isUpdate = true;
		}
		dataString = $("#formSkill").serialize();
		//alert(dataString);return;
		byId("msg").innerHTML="";
		block("#dialogSkill #dialog");
		$.ajax({
			type: "POST",
			cache: false,
			url : url("/skill/saveSkill&"),
			data: dataString,
			success: function(data){
				unblock("#dialogSkill #dialog");	
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/admin/login");
					return;
				}
				if(data == AJAX_DONE) {
					//Load luoi du lieu		
					message("Lưu Skill thành công!",1);
					if(isUpdate == true) {
						var cells = objediting.cells;
						setRowValues(cells);
					} else {
						loadListSkills(1);
					}														
				} else {
					message('Lưu Skill không thành công!',0);										
				}
			},
			error: function(data){ unblock("#dialogSkill #dialog");alert (data);}	
		});
	}
	function deleteSkill(_this) {
		if(_this==null) 
			return;
		if(!confirm("Bạn muốn xóa Skill này?"))
			return;
		var tr = _this.parentNode.parentNode;
		var cells = tr.cells;
		tr.style.backgroundColor = CONST_ROWSELECTED_COLOR;	
		objediting = tr;
		block("#dialogSkill #dialog");
		var parent = $(cells).parent();
		$.ajax({
			type: "GET",
			cache: false,
			url : url("/skill/deleteSkill&skill_id="+$.trim($(cells.td_id).text())),
			success: function(data){
				unblock("#dialogSkill #dialog");	
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/admin/login");
					return;
				}
				if(data == AJAX_DONE) {
					//Load luoi du lieu	
					parent.fadeOut('slow', function() {$(this).remove();}); 
				} else {
					alert('Xóa Skill không thành công!');										
				}
			},
			error: function(data){ unblock("#dialogSkill #dialog");alert (data);}	
		});
	}
	$(document).ready(function(){				
		$("#title_page").text("Quản Trị Skill");
		loadListSkills(1);
	});
</script>