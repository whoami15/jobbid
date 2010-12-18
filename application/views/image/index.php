<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/jquery.form.js"></script>
<div style="height: 115px; width: 802px; position: relative;">
	<form id="formUpload" ENCTYPE="multipart/form-data" >
	<fieldset>
	<table width="100%">
		<tbody>
			<tr>
				<td colspan="2" id="image_msg">
				</td>
			</tr>
			<tr>
				<td width="200px">
				Chọn File <span class="tipMsg" title="Chỉ cho phép các định dạng ảnh sau : jpg,png,bmp,jpeg,gif">*</span> :<br/>
				<input type="file" name="image" />
				</td>
				<td rowspan="2" align="left" valign="top" style="padding-left:50px">
					URL hình ảnh :<br/>
					<input type="text" style="width: 100%; background-color: wheat; height: 20px;" readonly id="link_image" onfocus="this.select()"/>
				</td>
			</tr>
			<tr>
				<td align="center">
					<input type="submit" value="Upload">
				</td>
			</tr>
		</tbody>
	</table>
	</fieldset>
	</form>
</div>
<div style="float: left;" id="lstImage">
</div>
<script>
function image_msg(msg,type) {
	if(type==1) { //Thong diep thong bao
		str = "<div class='positive'><span class='bodytext' style='padding-left:30px;'><strong>"+msg+"</strong></span></div>";
		byId("image_msg").innerHTML = str;
	} else if(type == 0) { //Thong diep bao loi
		str = "<div class='negative'><span class='bodytext' style='padding-left:30px;'><strong>"+msg+"</strong></span></div>";
		byId("image_msg").innerHTML = str;
	}
}
function selectpage(page) {
	loadimages(page);
}
function loadimages(page){
	byId("image_msg").innerHTML = "";
	block("#dialog_panel");
	if(page == null)
		page = 1;
	$.ajax({
		type: "GET",
		url : url("/image/showimage/"+page),
		success: function(data){
			unblock("#dialog_panel");
			$("#lstImage").html(data);
			$(".image").each(function(){
				if($(this).width()>190)
					$(this).width(190);
				if($(this).height()>140)
					$(this).height(140);
			});
		},
		error: function(data){ alert (data);unblock("#dialog_panel");}	
	});
}
$(document).ready(function() {
	var options = { 
		url:        url("/admin/uploadImage"), 
		type:      "post",
		dataType: "xml",
		success:    function(data) { 
			data = data.activeElement.childNodes[0].innerHTML;		
			if(data == AJAX_DONE) {
				loadimages(1);
				image_msg("Upload file thành công!",1);
			} else if(data == AJAX_ERROR_WRONGFORMAT) {
				image_msg("Upload file sai định dạng!",0);
			} else {
				image_msg("Upload file không thành công!",0);
			}
		} 
	}; 
	// pass options to ajaxForm 
	$('#formUpload').ajaxForm(options); 
	loadimages(1);
});
</script>