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
<div id="content">
	<div class="ui-widget-header ui-helper-clearfix ui-corner-top" style="border:none;padding-left: 5px" id="content_title">Trao đổi - Chia Sẻ - Thảo Luận</div>
	<div style="width: 99%; padding: 5px; font-size: 15pt; font-weight: bold; text-align: left;">
	<?php
	if(isset($article)) {
		echo $article["article"]["title"];
	}
	?>
	</div>
	<div style="width: 98%; padding: 5px">
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
	<div class="ui-widget-header ui-helper-clearfix" style="border:none;padding-left: 5px;margin-top:10px" id="content_title">BÌNH LUẬN</div>
	<div id="datagrid" style="padding:10px;">
	</div>
	<fieldset style="margin:5px">
	<legend>Ý kiến của bạn</legend>
	<center>
	<form id="sendComment">
	<div class="divTable" style="width:100%">
		<div class="tr" style="border:none">
			<div class="td" id="msg"></div>
		</div>
		<div class="tr" style="border:none">
			<div class="td tdLabel" style="text-align:right;">Tên bạn (<span style="color:red;font-weight:bold;cursor:pointer;" title="Bắt buộc nhập dữ liệu">*</span>) :</div>
			<div class="td tdInput">
			<?php
			if(isset($_SESSION['nhathau']))
				echo '<input type="text" readonly=true name="comment_ten" style="width:60%" value="'.$_SESSION['nhathau']['displayname'].'" id="comment_ten" tabindex=1 />';
			else
				echo '<input type="text" name="comment_ten" style="width:60%" value="" id="comment_ten" tabindex=1 />';
			?>
			</div>
		</div>
		<div class="tr" style="border:none;text-align:left">
			<div class="td">
			Nội dung (ít hơn 1500 từ) :<br/>
			<textarea  id="comment_noidung" name="comment_noidung" style="margin-top: 5px; width: 99%;" rows="5" tabindex=5></textarea>
			</div>
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
	function loadComments(page) {
		$.ajax({
			type : "GET",
			cache: false,
			url: url("/article/comments/<?php echo $article["article"]['id']?>/"+page),
			success : function(data){	
				$("#datagrid").html(data);
				
			},
			error: function(data){ 
				alert (data);
			}			
		});
	}
	function doSendComment() {
		//location.href = "#top";
		checkValidate=true;
		validate(['require'],'comment_ten',["Vui lòng nhập tên!"]);
		validate(['require'],'comment_noidung',["Vui lòng nhập nội dung!"]);
		if(checkValidate==false) {
			return;
		}
		byId("msg").innerHTML="<div class='loading'><span class='bodytext' style='padding-left:30px;'>Đang xử lý...</span></div>";
		dataString = $("#sendComment").serialize();
		alert(dataString);return;
		$('#btsubmit').attr('disabled','disabled');
		$.ajax({
			type : "POST",
			cache: false,
			url : url("/hosothau/doPost&"),
			data: dataString,
			success : function(data){	
				//alert(data);
				$('#btsubmit').removeAttr('disabled');
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/account/login");
					return;
				}
				if(data == "ERROR_MAXLENGTH") {
					message('Lỗi! Lời nhắn phải ít hơn 1000 ký tự!',0);
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
				if(data == "ERROR_EXPIRED") {
					message("Dự án này đã hết thời gian đấu thầu!",0);
					return;
				}
				if(data == "ERROR_SELFBID") {
					message("Bạn không thể đấu thầu dự án của bạn!",0);
					return;
				}
				if(data == "ERROR_DUPLICATE") {
					message("Bạn không thể đặt thầu 2 lần liên tiếp trong dự án này!",0);
					return;
				}
				if(data == "ERROR_MAKEPROFILE") {
					message("Lỗi, bạn chưa tạo hồ sơ nhà thầu! Đang chuyển đến trang tạo hồ sơ...",0);
					setTimeout("redirectMakeProfile()",redirect_time);
					return;
				}
				if(data == AJAX_DONE) {
					message("Gửi hồ sơ thầu thành công! Đang chuyển trang...",1);
					setTimeout("redirectPage()",redirect_time);
				} else if(data == AJAX_ERROR_WRONGFORMAT) {
					message("Upload file sai định dạng!",0);
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
