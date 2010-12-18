<style>
#tipmsg {
	padding-left:10px;
	color:white !important;
	font-size: 10pt !important;
}
</style>
<div id="content" style="width:100%;">
	<div class="ui-widget-header ui-helper-clearfix ui-corner-all" style='text-align: left; padding-left: 10px; margin-left: -5px; width: 100%;' id="content_title">Content</div>
	<fieldset style="margin-bottom: 10px; margin-top: 10px; text-align: center;">
		<legend><span style="font-weight:bold;"><?php echo $dataDuan["duan"]["tenduan"] ?></span></legend>
		<table class="center" width="100%">
			<thead>
				<tr>
					<td colspan="4" id="msg" align="left">
					</td>
				</tr>
			</thead>
			<tbody>
				<tr height="30px">
					<td width="50%" align="left" >
					<b>Trạng thái :</b> <?php echo $status ?>
					</td>
					<td width="50%" align="left" >
					<b>Số hồ sơ thầu :</b> <?php echo $dataDuan["duan"]["bidcount"] ?>
					</td>
				</tr>
				<tr height="30px">
					<td align="left" >
					<b>Chi phí : </b><?php echo $html->FormatMoney($dataDuan["duan"]["costmin"])?> &#8250 <?php echo $html->FormatMoney($dataDuan["duan"]["costmax"])?> (VNĐ)
					</td>
					<td align="left" >
					<b>Giá thầu trung bình : </b><?php echo $html->FormatMoney($dataDuan["duan"]["averagecost"])?> VNĐ
					</td> 
				</tr>
				<tr height="30px">
					<td width="33%" align="left" >
					<b>Địa điểm :</b> <?php echo $dataDuan["tinh"]["tentinh"] ?>
					</td>
					<td align="left" >
					<b>Lĩnh vực :</b> <?php echo $dataDuan["linhvuc"]["tenlinhvuc"] ?>
					</td>
				</tr>
				<tr height="30px">
					<td align="left" >
					<b>Ngày kết thúc : </b><?php echo $html->format_date($dataDuan["duan"]["ngayketthuc"],'d/m/Y') ?>
					</td>
					<td align="left" >
					<b>Số lượt xem : </b><?php echo $dataDuan["duan"]["views"] ?>
					</td>
				</tr>
				<tr height="30px">
					<td align="left" colspan="2">
					<b>File đính kèm : </b><a class="link" title="<?php echo $dataDuan["file"]["filename"] ?>" target="_blank" href="<?php echo BASE_PATH.'/file/download/'.$dataDuan["file"]["id"] ?>"><?php echo $html->trimString($dataDuan["file"]["filename"],100) ?></a>
					</td>
				</tr>
				<tr height="30px">
					<td align="left" colspan="2">
					<b>Kỹ năng bắt buộc :</b>
					</td>
				</tr>
				<tr id="tr_lstSkills">
					<td align="left" colspan="2" style="padding-left:50px">
						<div id="div_lstSkills" style="min-height:50px;width:100%">
						<ul id="ul_lstSkills">
						
						</ul>
						</div>
					</td>
				</tr>
				<tr height="30px">
					<td align="left" colspan="2">
					<b>Thông tin chi tiết :</b>
					</td>
				</tr>
				<tr>
					<td align="left" colspan="2" style="padding-left:50px">
					<?php echo $dataDuan["duan"]["thongtinchitiet"] ?>
					</td>
				</tr>
				<?php
				if(isset($dataDuan["nhathau"]["id"])) {
				?>
				<tr height="30px">
					<td align="left" colspan="2">
					<b><span style="color:red">Thắng thầu : </span></b><a class='link' href='<?php echo BASE_PATH."/hosothau/xem_ho_so/".$dataDuan["duan"]["hosothau_id"]."/".$dataDuan["duan"]["id"] ?>'><?php echo $dataDuan["nhathau"]["displayname"]?></a>
					</td>
				</tr>
				<?php
				}
				?>
				<tr height="30px">
					<td align="center" colspan="2">
					<?php
					if(isset($_SESSION["user"]) && $dataDuan["duan"]["account_id"]==$_SESSION["user"]["account"]["id"]) {
						?>
						<input type="button" value="Sửa dự án này" onclick="editMyProject(<?php echo $dataDuan["duan"]["id"] ?>)"/>
						<?php
					} else {
						if($dataDuan[""]["timeleft"]>0) {
						?>
						<input id="btGuihoso" type="button" value="Gửi hồ sơ thầu" onclick="guihosothau(<?php echo $dataDuan["duan"]["id"] ?>)"/>
						<?php
						}
						?>
						<input type="button" id="btMarkduan" value="Lưu vào dự án quan tâm" onclick="doMarkDuan(<?php echo $dataDuan["duan"]["id"] ?>)"/>
						<?php
					}
					?>
					</td>
				</tr>
			</tbody>
		</table>
	</fieldset>
	<fieldset style="margin-bottom: 10px; margin-top: 10px; text-align: center;">
		<legend><span style="font-weight:bold;">Danh sách nhà thầu tham gia đấu giá :</span></legend>
		<div id="datagrid" style="padding-top:10px;padding-bottom:10px;">
		<table width="100%">
			<thead>
				<tr class="ui-accordion-header ui-helper-reset ui-state-default ui-corner-all" style="font-weight:bold;height:20px;text-align:center;">
					<td>#</td>
					<td>Nhà thầu</td>
					<td>Giá thầu</td>
					<td>Đánh giá</td>
				</tr>
			</thead>
		</table>
	</div>
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
	function getSkillsByDuan(duan_id) {
		if(duan_id=="")
			return;
		block("#div_lstSkills");
		$.ajax({
			type: "GET",
			cache: false,
			url : url("/skill/getSkillsByDuan&duan_id="+duan_id),
			success: function(data){
				unblock("#div_lstSkills");
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/account/login");
					return;
				}
				if(data == AJAX_ERROR_SYSTEM) {
					return;
				}
				byId("ul_lstSkills").innerHTML = "";
				var jsonObj = eval( "(" + data + ")" );
				for(i=0;jsonObj[i]!=null;i++) {
					$("#ul_lstSkills").append("<li>"+jsonObj[i].skillname+"</li>");
				}
			},
			error: function(data){ unblock("#div_lstSkills");;alert (data);}	
		});
	}
	function selectpage(page) {
		loadListHosothau(page);
	};
	function guihosothau(duan_id) {
		location.href = "#top";
		$('#btGuihoso').attr('disabled','disabled');
		byId("msg").innerHTML="<div class='loading'><span class='bodytext' style='padding-left:30px;'>Đang kiểm tra...</span></div>";
		$.ajax({
			type : "GET",
			cache: false,
			url: url("/nhathau/doChecknhathau"),
			success : function(data){	
				$('#btGuihoso').removeAttr('disabled');
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/account/login");
					return;
				}
				if(data == "DONE") {
					location.href = url("/hosothau&duan_id="+duan_id);
				} else {
					message('Lỗi! Bạn chưa tạo hồ sơ nhà thầu (click <a href="'+url('/nhathau/add')+'" class="link">vào đây</a> để tạo hồ sơ)',0);	
				}	
				
			},
			error: function(data){ 
				$('#btGuihoso').removeAttr('disabled');
				alert (data);
			}			
		});
	}
	function loadListHosothau(page) {
		block("#datagrid");
		$.ajax({
			type : "GET",
			cache: false,
			url: url("/hosothau/lstHosothauByDuan/"+page+"&duan_id=<?php echo $dataDuan["duan"]["id"] ?>"),
			success : function(data){	
				//alert(data);
				unblock("#datagrid");
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/account/login");
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
	function doMarkDuan(duan_id) {
		location.href = "#top";
		$('#btMarkduan').attr('disabled','disabled');
		byId("msg").innerHTML="<div class='loading'><span class='bodytext' style='padding-left:30px;'>Đang xử lý...</span></div>";
		$.ajax({
			type: "GET",
			cache: false,
			url : url("/duan/doMarkDuan&duan_id="+duan_id),
			success: function(data){
				$('#btMarkduan').removeAttr('disabled');
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/account/login");
					return;
				}
				if(data == AJAX_ERROR_SYSTEM) {
					return;
				}
				if(data == "ERROR_EXIST") {
					message("Dự án này đã có trong kho dự án quan tâm của bạn!",0);
					return;
				}
				if(data == AJAX_DONE) {
					message("Lưu vào kho dự án quan tâm thành công!",1);
				} 
			},
			error: function(data){ $('#btMarkduan').removeAttr('disabled');alert (data);}	
		});
	}
	function editMyProject(duan_id) {
		if(duan_id==null) 
			return;
		location.href = url('/duan/edit&duan_id='+duan_id);
	}
	function showinfo(_this) {
		
		var cells = _this.parentNode.parentNode.cells;
		milestone = $(cells.td_milestone).text();
		thoigian = $(cells.td_thoigian).text();
		timeofbid = $(cells.td_timeofbid).text();
		var str = '&nbsp;<b>MileStone :</b> '+milestone+'<br/>&nbsp;<b>Thời gian :</b> '+thoigian+'<br/>&nbsp;<b>Đã gửi :</b> '+timeofbid+'<br/>&nbsp;<b>Lời nhắn :</b><br/><div id="tipmsg">Loading...</div>';
		showtip(str,600);
		id = $(cells.td_id).text();
		$.ajax({
			type : "GET",
			cache: true,
			url: url("/hosothau/getContent&id="+id),
			success : function(data){	
				//alert(data);
				byId("tipmsg").innerHTML = data;
			},
			error: function(data){ 
				alert (data);
			}			
		});
		
	}
	$(document).ready(function() {
		$("#content_title").css("width",width_content-19);
		$("#content_title").html("<a class='link2' href='"+url('/duan/search')+"'>Tìm dự án</a> &#8250 <a class='link2' href='"+url('/duan/linhvuc/<?php echo $dataDuan["duan"]["linhvuc_id"]?>')+"'><?php echo $dataDuan["linhvuc"]["tenlinhvuc"]?></a> &#8250 Thông tin dự án");
		$("#tfoot_paging").html($("#thead_paging").html());
		menuid = '#tim-du-an';
		$("#menu "+menuid).addClass("current");
		$("input:submit, input:button", "body").button();
		getSkillsByDuan(<?php echo $dataDuan["duan"]["id"]?>);
		loadListHosothau(1);
	});
</script>
