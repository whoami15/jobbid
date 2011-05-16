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
	<div class="ui-widget-header ui-helper-clearfix ui-corner-top" style="border:none;padding-left: 5px" id="content_title"></div>
	<input type="hidden" id="linhvuc_id" value="<?php echo $dataLinhvuc["linhvuc"]["id"]?>"/>
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
				<td style="width:100px">Giá thầu TB</td>
				<td style="width:50px">Bid</td>
				<td style="width:120px">Ngày post</td>
				<td style="width:110px">Còn</td>
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
					<td align="left"><a class='link' href='<?php echo BASE_PATH."/duan/view/".$duan["duan"]["id"]."/".$duan["duan"]["alias"] ?>'><?php echo $duan["duan"]["tenduan"]?></a></td>
					<td align="center" style="width:100px"><?php echo $html->FormatMoney($duan["duan"]["averagecost"])?></td>
					<td align="center"style="width:50px" ><?php echo $duan["duan"]["bidcount"]?></td>
					<td align="left" style="width:120px"><?php  echo $html->format_date($duan["duan"]["ngaypost"],'d/m/Y H:i')?></td>
					<td align="center" style="width:110px"><?php echo $html->getDaysFromSecond($duan[""]["timeleft"])?></td>
				</tr>
				<?php
			}
			?>
		</tbody>
	</table>
	</div>
</div>
<script type="text/javascript">	
	function selectpage(page) {
		loadListDuans(page);
	};
	function loadListDuans(page) {
		block("#content");
		$.ajax({
			type : "GET",
			cache: false,
			url: url("/linhvuc/lstDuanByLinhvuc/"+page+"&id="+byId("linhvuc_id").value),
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
		//document.title = "<?php echo $dataLinhvuc["linhvuc"]["tenlinhvuc"] ?> - "+document.title;
		$("#tfoot_paging").html($("#thead_paging").html());
		menuid = '#tim-du-an';
		$("#menu "+menuid).addClass("current");
		$("#content_title").html("<a class='link2' href='"+url('/duan/search')+"'>Tìm dự án</a> &#8250 <?php echo $dataLinhvuc["linhvuc"]["tenlinhvuc"]?>");
		$("input:submit, input:button", "body").button();
	});
</script>
