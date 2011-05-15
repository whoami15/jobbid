<div style="padding-top:10px;font-size:14px" id="manageCaches">
	<fieldset>
		<legend>Danh Sách Cache</legend>
		<div id="msg"></div><br/>
		<span class="link" onclick="doRefeshCache('duan')">Refesh Cache dự án</span><br/>
		<span class="link" onclick="doRefeshCache('raovat')">Refesh Cache rao vặt</span><br/>
		<span class="link" onclick="doRefeshCache('tintuc')">Refesh Cache tin tức</span><br/>
		<span class="link" onclick="doRefeshCache('widget')">Refesh Cache widget</span><br/>
		<span class="link" onclick="doRefeshCache('thongke')">Refesh Cache thống kê</span><br/>
	</fieldset>
</div>
<script type="text/javascript">
	function message(msg,type) {
		if(type==1) { //Thong diep thong bao
			str = "<div class='positive'><span class='bodytext' style='padding-left:30px;'><strong>"+msg+"</strong></span></div>";
			byId("msg").innerHTML = str;
		} else if(type == 0) { //Thong diep bao loi
			str = "<div class='negative'><span class='bodytext' style='padding-left:30px;'><strong>"+msg+"</strong></span></div>";
			byId("msg").innerHTML = str;
		}
	}
	
	function doRefeshCache(type) {
		if(type==null) 
			return;
		byId("msg").innerHTML="Refeshing cache "+type+" ....";
		block("#manageCaches");
		$.ajax({
			type: "GET",
			cache: false,
			url : url("/"+type+"/refeshCache"),
			success: function(data){
				unblock("#manageCaches");
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/admin/login");
					return;
				}
				byId("msg").innerHTML="";
				if(data == AJAX_DONE) {
					//Load luoi du lieu	
					alert('Refesh cache '+type+' thành công!');
				} else {
					alert('Refesh cache '+type+' không thành công!');									
				}
			},
			error: function(data){ unblock("#manageCaches");alert (data);}	
		});
	}
	$(document).ready(function(){				
		$("#title_page").text("Quản Trị Cache");
	});
</script>