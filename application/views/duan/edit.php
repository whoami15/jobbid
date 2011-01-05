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
		width:300px;  
	} 
	.tdLabel {
		text-align:right;
		width:170px;
	}
</style>
<div id="content" style="width:100%;">
	<div class="ui-widget-header ui-helper-clearfix ui-corner-top" style="border:none;padding-left: 5px" id="content_title">Sửa dự án</div>
	<form id="formDuan" style="padding-top: 10px; padding-bottom: 10px;" >
		<input type="hidden" name="duan_id" id="duan_id" value="<?php echo $dataDuan["id"]?>" />
		<input type="hidden" name="duan_alias" id="duan_alias" value="" />
		<center>
		<div class="divTable" style="width:100%">
			<div class="tr" style="border:none">
				<div class="td" id="msg"></div>
			</div>
			<div class="tr" style="border:none">
				<div class="td tdLabel" style="text-align:right;">Hình thức đấu thầu :</div>
				<div class="td tdInput">
				<input type="radio" name="duan_isbid" id="duan_isbid" value="1" /> Đấu thầu tự do.<br/>
				<input type="radio" name="duan_isbid" id="duan_isbid" value="0"/> Liên hệ trực tiếp.
				</div>
			</div>
			<div class="tr" style="border:none">
				<div class="td tdLabel" style="text-align:right;">Tên dự án <span style="color:red;font-weight:bold;cursor:pointer;" title="Bắt buộc nhập dữ liệu">*</span> :</div>
				<div class="td tdInput">
				<input type="text" name="duan_tenduan" style="width:90%" value="<?php echo $dataDuan["tenduan"]?>" id="duan_tenduan" tabindex=1/>
				</div>
			</div>
			<div class="tr" style="border:none">
				<div class="td tdLabel" style="text-align:right;">Tỉnh/TP :</div>
				<div class="td tdInput">
				<select name="duan_tinh_id" id="duan_tinh_id" tabindex=2>
					<?php
					foreach($lstTinh as $tinh) {
						echo "<option value='".$tinh["tinh"]["id"]."'>".$tinh["tinh"]["tentinh"]."</option>";
					}
					?>
				</select>
				</div>
			</div>
			<div class="tr" style="border:none">
				<div class="td tdLabel" style="text-align:right;">Chi phí :</div>
				<div class="td tdInput">
				<input type="hidden" name="duan_costmin" id="duan_costmin" value="0"/>
				<input type="hidden" name="duan_costmax" id="duan_costmax" value="0"/>
				<select id="duan_cost" tabindex=3>
				</select> (VNĐ)
				</div>
			</div>
			<div class="tr" style="border:none">
				<div class="td tdLabel" style="text-align:right;">Ngày kết thúc thầu <span style="color:red;font-weight:bold;cursor:pointer;" title="Bắt buộc nhập dữ liệu">*</span> :</div>
				<div class="td tdInput">
				<input type="text" value="<?php echo $html->format_date($dataDuan["ngayketthuc"],'d/m/Y') ?>"  name="duan_ngayketthuc" id="duan_ngayketthuc" tabindex=4 />
				</div>
			</div>
			<div class="tr" style="border:none">
				<div class="td tdLabel" style="text-align:right;">Email <span style="color:red;font-weight:bold;cursor:pointer;" title="Bắt buộc nhập dữ liệu">*</span> :</div>
				<div class="td tdInput">
				<input type="text"  name="duan_email" id="duan_email" tabindex=7 value="<?php echo $dataDuan["duan_email"] ?>"/>
				</div>
			</div>
			<div class="tr" style="border:none">
				<div class="td tdLabel" style="text-align:right;">Số điện thoại <span style="color:red;font-weight:bold;cursor:pointer;" title="Bắt buộc nhập dữ liệu">*</span> :</div>
				<div class="td tdInput">
				<input type="text"  name="duan_sodienthoai" id="duan_sodienthoai" tabindex=7 value="<?php echo $dataDuan["duan_sodienthoai"] ?>"/>
				</div>
			</div>
			<div class="tr" style="border:none">
				<div class="td tdLabel" style="text-align:right;">File đính kèm :</div>
				<div class="td tdInput">
				<input type="file" name="duan_filedinhkem" id="duan_filedinhkem" tabindex=5/> (Size < 2Mb)
				<?php 
				if(isset($dataFile)) {
				?>
				<br/>
				(<a class="link" target="_blank" href="<?php echo BASE_PATH.'/file/download/'.$dataFile["id"] ?>" title="<?php echo $dataFile["filename"] ?>"><?php echo $html->trimString($dataFile["filename"],50) ?></a>)
				<?php
				}
				?>
				</div>
			</div>
			<div class="tr" style="border:none">
				<div class="td tdLabel" style="text-align:right;">Lĩnh vực <span style="color:red;font-weight:bold;cursor:pointer;" title="Bắt buộc nhập dữ liệu">*</span> :</div>
				<div class="td tdInput">
				<select name="duan_linhvuc_id" id="duan_linhvuc_id" tabindex=6 onchange="loadListSkills()" >
					<option value="">---Chọn lĩnh vực---</option>
					<?php
					foreach($lstLinhvuc as $linhvuc) {
						echo "<option value='".$linhvuc["linhvuc"]["id"]."'>".$linhvuc["linhvuc"]["tenlinhvuc"]."</option>";
					}
					?>
				</select>
				</div>
			</div>
			<div class="tr" style="border:none">
				<div class="td">
				<fieldset>
					<legend>Yêu cầu về kỹ năng</legend>
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
				</div>
			</div>
			<div class="tr" style="border:none">
				<div class="td">
				Thông tin chi tiết :<br/>
				<textarea id="duan_thongtinchitiet" name="duan_thongtinchitiet" style="border:none;" rows="15" tabindex=8><?php echo $dataDuan["thongtinchitiet"]?></textarea>
				</div>
			</div>
			<div class="tr" style="border:none">
				<div class="td">
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
				</div>
			</div>
		</div>
		</center>
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
		validate(['require','email'],'duan_email',["Vui lòng nhập email chủ dự án!","Email sai định dạng!"]);
		validate(['require'],'duan_sodienthoai',["Vui lòng nhập số điện thoại chủ dự án!"]);
		validate(['requireselect'],'duan_linhvuc_id',["Vui lòng chọn 1 lĩnh vực!"]);
		if(checkValidate==false) {
			return false;
		}
		if($("#select2 option").length><?php echo MAX_SKILL ?>) {
			message("Bạn được phép chọn tối đa <?php echo MAX_SKILL ?> Skill!",0);
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
		if(!confirm("Dự án này sẽ không được hiển thị cho đến khi bạn mở lại.\nBạn có muốn dóng dự án này?"))
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
				if(data == "ERROR_LOCKED") {
					message("Tài khoản này đã bị khóa, vui lòng liên hệ admin@jobbid.vn để mở lại!",0);
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
		document.title = "Chỉnh Sửa Dự Án - "+document.title;
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
				data = data.body.childNodes[0].data;	
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/account/login");
					return;
				}
				if(data == "ERROR_MAXSKILL") {
					message("Bạn được phép chọn tối đa <?php echo MAX_SKILL ?> Skill!",0);
					return;
				}
				if(data == "ERROR_NOTACTIVE") {
					message('Lỗi! Tài khoản của bạn chưa được active.Vui lòng kiểm tra email để active tài khoản!',0);
					return;
				}
				if(data == "ERROR_LOCKED") {
					message("Tài khoản này đã bị khóa, vui lòng liên hệ admin@jobbid.vn để mở lại!",0);
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
		setCheckedValue(document.forms['formDuan'].elements['duan_isbid'], <?php echo $dataDuan["isbid"]?>);
		// pass options to ajaxForm 
		$('#formDuan').ajaxForm(options);
		$("input:submit, input:button", "body").button();
		$('#duan_ngayketthuc').datepicker({
			dateFormat: "dd/mm/yy",
			changeMonth: true,
			changeYear: true
		});
	});
</script>
