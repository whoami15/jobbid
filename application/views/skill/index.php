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
	<input type="hidden" id="skill_id" value="<?php echo $skill_id?>"/>
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
				<td>Giá thầu TB</td>
				<td>Bid</td>
				<td>Ngày post</td>
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
					echo "<tr class='alternateRow'>";
				else 
					echo "<tr class='normalRow'>";
				?>
					<td align="left"><a class='link' href='<?php echo BASE_PATH."/duan/view/".$duan["duan"]["id"]."/".$duan["duan"]["alias"] ?>'><?php echo $duan["duan"]["tenduan"]?></a></td>
					<td align="center" ><?php echo $html->FormatMoney($duan["duan"]["averagecost"])?></td>
					<td align="center" ><?php echo $html->FormatMoney($duan["duan"]["bidcount"])?></td>
					<td align="left"><?php  echo $html->format_date($duan["duan"]["ngaypost"],'d/m/Y H:i:s')?></td>
					<td align="center"><?php echo $html->getDaysFromSecond($duan[""]["timeleft"])?></td>
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
			url: url("/skill/lstDuanBySkill/"+page+"&skill_id="+byId("skill_id").value),
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
		$("#tfoot_paging").html($("#thead_paging").html());
		menuid = '#tim-du-an';
		$("#menu "+menuid).addClass("current");
		$("#content_title").html("<a class='link2' href='"+url('/duan/search')+"'>Tìm dự án</a> &#8250 <?php echo $skillname?>");
		$("input:submit, input:button", "body").button();
	});
</script>
