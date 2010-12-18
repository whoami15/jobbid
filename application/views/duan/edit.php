<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/validator.js"></script>
<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/jHtmlArea-0.7.0.js"></script>
<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/jHtmlArea.ColorPickerMenu-0.7.0.js"></script>
<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/jquery.form.js"></script>
<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/utils.js"></script>
<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/costtype.js"></script>
<link href="<?php echo BASE_PATH ?>/public/css/front/jHtmlArea.css" rel="stylesheet" type="text/css" />
<link href="<?php echo BASE_PATH ?>/public/css/front/jHtmlArea.ColorPickerMenu.css" rel="stylesheet" type="text/css" />
<style>
	.multiselect {  
		height:200px;
		width:230px; 
	} 
	td {
		width:200px;
	}
</style>
<!--[if !IE]> 
<-->
<style>
	td {
		width:80px;
	}
</style>
<!--> 
<![endif]-->
<div id="content" style="width:100%;">
	<div class="ui-widget-header ui-helper-clearfix ui-corner-all" style='text-align: left; padding-left: 10px; margin-left: -5px; width: 100%;' id="content_title">Content</div>
	<form id="formDuan" style="padding-top: 10px; padding-bottom: 10px;" >
		<input type="hidden" name="duan_id" id="duan_id" value="<?php echo $dataDuan["id"]?>" />
		<input type="hidden" name="duan_alias" id="duan_alias" value="" />
			<table id="table_taoduan" class="center" width="100%">
				<thead>
					<tr>
						<td colspan="4" id="msg">
						</td>
					</tr>
				</thead>
				<tbody>
					<tr height="25px">
						<td align="right">Tên dự án <span style="color:red;font-weight:bold;cursor:pointer;" title="Bắt buộc nhập dữ liệu">*</span> :</td>
						<td align="left">
							<input type="text" name="duan_tenduan" style="width:90%" value="<?php echo $dataDuan["tenduan"]?>" id="duan_tenduan" tabindex=1/>
						</td>
					</tr>
					<tr height="25px">
						<td align="right">Tỉnh/TP :</td>
						<td align="left">
							<select name="duan_tinh_id" id="duan_tinh_id" tabindex=2>
								<?php
								foreach($lstTinh as $tinh) {
									echo "<option value='".$tinh["tinh"]["id"]."'>".$tinh["tinh"]["tentinh"]."</option>";
								}
								?>
							</select>
						</td>
					</tr>
					<tr height="25px">
						<td align="right">Chi phí :</td>
						<td align="left">
							<input type="hidden" name="duan_costmin" id="duan_costmin" value="0"/>
							<input type="hidden" name="duan_costmax" id="duan_costmax" value="0"/>
							<select id="duan_cost" tabindex=3>
							</select> (VNĐ)
						</td>
					</tr>
					<tr height="25px">	
						<td align="right">Ngày kết thúc thầu <span style="color:red;font-weight:bold;cursor:pointer;" title="Bắt buộc nhập dữ liệu">*</span> :</td>
						<td align="left" >
							<input type="text" value="<?php echo $html->format_date($dataDuan["ngayketthuc"],'d/m/Y') ?>"  name="duan_ngayketthuc" id="duan_ngayketthuc" tabindex=4 />&nbsp;<span class="question" id="tip_ngayketthuc">(?)</span>
						</td>
					</tr>
					<tr height="25px">	
						<td align="right">File đính kèm :</td>
						<td align="left">
							<input type="file" name="duan_filedinhkem" id="duan_filedinhkem" tabindex=5/> (Size < 2Mb)
							<?php 
							if(isset($dataFile)) {
							?>
							<br/>
							(<a class="link" target="_blank" href="<?php echo BASE_PATH.'/file/download/'.$dataFile["id"] ?>" title="<?php echo $dataFile["filename"] ?>"><?php echo $html->trimString($dataFile["filename"],50) ?></a>)
							<?php
							}
							?>
						</td>
					</tr>
					<tr height="25px">
						<td align="right">Lĩnh vực <span style="color:red;font-weight:bold;cursor:pointer;" title="Bắt buộc nhập dữ liệu">*</span> :</td>
						<td align="left">
							<select name="duan_linhvuc_id" id="duan_linhvuc_id" tabindex=6 onchange="loadListSkills()" >
								<option value="">---Chọn lĩnh vực---</option>
								<?php
								foreach($lstLinhvuc as $linhvuc) {
									echo "<option value='".$linhvuc["linhvuc"]["id"]."'>".$linhvuc["linhvuc"]["tenlinhvuc"]."</option>";
								}
								?>
							</select>
						</td>
					</tr>	
					<tr>
						<td align="center" colspan="2">
							<br/>
							<fieldset>
								<legend>Yêu cầu về kỹ năng <span class="question" id="tip_skill">(?)</span></legend>
							<table class="center" width="500px">
								<tbody>
								<tr>
									<td align="right">
										<select class="multiselect" multiple id="select1" >
										<?php
										foreach($lstSkillByLinhvuc as $skill) {
											echo "<option value='".$skill["skill"]["id"]."'>".$skill["skill"]["skillname"]."</option>";
										}
										?>
										</select>   
									</td>
									<td align="center">
										<button id="btadd"><span class="ui-icon ui-icon-seek-end"></button><br>
										<button id="btremove"><span class="ui-icon ui-icon-seek-first"></button><br>
										<button id="btaddall"><span class="ui-icon ui-icon-seek-next"></button><br>
										<button id="btremoveall"><span class="ui-icon ui-icon-seek-prev"></button><br>
									</td>
									<td align="left">
										<select class="multiselect" name="duan_skills[]" multiple id="select2" tabindex=7>
										<?php
										foreach($lstSkill as $skill) {
											echo "<option value='".$skill["skill"]["id"]."'>".$skill["skill"]["skillname"]."</option>";
										}
										?>	
										</select> 
									</td>
								</tr>
								</tbody>
							</table>
							</fieldset>
						</td>
					</tr>
					<tr>
						<td align="left" colspan="4">
							<br/>Thông tin chi tiết :<br/>
							<textarea id="duan_thongtinchitiet" name="duan_thongtinchitiet" style="border:none;" rows="15" tabindex=8><?php echo $dataDuan["thongtinchitiet"]?></textarea>
						</td>
					</tr>
					<tr>
						<td colspan="4" align="center" height="50px">
							<input id="btsubmit" type="submit" value="Cập Nhật"  tabindex=9>
							<?php
							if($dataDuan["active"]==1 && empty($dataDuan["nhathau_id"])) {
								if($lefttime>0) {
								?>
								<input id="btChangeStatusProject" onclick="changeStatus(<?php echo $dataDuan["id"]?>,0)" value="Đóng Dự Án" type="button" tabindex=10>
								<?php
								}
							} else {
							?>
							<input id="btChangeStatusProject" onclick="changeStatus(<?php echo $dataDuan["id"]?>,1)" value="Mở Dự Án" type="button" tabindex=10>
							<?php
							}
							?>
						</td>
					</tr>
				</tbody>
			</table>
	</form>
</div>
<script>
	function message(msg,type) {
		if(type==1) { //Thong diep thong bao
			str = "<div class='positive'><span class='bodytext' style='padding-left:30px;'>"+msg+"</span></div>";
			byId("msg").innerHTML = str;
		} else if(type == 0) { //Thong diep bao loi
			str = "<div class='negative'><span class='bodytext' style='padding-left:30px;'>"+msg+"</span></div>";
			byId("msg").innerHTML = str;
		}
	}	
	function doReset() {
		$("#formDuan")[0].reset(); //Reset form cua jquery, giu lai gia tri mac dinh cua cac field	
		$("#formDuan :input").css('border-color','');
		byId("msg").innerHTML="";
		$('#btsubmit').removeAttr('disabled');
		$('#btChangeStatusProject').removeAttr('disabled');
	}
	function validateFormDuAn(formData, jqForm, options) {
		location.href = "#top";
		checkValidate=true;
		validate(['require'],'duan_tenduan',["Vui lòng nhập tên dự án!"]);
		validate(['require','checkdate'],'duan_ngayketthuc',["Vui lòng nhập ngày kết thúc"]);
		validate(['requireselect'],'duan_linhvuc_id',["Vui lòng chọn 1 lĩnh vực!"]);
		if(checkValidate==false) {
			return false;
		}
		byId("duan_alias").value = remove_space(remove_accents(byId("duan_tenduan").value));
		$("#select2").each(function(){  
			$("#select2 option").attr("selected","selected");
		});
		var value = byId("duan_cost").value;
		byId("duan_costmin").value = arrCostType[value].min;
		byId("duan_costmax").value = arrCostType[value].max;
		$('#btsubmit').attr('disabled','disabled');
		byId("msg").innerHTML="<div class='loading'><span class='bodytext' style='padding-left:30px;'>Đang xử lý...</span></div>";
		return true;
	}
	function loadListSkills() {
		var value = byId("duan_linhvuc_id").value;
		if(value=="")
			return;
		block("#select1");
		$.ajax({
			type: "GET",
			cache: false,
			url : url("/skill/getSkillsByLinhvuc&linhvuc_id="+value),
			success: function(data){
				unblock("#select1");
				if(data == AJAX_ERROR_SYSTEM) {
					return;
				}
				var jsonObj = eval( "(" + data + ")" );
				$('#select1').html("");
				for(i=0;jsonObj[i]!=null;i++) {
					$('#select1').append("<option value="+jsonObj[i].id+" >"+jsonObj[i].skillname+"</option>");
				}
			},
			error: function(data){ unblock("#select1");alert (data);}	
		});
	}
	function changeStatus(duan_id,active) {
		if(duan_id==null)
			return;
		$('#btChangeStatusProject').attr('disabled','disabled');
		location.href = "#top";
		byId("msg").innerHTML="<div class='loading'><span class='bodytext' style='padding-left:30px;'>Đang xử lý...</span></div>";
		$.ajax({
			type: "GET",
			cache: false,
			url : url("/duan/changeStatusProject/"+active+"&duan_id="+duan_id),
			success: function(data){
				$('#btChangeStatusProject').removeAttr('disabled');
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/account/login");
					return;
				}
				if(data == AJAX_DONE) {
					if(active==0)
						message("Đóng dự án thành công! Đang chuyển trang...",1);
					else
						message("Mở dự án thành công! Đang chuyển trang...",1);
					setTimeout("redirectPage()",redirect_time);
				} else {
					message("Thao tác bị lỗi, vui lòng thử lại!",0);
				}
			},
			error: function(data){ $('#btChangeStatusProject').removeAttr('disabled');alert (data);}	
		});
	}
	function redirectPage() {
		location.href = url('/duan/view/'+byId("duan_id").value+'/'+byId("duan_alias").value);
	}
	$(document).ready(function() {
		for(i=0;arrCostType[i]!=null;i++) {
			$('#duan_cost').append("<option value="+arrCostType[i].id+" >"+arrCostType[i].costtype+"</option>");
		}
		MultiSelect("btadd","btremove","btaddall","btremoveall","select1","select2");
		$("#duan_thongtinchitiet").css("width","100%");
		$("#duan_thongtinchitiet").htmlarea({
				toolbar: [
					["html"], ["bold", "italic", "underline"],
					["increasefontsize", "decreasefontsize", "forecolor"],
					["orderedlist", "unorderedlist"],
					["indent", "outdent"],
					["justifyleft", "justifycenter", "justifyright"],
					["link", "unlink", "image", "horizontalrule"],
					["cut", "copy", "paste"]
				],
                toolbarText: $.extend({}, jHtmlArea.defaultOptions.toolbarText, {
                        "bold": "fett",
                        "italic": "kursiv",
                        "underline": "unterstreichen"
                    }),
                css: "<?php echo BASE_PATH ?>/public/css/front/jHtmlArea.Editor.css",
                loaded: function() {
                }
			
		}) ;
		$("#choosecolor").click(function() {
			jHtmlAreaColorPickerMenu(this, {
				colorChosen: function(color) {
					$(document.body).css('background-color', color);
				}
			});
		});
		var options = { 
			beforeSubmit: validateFormDuAn,
			url:        url("/duan/doEdit"), 
			type:      "post",
			dataType: "xml",
			success:    function(data) { 
				$('#btsubmit').removeAttr('disabled');
				data = data.activeElement.childNodes[0].data;	
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/account/login");
					return;
				}
				if(data == "ERROR_NOTACTIVE") {
					message('Lỗi! Tài khoản của bạn chưa được active.Vui lòng kiểm tra email để active tài khoản!',0);
					return;
				}
				if(data == "ERROR_FILESIZE") {
					message("File upload phải nhỏ hơn 2Mb!",0);
					return;
				}
				if(data == AJAX_DONE) {
					message("Cập nhật dự án thành công! Đang chuyển trang...",1);
					setTimeout("redirectPage()",redirect_time);
				} else if(data == AJAX_ERROR_WRONGFORMAT) {
					message("Upload file sai định dạng!",0);
				} else {
					message("Cập nhật dự án không thành công!",0);
				}
			},
			error : function(data) {
				$('#btsubmit').removeAttr('disabled');
				alert(data);
			} 
		}; 
		byId("duan_linhvuc_id").value = '<?php echo $dataDuan["linhvuc_id"]?>';
		byId("duan_tinh_id").value = '<?php echo $dataDuan["tinh_id"]?>';
		costmin = <?php echo $dataDuan["costmin"]?>;
		for(i=0;arrCostType[i]!=null;i++) {
			if(arrCostType[i].min == costmin) {
				byId("duan_cost").value = i;
				break;
			}
		}
		// pass options to ajaxForm 
		$('#formDuan').ajaxForm(options);
		$("#content_title").css("width",width_content-19);
		$("#content_title").text("Sửa dự án");
		$("input:submit, input:button", "body").button();
		$('#duan_ngayketthuc').datepicker({
			dateFormat: "dd/mm/yy",
			changeMonth: true,
			changeYear: true
		});
		boundTip("duan_tenduan","Nhập tên dự án bạn muốn đấu thầu");
		boundTip("tip_ngayketthuc","Là ngày mà bạn muốn phiên đấu thầu cho dự án này kết thúc, sau ngày này thì các nhà thầu không được phép đấu thầu cho dự án này nữa.");
		boundTip("duan_linhvuc_id","Chọn lĩnh vực dự án bạn muốn tạo. Sau khi chọn thì danh sách kỹ năng thuộc lĩnh vực bạn chọn sẽ được load vào mục kỹ năng.");
		boundTip("tip_skill","Chọn kỹ năng cần thiết ở cột bên trái đưa qua cột bên phải, đây là các kỹ năng bạn yêu cầu các nhà thầu phải có trước khi tham gia đấu thầu dự án của bạn.");
	});
</script>
