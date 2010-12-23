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
	fieldset {
		margin-bottom:5px;
	}
</style>
<div id="tabs">
	<ul>
		<li><a href="#tabs-1">Upload File Types</a></li>
		<li><a href="#tabs-2">Mail Template</a></li>
	</ul>
	<div id="tabs-1">
		<form id="formSettings">
		<table class="center" width="100%">
			<thead>
				<tr>
					<td colspan="4" id="msg">
					</td>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td width="110px" align="left">Image Types :</td>
					<td align="left">
						<input type="text" name="imagetypes" id="imagetypes" value="<?php echo $imageTypes ?>" style="width:99%"/>
					</td>	
				</tr>
				<tr>
					<td align="left">File Types :</td>
					<td align="left">
						<input type="text" name="filetypes" id="filetypes" value="<?php echo $fileTypes ?>" style="width:99%"/>
					</td>
				</tr>	
				<tr>
					<td colspan="4" align="center" height="50px">
						<input onclick="save()" value="Lưu" type="button">
					</td>
				</tr>
			</tbody>
		</table>
		</form>
	</div>
	<div id="tabs-2">
		<fieldset>
		<legend>Danh Sách Mail Template</legend>
		<div id="datagrid">
			<table width="99%">
				<thead>
					<tr class="ui-accordion-header ui-helper-reset ui-state-default ui-corner-all" style="font-weight:bold;height:20px;text-align:center;">
						<td width="20px">#</td>
						<td>Loại Mail</td>
						<td>Điện thoại</td>
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
	function save() {
		dataString = $("#formSettings").serialize();
		byId("msg").innerHTML="";
		block("#tabs-1");	
		$.ajax({
			type: "POST",
			cache: false,
			url : url("/admin/saveSettings&"),
			data: dataString,
			success: function(data){
				unblock("#tabs-1");	
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/admin/login");
					return;
				}
				if(data == AJAX_DONE) {
					//Load luoi du lieu	
					message("Lưu cấu hình thành công!",1);
				} else {
					message('Lưu cấu hình không thành công!',0);										
				}
			},
			error: function(data){ unblock("#tabs-1");alert (data);}	
		});
	}
	$(document).ready(function(){				
		$("#title_page").text("Cấu hình hệ thống");
		$("#tabs").tabs();
	});
</script>