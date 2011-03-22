<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/tiny_mce/jquery.tinymce.js"></script>
<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/utils.js"></script>
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
	.suggestionsBox {
		-moz-border-radius:7px 7px 7px 7px;
		background-color:#212427;
		border:2px solid #000000;
		color:#FFFFFF;
		margin:1px 0 0;
		position:absolute;
		width:190px;
		z-index:1000;
	}
	
	.suggestionList {
		margin: 0px;
		padding: 0px;
	}
	
	.suggestionList li {
		
		margin: 0px 0px 3px 0px;
		padding: 3px;
		cursor: pointer;
	}
	
	.suggestionList li:hover {
		background-color: #659CD8;
	}
</style>
<div class="boxes" id="dialogNhathau" >
	<fieldset id="dialog" class="window">
		<div class="ui-dialog-titlebar ui-widget-header ui-corner-top ui-helper-clearfix" style="text-align: center; font-size: 13pt; padding: 2px;margin-bottom:3px;" ><span id="title_dialog">Form Nhập Nhà Thầu</span>
		<a href="#" onclick="closeDialog('#dialogNhathau')" class="ui-dialog-titlebar-close ui-corner-all" role="button" unselectable="on" style="-moz-user-select: none; float: right;"><span class="ui-icon ui-icon-closethick" unselectable="on" style="-moz-user-select: none;">close</span></a>
		</div>
		<form id="formNhathau">
		<input type="hidden" name="nhathau_id" id="nhathau_id" value=""/>
		<input type="hidden" name="account_id" id="account_id" value=""/>
		<input type="hidden" name="nhathau_alias" id="nhathau_alias" value=""/>
		<fieldset>
			<legend><span style="font-weight:bold;">Thông Tin Nhà Thầu</span></legend>
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
							<input type="text" name="account_username" id="account_username" style="width:90%"  tabindex="1"/>
						</td>	
						<td width="130px" align="right">Mật khẩu :</td>
						<td align="left">
							<input type="password" name="account_password" id="account_password" style="width:90%" tabindex="2"/>
						</td>
						
					</tr>
					<tr>
						<td width="90px" align="right">Tên hiển thị :</td>
						<td width="200px" align="left">
							<input maxlength="255" type="text" name="nhathau_displayname" id="nhathau_displayname" style="width:90%" tabindex=1 value=""/>
						</td>
						<td width="95px" align="right">GPKD(CMND) :</td>
						<td align="left">
							<input maxlength="255" type="text" name="nhathau_gpkd_cmnd" id="nhathau_gpkd_cmnd" style="width:90%" tabindex=1 value=""/>
						</td>
					</tr>
					<tr>
						<td align="right">Loại :</td>
						<td align="left">
							<select name="nhathau_type" id="nhathau_type">
								<option value="1">Cá nhân</option>
								<option value="2">Công ty</option>
							</select>
						</td>
						<td align="right">Điểm :</td>
						<td align="left">
							<input type="text" name="nhathau_diemdanhgia" id="nhathau_diemdanhgia" style="width:30%"/>
						</td>
					</tr>	
					<tr>
						<td align="right">
							Lĩnh vực :
						</td>
						<td align="left" colspan="3">
							<table id="table_chonlinhvuc" width="99%">
							<tbody>
							<?php
							$i = 0;
							while($i<count($lstLinhvuc)) {
								$linhvuc = $lstLinhvuc[$i];
								echo "<tr>";
								echo "<td style='width:50%'><input type='checkbox' name='nhathau_linhvuc[]' value='".$linhvuc["linhvuc"]["id"]."'>".$linhvuc["linhvuc"]["tenlinhvuc"]."</td>";
								$i++;
								if($i<count($lstLinhvuc)) {
									$linhvuc = $lstLinhvuc[$i];
									echo "<td><input type='checkbox' name='nhathau_linhvuc[]' value='".$linhvuc["linhvuc"]["id"]."'>".$linhvuc["linhvuc"]["tenlinhvuc"]."</td>";
									$i++;
								}
								echo "</tr>";
							}
							?>
							</tbody>
						</table>
						</td>
					</tr>
					<tr>
						<td align="left" colspan="4">
							Mô tả chi tiết :(<a href="#" onclick="showImagesPanel()">Mở Gallery</a>)<br/>
							<textarea name="nhathau_motachitiet" id="nhathau_motachitiet" class="tinymce"></textarea>
						</td>
					</tr>
					<tr>
						<td colspan="4" align="center" height="50px">
							<input onclick="saveNhathau()" value="Lưu" type="button">
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
			  <a href="#" onclick="showDialogNhathau()"><span class="toplinks">TẠO NHÀ THẦU</span></a></span><br />
		  </div>
		</div>
	</div>
	<fieldset>
		<legend>Danh Sách Nhà Thầu</legend>
		<input type="text" style="width:400px;height:30px" name="nhathau_keyword" id="nhathau_keyword" value=""/><input type="button" style="margin-left:10px" value="Tìm Kiếm" onclick="doSearch()"/>
		<div id="datagrid">
			<table width="99%">
				<thead>
					<tr class="ui-accordion-header ui-helper-reset ui-state-default ui-corner-all" style="font-weight:bold;height:20px;text-align:center;">
						<td width="20px">#</td>
						<td>Username</td>
						<td>Tên hiển thị</td>
						<td>Điện thoại</td>
						<td>Point</td>
						<td>Nhận Email</td>
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
	function showDialogNhathau() {
		doReset();
		isUpdate = false;
		showDialog('#dialogNhathau',600);
		byId("nhathau_id").focus();
	}
	function selectpage(page) {
		loadListNhathaus(byId("nhathau_keyword").value,page);
	};
	function fillFormValues(cells) { 		
		byId("nhathau_id").value = $.trim($(cells.td_id).text());
		byId("account_id").value = $.trim($(cells.td_account_id).text());
		byId("account_username").value = $.trim($(cells.td_username).text());
		byId("nhathau_displayname").value = $.trim($(cells.td_displayname).text());
		byId("nhathau_gpkd_cmnd").value = $.trim($(cells.td_gpkd_cmnd).text());
		byId("nhathau_type").value = $.trim($(cells.td_type).text());
		byId("nhathau_diemdanhgia").value = $.trim($(cells.td_diemdanhgia).text());
		$("#nhathau_id").attr("readonly", true); 
		isUpdate = true;
	}
	function setRowValues(cells) {
		$(cells.td_id).text(byId("nhathau_id").value);
		$(cells.td_account_id).text(byId("account_id").value);
		$(cells.td_username).text(byId("account_username").value);
		$(cells.td_displayname).text(byId("nhathau_displayname").value);
		$(cells.td_gpkd_cmnd).text(byId("nhathau_gpkd_cmnd").value);
		$(cells.td_type).text(byId("nhathau_type").value);
		$(cells.td_diemdanhgia).text(byId("nhathau_diemdanhgia").value);
	}
	function select_row(_this) {
		//jsdebug(_this);
		doReset();	
		showDialog('#dialogNhathau',600);
		var tr = _this.parentNode.parentNode;
		var cells = tr.cells;
		tr.style.backgroundColor = CONST_ROWSELECTED_COLOR;	
		objediting = tr;			
		fillFormValues(cells);
		block("#dialogNhathau #dialog");
		$.ajax({
			type: "GET",
			cache: false,
			url: url("/nhathau/getLinhvucByNhathau/"+byId("nhathau_id").value),
			success: function(data){
				if(data == AJAX_ERROR_SYSTEM) {
					return;
				}
				var jsonObj = eval( "(" + data + ")" );
				for(i=0;jsonObj[i]!=null;i++) {
					$('input[value='+jsonObj[i].id+']').attr('checked', true);
				}	
			},
			error: function(data){ unblock("#dialogNhathau #dialog");alert (data);}	
		});
		$.ajax({
			type: "GET",
			cache: false,
			url: url("/nhathau/getMotachitietById/"+byId("nhathau_id").value),
			success: function(data){
				unblock("#dialogNhathau #dialog");
				$('#nhathau_motachitiet').html(data);		
			},
			error: function(data){ unblock("#dialogNhathau #dialog");alert (data);}	
		});
		return false;
	}
	function doReset() {
		$("#formNhathau")[0].reset(); //Reset form cua jquery, giu lai gia tri mac dinh cua cac field	
		if(objediting)
			objediting.style.backgroundColor = '';
		//Reset hidden field
		
		//Reset editor
		$("#nhathau_motachitiet").html("");
		//Bo cac field da set readonly
		$('#nhathau_id').removeAttr("readonly");
		$("#formNhathau :input").css('border-color','');
		byId("msg").innerHTML="";
	}
	function loadListNhathaus(keyword,page) {
		dataPost = 'keyword='+keyword;
		block("#datagrid");
		$.ajax({
			type : "POST",
			cache: false,
			url: url("/nhathau/listNhathaus/"+page+"&"),
			data: dataPost,
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
	function saveNhathau() {
		checkValidate=true;
		validate(['require','email'],'account_username',["Vui lòng nhập username nhà thầu!","Username phải là địa chỉ email!"]);
		validate(['number'],'nhathau_diemdanhgia',["Vui lòng nhập kiểu số!"]);
		if(checkValidate == false)
			return;
		byId("nhathau_alias").value = remove_space(remove_accents(byId("nhathau_displayname").value));
		dataString = $("#formNhathau").serialize();
		byId("msg").innerHTML="";
		if(isUpdate==true) {
			if(!confirm("Bạn muốn cập nhật nhà thầu này?"))
				return;
			block("#dialogNhathau #dialog");
			//alert(dataString);return;
			$.ajax({
				type: "POST",
				cache: false,
				url : url("/nhathau/saveNhathau&"),
				data: dataString,
				success: function(data){
					unblock("#dialogNhathau #dialog");	
					if(data == AJAX_ERROR_NOTLOGIN) {
						location.href = url("/admin/login");
						return;
					}
					if (data == "ERROR_EXIST"){
						message('Username này đã tồn tại!',0);
						byId("account_username").focus();
						return;
					}
					if(data == AJAX_DONE) {
						//Load luoi du lieu	
						message("Lưu dữ liệu thành công!",1);
						var cells = objediting.cells;
						setRowValues(cells);														
					} else if (data == AJAX_ERROR_NOTEXIST){
						message('Username này không tồn tại!',0);
						byId("account_username").focus();
					} else {
						message('Lưu dữ liệu không thành công!',0);										
					}
				},
				error: function(data){ unblock("#dialogNhathau #dialog");alert (data);}	
			});
		} else {
			block("#dialogNhathau #dialog");
			$.ajax({
				type: "GET",
				cache: false,
				url : url("/nhathau/exist/"+byId("nhathau_id").value),
				success: function(data){
					if (data == "1") {
						if(!confirm("Tài khoản này đã có 1 hồ sơ nhà thầu!\nBạn có muốn cập nhật hồ sơ này?")) {
							unblock("#dialogNhathau #dialog");
							return;
						}
						data = "0";
					}
					if(data == "0") {
						$.ajax({
							type: "POST",
							cache: false,
							url : url("/nhathau/saveNhathau&"),
							data: dataString,
							success: function(data){
								unblock("#dialogNhathau #dialog");	
								if(data == AJAX_ERROR_NOTLOGIN) {
									location.href = url("/admin/login");
									return;
								}
								if (data == "ERROR_EXIST"){
									message('Username này đã tồn tại!',0);
									byId("account_username").focus();
									return;
								}
								if(data == AJAX_DONE) {
									//Load luoi du lieu	
									message("Lưu dữ liệu thành công!",1);
									loadListNhathaus('',1);													
								} else if (data == AJAX_ERROR_NOTEXIST){
									message('Username này không tồn tại!',0);
									byId("nhathau_id").focus();
								} else {
									message('Lưu dữ liệu không thành công!',0);										
								}
							},
							error: function(data){ unblock("#dialogNhathau #dialog");alert (data);}	
						});														
					} else {
						unblock("#dialogNhathau #dialog");
						message('Lưu dữ liệu không thành công!',0);										
					}
				},
				error: function(data){ unblock("#dialogNhathau #dialog");alert (data);}	
			});
		}
	}
	function doSearch() {
		byId("msg").innerHTML="";
		selectpage(1);
	}
	function showLinhvucquantam(nhathau_id) {
		$("#dialog_panel").html("");
		$("#dialog_panel").dialog({
			width: 500,
			height:400,
			title:"Lĩnh Vực Quan Tâm",
			buttons: {}
		});
		$("#dialog_panel").dialog("open");
		block("#dialog_panel");
		$.ajax({
			type: "GET",
			cache: false,
			url : url("/nhathau/linhvucquantam&nhathau_id="+nhathau_id),
			success: function(data){
				unblock("#dialog_panel");
				$("#dialog_panel").html(data);
				$("input:submit, input:button", "#dialog_panel").button();					
			},
			error: function(data){ alert (data);unblock("#dialog_panel");}	
		});
	}
	$(document).ready(function(){				
		$("#title_page").text("Quản Trị Nhà Thầu");
		$('#nhathau_motachitiet').tinymce({
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
		$('#nhathau_id').keyup(function(e) {
			if(isUpdate==true)
				return;
			if(e.keyCode == 13)
				return;
			initTimer();
		});
		loadListNhathaus('',1);
	});
</script>