<div id="content" style="width:100%;">
	<div class="ui-widget-header ui-helper-clearfix ui-corner-top" style="border:none;padding-left: 5px" id="content_title">Danh sách hồ sơ thầu của bạn</div>
	<div id="datagrid" style="padding-top:10px;padding-bottom:10px;">
		<table width="100%">
			<thead>
				<tr id="thead_paging">
					<td colspan="11" align="center" style="color:black">
						<a class="link" style="padding-right:5px" href='#' onclick="selectpage(1)">Begin</a>
						<?php 
						while($pagesbefore<$pagesindex) {
							echo "<a class='link' href='#' onclick='selectpage($pagesbefore)'>$pagesbefore</a>";
							$pagesbefore++;
						}
						?>
						<span style="font-weight:bold;color:red"><?php echo $pagesindex ?></span>
						<?php 
						while($pagesnext>$pagesindex) {
							$pagesindex++;
							echo "<a class='link' href='#' onclick='selectpage($pagesindex)'>$pagesindex</a>";
						}
						?>
						<a class="link" style="padding-left:5px" href='#' onclick="selectpage(<?php echo $pageend ?>)">...<?php echo $pageend ?></a>			
					</td>
				</tr>
				<tr class="ui-accordion-header ui-helper-reset ui-state-default ui-corner-all" style="font-weight:bold;height:20px;text-align:center;">
					<td>Tên dự án</td>
					<td>Trạng thái</td>
					<td>Giá thầu</td>
					<td>Ngày gửi</td>
					<td>Kết quả</td>
				</tr>
			</thead>
			<tfoot>
				<tr id="tfoot_paging"></tr>
			</tfoot>
			<tbody>
				<?php
				$i=0;
				foreach($lstHosthau as $hosothau) {
					$trangthaiduan = "Đang mở";
					if($hosothau["duan"]["nhathau_id"] != null || $hosothau[""]["lefttime"]<0)
						$trangthaiduan = "Đã đóng";
					$i++;
					if($i%2==0)
						echo "<tr class='alternateRow' height='30px'>";
					else 
						echo "<tr class='normalRow' height='30px'>";
					?>
						<td id="td_tenduan" align="left"><a class='link' href='<?php echo BASE_PATH."/duan/view/".$hosothau["duan"]["id"]."/".$hosothau["duan"]["alias"] ?>'><?php echo $hosothau["duan"]["tenduan"]?></a></td>
						<td align="center" ><?php echo $trangthaiduan ?></td>
						<td align="center" ><?php echo $html->FormatMoney($hosothau["hosothau"]["giathau"])?> VNĐ</td>
						<td align="center" ><?php echo $html->format_date($hosothau["hosothau"]["ngaygui"],'d/m/Y H:i:s')?></td>
						<td align="center" >
						<?php 
						if($hosothau["hosothau"]["trangthai"] == 2) 
							echo '<span style="color:red">Trúng Thầu</span>';
						?>
						</td>
					</tr>
					<?php
				}
				?>
			</tbody>
		</table>
	</div>
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
	function selectpage(page) {
		loadListHosothau(page);
	};
	function loadListHosothau(page) {
		block("#content");
		$.ajax({
			type : "GET",
			cache: false,
			url: url("/hosothau/lstHosothauByNhathau/"+page),
			success : function(data){	
				//alert(data);
				unblock("#content");
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/account/login");
				} else {
					$("#datagrid").html(data);
					$("input:submit, input:button", "#datagrid").button();	
				}
				
			},
			error: function(data){ 
				unblock("#content");
				alert (data);
			}			
		});
	}
	$(document).ready(function() {
		// pass options to ajaxForm 
		document.title = "Danh Sách Hồ Sơ Thầu Đã Gửi - "+document.title;
		$("#ds_ho_so_thau").css('color','#F68618');
		$("input:submit, input:button", "body").button();
		$("#tfoot_paging").html($("#thead_paging").html());
	});
</script>
