<style type="text/css">
	.multiselect {  
		height:200px;
		width:270px; 
	} 
	.divfloat1 {
		float:left;
		padding:5px 5px 5px 15px;
		position:relative;
		width:45%;
	}
</style>
<div id="content" style="width:100%;">
	<div class="ui-widget-header ui-helper-clearfix ui-corner-top" style="border:none;padding-left: 5px" id="content_title">Danh sách dự án được mời thầu</div>
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
					<td>Còn</td>
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
						echo "<tr class='alternateRow'";
					else 
						echo "<tr class='normalRow'";
					if($duan['moithau']['hadread']==0)
						echo ' style="font-weight: bold;cursor:pointer"';
					else 
						echo 'style="cursor:pointer"';
					echo ' onclick="doRead('.$duan["moithau"]["id"].')" >';
					?>
						<td align="left"><a class='link' href='#'><?php echo $duan["duan"]["tenduan"]?></a></td>
						<td align="center" ><?php echo $html->FormatMoney($duan["duan"]["averagecost"])?></td>
						<td align="center" ><?php echo $html->FormatMoney($duan["duan"]["bidcount"])?></td>
						<td align="center">
							<?php 
							if($duan["duan"]["nhathau_id"]!=null)
								echo "Đã đóng";
							else
								echo $html->getDaysFromSecond($duan["duan"]["active"]==1?$duan[""]["timeleft"]:0)
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
<script type="text/javascript">
	function doRead(moithau_id) {
		if(moithau_id==null)
			return;
		location.href = url("/moithau/doRead/"+moithau_id);
	}
	function selectpage(page) {
		loadListDuans(page);
	};
	function editMyProject(duan_id) {
		if(duan_id==null) 
			return;
		location.href = url('/duan/edit&duan_id='+duan_id);
	}
	function loadListDuans(page) {
		block("#content");
		$.ajax({
			type : "GET",
			cache: false,
			url: url("/moithau/lstMyLetters/"+page),
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
		//document.title = "Danh sách thư mời thầu - "+document.title;
		$("#ds_thu_moi_thau").css('color','#F68618');
		$("input:submit, input:button", "body").button();
		$("#tfoot_paging").html($("#thead_paging").html());
	});
</script>
