<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/validator.js"></script>
<style type="text/css">
	.tdLabel {
		text-align:right;
		width:91px;
	}
	.tdInput {
		width:500px;
	}
</style>
<div id="content" style="width:100%">
	<div class="ui-widget-header ui-helper-clearfix ui-corner-top" style="border:none;padding-left: 5px" id="content_title">Trao đổi - Chia Sẻ - Thảo Luận</div>
	<div style="width: 99%; padding: 5px; text-align: left;">
	<h1>
	<?php
	if(isset($article)) {
		echo $article["article"]["title"];
	}
	?>
	</h1>
	</div>
	<div style="width: 98%; padding: 5px" class="viewcontent">
	<?php
	if(isset($article)) {
		echo $article["article"]["content"];
	}
	?>
	</div>
	<p><strong><font size="2">Tin khác:</font></strong></p>
	<ul>
	<?php 
	foreach($lstArticlesOlder as $a) {
		$alink = BASE_PATH."/article/view/".$a["article"]["id"]."/".$a["article"]["alias"];
		?>
		<li>
		<a class="link" href="<?php echo $alink ?>"><?php echo $a["article"]["title"] ?></a> 
		</li>
		<?php
	}
	?>
	</ul>
	<div id="binhluan" class="ui-widget-header ui-helper-clearfix" style="border:none;padding-left: 5px;margin-top:10px" id="content_title">BÌNH LUẬN</div>
	<div id="datagrid" style="padding:10px;">
	</div>
	<fieldset style="margin:5px">
	<legend>Ý kiến của bạn</legend>
	<center>
	<form id="sendComment">
	<input type="hidden" name="article_id" value="<?php echo $article["article"]["id"]?>"/>
	<div class="divTable" style="width:100%">
		<div class="tr" style="border:none">
			<div class="td" id="msg"></div>
		</div>
		<div class="tr" style="border:none">
			<div class="td tdLabel" style="text-align:right;">Tên bạn (<span style="color:red;font-weight:bold;cursor:pointer;" title="Bắt buộc nhập dữ liệu">*</span>) :</div>
			<div class="td tdInput">
			<input type="text" name="comment_ten" style="width:60%" value="<?php echo $comment_ten?>" id="comment_ten" tabindex=1 />
			</div>
		</div>
		<div class="tr" style="border:none">
			<div class="td tdLabel" style="text-align:right;">URL :</div>
			<div class="td tdInput">
			<input type="text" name="comment_url" style="width:90%" value="<?php echo $comment_url?>" id="comment_url" tabindex=1 />
			</div>
		</div>
		<div class="tr" style="border:none;text-align:left">
			<div class="td">
			Nội dung (ít hơn 1500 từ) :<br/>
			<textarea  id="comment_noidung" name="comment_noidung" style="margin-top: 5px; width: 99%;" rows="5" tabindex=2></textarea>
			</div>
		</div>
		<div class="tr" style="border:none;text-align:left">
			<div class="td">
			<div id="image_security" style="width:100px;height:40px;padding-left:140px;float:left">
			<img alt="imgcaptcha" id="imgcaptcha" src="<?php echo BASE_PATH ?>/util/captcha&width=100&height=40&characters=5"/>
			</div>
			<div style="float:left">
			<img title="Load mã bảo vệ khác" onclick="reloadImageCaptcha()" style="cursor:pointer" alt="reload_capcha" src="<?php echo BASE_PATH ?>/public/images/icons/refresh_icon.png"/>
			</div>
			</div>
		</div>
		<div class="tr" style="border:none">
			<div class="td tdLabel" style="width: 135px;text-align:left;">Mã xác nhận (<span style="color:red;font-weight:bold;cursor:pointer;" title="Bắt buộc nhập dữ liệu">*</span>) :</div>
			<div class="td tdInput"><input id="security_code" name="security_code" type="text" style="width:200px"  tabindex="3"/></div>
		</div>
		<div class="tr" style="border:none">
			<div class="td">
			<input id="btsubmit" type="button" onclick="doSendComment()" value="Gửi ý kiến"  tabindex=6>
			</div>
		</div>
	</div>
	</form>
	</center>
	</fieldset>
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
	function reloadImageCaptcha() {
		byId("imgcaptcha").src = byId("imgcaptcha").src + '#';
		byId("security_code").value = "";
	}
	function loadComments(page) {
		block("#datagrid");
		$.ajax({
			type : "GET",
			cache: false,
			url: url("/article/comments/<?php echo $article["article"]['id']?>/"+page),
			success : function(data){	
				unblock("#datagrid");
				$("#datagrid").html(data);
				
			},
			error: function(data){ 
				unblock("#datagrid");
				alert (data);
			}			
		});
	}
	function selectpage(page) {
		loadComments(page);
	}
	function doDeleteComment(_this,id) {
		if(!confirm("Bạn muốn xóa comment này?"))
			return;
		block("#datagrid");
		$.ajax({
			type : "GET",
			cache: false,
			url : url("/article/doDeleteComment&comment_id="+id),
			success : function(data){	
				unblock("#datagrid");
				if(data == AJAX_DONE) {
					$(_this.parentNode).remove();
				} else {
					message("Có lỗi xảy ra, vui lòng thử lại!",0);
				}
				
			},
			error: function(data){ 
				unblock("#datagrid");
				alert (data);
			}			
		});
	}
	function doSendComment() {
		location.href = "#sendComment";
		checkValidate=true;
		validate(['require'],'comment_ten',["Vui lòng nhập tên!"]);
		validate(['require'],'comment_noidung',["Vui lòng nhập nội dung!"]);
		validate(['require'],'security_code',["Vui lòng nhập 5 ký tự ở hình trên!"]);
		if(checkValidate==false) {
			return;
		}
		byId("msg").innerHTML="<div class='loading'><span class='bodytext' style='padding-left:30px;'>Đang xử lý...</span></div>";
		dataString = $("#sendComment").serialize();
		//alert(dataString);return;
		$('#btsubmit').attr('disabled','disabled');
		$.ajax({
			type : "POST",
			cache: false,
			url : url("/article/doSaveComment&"),
			data: dataString,
			success : function(data){	
				//alert(data);
				byId("msg").innerHTML="";
				$('#btsubmit').removeAttr('disabled');
				reloadImageCaptcha();
				if (data == AJAX_ERROR_SECURITY_CODE) {
					message('Sai mã xác nhận!',0);										
					byId("security_code").focus();
					$("#security_code").css('border-color','red');
					return;
				}
				if(data == AJAX_DONE) {
					comment_ten = byId("comment_ten").value;
					comment_url = byId("comment_url").value;
					$("#sendComment")[0].reset();
					byId("comment_ten").value = comment_ten;
					byId("comment_url").value = comment_url;
					loadComments(1);
					location.href = "#binhluan";
					//setTimeout("redirectPage()",redirect_time);
				} else {
					message("Có lỗi xảy ra, vui lòng thử lại!",0);
				}
				
			},
			error: function(data){ 
				$('#btsubmit').removeAttr('disabled');
				alert (data);
			}			
		});
	}
	$(document).ready(function() {
		$("input:submit, input:button", "body").button();
		loadComments(1);
	});
</script>
