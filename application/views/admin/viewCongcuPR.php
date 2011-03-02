<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/tiny_mce/jquery.tinymce.js"></script>
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
	fieldset {
		margin-bottom:5px;
	}
</style>
<div id="tabs">
	<ul>
		<li><a href="#tabs-1">Mời Nhà Tuyển Dụng</a></li>
		<li><a href="#tabs-2">Mời Ứng Viên</a></li>
	</ul>
	<div id="tabs-1">
		<form id="formMoinhatuyendung">
		<table class="center" width="100%">
			<thead>
				<tr>
					<td colspan="4" id="msg1">
					</td>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td width="110px" align="left">Email 1 :</td>
					<td align="left">
						<input type="text" name="email1" id="email1" value="" style="width:99%" tabindex="1" onfocus="this.select()"/>
					</td>	
				</tr>
				<tr>
					<td align="left">Email 2 :</td>
					<td align="left">
						<input type="text" name="email2" id="email2" value="" style="width:99%" tabindex="2" onfocus="this.select()"/>
					</td>
				</tr>
				<tr>
					<td align="left">Email 3 :</td>
					<td align="left">
						<input type="text" name="email3" id="email3" value="" style="width:99%" tabindex="3" onfocus="this.select()"/>
					</td>
				</tr>
				<tr>
					<td align="left">Email 4 :</td>
					<td align="left">
						<input type="text" name="email4" id="email4" value="" style="width:99%" tabindex="4" onfocus="this.select()"/>
					</td>
				</tr>
				<tr>
					<td align="left">Email 5 :</td>
					<td align="left">
						<input type="text" name="email5" id="email5" value="" style="width:99%" tabindex="5" onfocus="this.select()"/>
					</td>
				</tr>				
				<tr>
					<td colspan="4" align="center" height="50px">
						<input onclick="doSend1()" value="Gửi Thư Mời" type="button" tabindex="6">
					</td>
				</tr>
			</tbody>
		</table>
		</form>
		<div id="tabs_1_result"></div>
	</div>
	<div id="tabs-2">
		<form id="formMoiungvien">
		<table class="center" width="100%">
			<thead>
				<tr>
					<td colspan="4" id="msg2">
					</td>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td width="110px" align="left">Email 1 :</td>
					<td align="left">
						<input type="text" name="email1" id="email6" value="" style="width:99%" tabindex="1" onfocus="this.select()"/>
					</td>	
				</tr>
				<tr>
					<td align="left">Email 2 :</td>
					<td align="left">
						<input type="text" name="email2" id="email7" value="" style="width:99%" tabindex="2" onfocus="this.select()"/>
					</td>
				</tr>
				<tr>
					<td align="left">Email 3 :</td>
					<td align="left">
						<input type="text" name="email3" id="email8" value="" style="width:99%" tabindex="3" onfocus="this.select()"/>
					</td>
				</tr>
				<tr>
					<td align="left">Email 4 :</td>
					<td align="left">
						<input type="text" name="email4" id="email9" value="" style="width:99%" tabindex="4" onfocus="this.select()"/>
					</td>
				</tr>
				<tr>
					<td align="left">Email 5 :</td>
					<td align="left">
						<input type="text" name="email5" id="email10" value="" style="width:99%" tabindex="5" onfocus="this.select()"/>
					</td>
				</tr>				
				<tr>
					<td colspan="4" align="center" height="50px">
						<input onclick="doSend2()" value="Gửi Thư Mời" type="button" tabindex="6">
					</td>
				</tr>
			</tbody>
		</table>
		</form>
		<div id="tabs_2_result"></div>
	</div>
</div>
<script type="text/javascript">
	var objediting; //Object luu lai row dang chinh sua
	function message1(msg,type) {
		if(type==1) { //Thong diep thong bao
			str = "<div class='positive'><span class='bodytext' style='padding-left:30px;'><strong>"+msg+"</strong></span></div>";
			byId("msg").innerHTML = str;
		} else if(type == 0) { //Thong diep bao loi
			str = "<div class='negative'><span class='bodytext' style='padding-left:30px;'><strong>"+msg+"</strong></span></div>";
			byId("msg").innerHTML = str;
		}
	}
	function message2(msg,type) {
		if(type==1) { //Thong diep thong bao
			str = "<div class='positive'><span class='bodytext' style='padding-left:30px;'><strong>"+msg+"</strong></span></div>";
			byId("msg2").innerHTML = str;
		} else if(type == 0) { //Thong diep bao loi
			str = "<div class='negative'><span class='bodytext' style='padding-left:30px;'><strong>"+msg+"</strong></span></div>";
			byId("msg2").innerHTML = str;
		}
	}
	function doSend1() {
		dataString = $("#formMoinhatuyendung").serialize();
		//alert(dataString);return;
		$("#tabs_1_result").html("");
		block("#tabs-1");	
		$.ajax({
			type: "POST",
			cache: false,
			url : url("/admin/sendMailEmployer&"),
			data: dataString,
			success: function(data){
				
				unblock("#tabs-1");	
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/admin/login");
					return;
				}
				var jsonObj = eval( "(" + data + ")" );
				var result = "";
				for(i=0;jsonObj[i]!=null;i++) {
					if(jsonObj[i].result=="Ok")
						result+=jsonObj[i].email+" : <font color='green'>"+jsonObj[i].result+"</font><br/>";
					else
						result+=jsonObj[i].email+" : <font color='red'>"+jsonObj[i].result+"</font><br/>";
				}
				//alert(result);
				byId("email1").value = "";
				byId("email2").value = "";
				byId("email3").value = "";
				byId("email4").value = "";
				byId("email5").value = "";
				$("#tabs_1_result").html(result);
			},
			error: function(data){ unblock("#tabs-1");alert (data);}	
		});
	}
	function doSend2() {
		dataString = $("#formMoiungvien").serialize();
		//alert(dataString);return;
		$("#tabs_2_result").html("");
		block("#tabs-2");	
		$.ajax({
			type: "POST",
			cache: false,
			url : url("/admin/sendMailFreelancer&"),
			data: dataString,
			success: function(data){
				
				unblock("#tabs-2");	
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/admin/login");
					return;
				}
				var jsonObj = eval( "(" + data + ")" );
				var result = "";
				for(i=0;jsonObj[i]!=null;i++) {
					if(jsonObj[i].result=="Ok")
						result+=jsonObj[i].email+" : <font color='green'>"+jsonObj[i].result+"</font><br/>";
					else
						result+=jsonObj[i].email+" : <font color='red'>"+jsonObj[i].result+"</font><br/>";
				}
				//alert(result);
				byId("email6").value = "";
				byId("email7").value = "";
				byId("email8").value = "";
				byId("email9").value = "";
				byId("email10").value = "";
				$("#tabs_2_result").html(result);
			},
			error: function(data){ unblock("#tabs-2");alert (data);}	
		});
	}
	$(document).ready(function(){				
		$("#title_page").text("Công Cụ PR");
		$("#tabs").tabs();
	});
</script>