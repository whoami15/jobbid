<div id="content" style="width:100%;">
	<div class="ui-widget-header ui-helper-clearfix ui-corner-top" style="border:none;padding-left: 5px" id="content_title">Danh sách dự án quan tâm</div>
	<div id="datagrid" style="padding-top:10px;padding-bottom:10px;">
		<table width="100%">
			<thead>
				<tr id="thead_paging">
					<td colspan="11" align="center" style="color:black">
						<div class="yt-uix-pager">
							<?php
							if($pagesbefore>1)
								echo '<button onclick="selectpage(1)" type="button" class=" yt-uix-button" ><span class="yt-uix-button-content">1</span></button> ...';
							while($pagesbefore<$pagesindex) {
								echo "<button onclick='selectpage($pagesbefore)' type='button' class=' yt-uix-button' ><span class='yt-uix-button-content'>$pagesbefore</span></button>";
								$pagesbefore++;
							}
							echo "<button type='button' class='yt-uix-pager-selected yt-uix-button' ><span class='yt-uix-button-content'>$pagesindex</span></button>";
							while($pagesnext>$pagesindex) {
								$pagesindex++;
								echo "<button onclick='selectpage($pagesindex)' type='button' class=' yt-uix-button' ><span class='yt-uix-button-content'>$pagesindex</span></button>";
							}
							if($pagesnext<$pageend)
								echo '... <button onclick="selectpage('.$pageend.')" type="button" class=" yt-uix-button" ><span class="yt-uix-button-content">'.$pageend.'</span></button>';
							?>
						</div>			
					</td>
				</tr>
				<tr class="ui-accordion-header ui-helper-reset ui-state-default ui-corner-all" style="font-weight:bold;height:20px;text-align:center;">
					<td>Tên dự án</td>
					<td>Giá thầu TB</td>
					<td>Bid</td>
					<td>Lĩnh vực</td>
					<td>Còn</td>
					<td>Xóa</td>
				</tr>
			</thead>
			<tfoot>
				<tr id="tfoot_paging"></tr>
			</tfoot>
			<tbody>
				<?php
				$i=0;
				foreach($lstDuan as $duan) {
					$i++;
					if($i%2==0)
						echo "<tr class='alternateRow'>";
					else 
						echo "<tr class='normalRow'>";
					?>
						<td id="td_id" style="display:none"><?php echo $duan["duan"]["id"]?></td>
						<td align="left"><a class='link' href='<?php echo BASE_PATH."/duan/view/".$duan["duan"]["id"]."/".$duan["duan"]["alias"] ?>'><?php echo $duan["duan"]["tenduan"]?></a></td>
						<td align="center" ><?php echo $html->FormatMoney($duan["duan"]["averagecost"])?></td>
						<td align="center" ><?php echo $html->FormatMoney($duan["duan"]["bidcount"])?></td>
						<td align="left"><?php  echo $duan["linhvuc"]["tenlinhvuc"] ?></td>
						<td align="center">
						<?php 
						if($duan["duan"]["nhathau_id"]!=null)
							echo "Đã đóng";
						else
							echo $html->getDaysFromSecond($duan["duan"]["active"]==1?$duan[""]["timeleft"]:0)
						?>
						</td>
						<td align="center">
							<img style="cursor:pointer" onclick="deleteDuanmark(this)" title="Xóa" alt="remove" src="<?php echo BASE_PATH ?>/public/images/icons/remove.png"/> 
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
		loadListDuans(page);
	};
	function deleteDuanmark(_this) {
		if(_this==null) 
			return;
		if(!confirm("Xóa dự án này ra khỏi kho dự án quan tâm của bạn?"))
			return;
		var tr = _this.parentNode.parentNode;
		var cells = tr.cells;
		tr.style.backgroundColor = CONST_ROWSELECTED_COLOR;	
		objediting = tr;
		block("#content");
		var parent = $(cells).parent();
		$.ajax({
			type: "GET",
			cache: false,
			url : url("/duan/deleteDuanmark&duan_id="+$.trim($(cells.td_id).text())),
			success: function(data){
				unblock("#content");
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/account/login");
					return;
				}
				if(data == AJAX_DONE) {
					//Load luoi du lieu	
					parent.fadeOut('slow', function() {$(this).remove();}); 
				} else {
					alert('Thao tác không thành công!');										
				}
			},
			error: function(data){ unblock("#content");alert (data);}	
		});
	}
	function loadListDuans(page) {
		block("#content");
		$.ajax({
			type : "GET",
			cache: false,
			url: url("/duan/lstDuanMark/"+page),
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
		//document.title = "Danh Sách Dự Án Quan Tâm - "+document.title;
		$("#ds_du_an_quan_tam").css('color','#F68618');
		$("input:submit, input:button", "body").button();
		$("#tfoot_paging").html($("#thead_paging").html());
	});
</script>
