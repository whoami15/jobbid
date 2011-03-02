<style type="text/css">
	.divfloat1 {
		float:left;
		padding:5px 5px 5px 15px;
		position:relative;
		width:45%;
	}
</style>
<div id="content" style="width:100%;">
	<div class="ui-widget-header ui-helper-clearfix ui-corner-top" style="border:none;padding-left: 5px" id="content_title">Danh sách nhà thầu</div>
	<div style="padding-top:10px">
	<table class="center" width="60%">
		<tbody>
		<tr>
			<td align="right">
			Lĩnh vực :
			</td>
			<td align="left">
			<select name="linhvuc_id" id="linhvuc_id" onchange="doSearch()">
				<option value="">---Tất cả lĩnh vực---</option>
				<?php
				foreach($lstLinhvuc as $linhvuc) {
					echo "<option value='".$linhvuc["linhvuc"]["id"]."'>".$linhvuc["linhvuc"]["tenlinhvuc"]."</option>";
				}
				?>
			</select>
			</td>
		</tr>
		<tbody>
	</table>
	</div>
	<?php
	$linktmp = BASE_PATH.'/nhathau/tim_nha_thau';
	?>
	<div id="datagrid" style="padding-top:5px;padding-bottom:10px;">
		<table width="100%">
			<thead>
				<tr id="thead_paging">
					<td colspan="11" align="center" style="color:black">
						<?php 
						if($pagesbefore>1)
							echo '<a class="link" style="padding-right:5px" href="'.$linktmp.'">1 ...</a>';
						while($pagesbefore<$pagesindex) {
							echo "<a class='link' href='$linktmp/$pagesbefore'>$pagesbefore</a>";
							$pagesbefore++;
						}
						?>
						<span style="font-weight:bold;color:red"><?php echo $pagesindex ?></span>
						<?php 
						while($pagesnext>$pagesindex) {
							$pagesindex++;
							echo "<a class='link' href='$linktmp/$pagesindex'>$pagesindex</a>";
						}
						if($pagesnext<$pageend)
							echo "<a class='link' style='padding-right:5px' href='$linktmp.'/'.$pageend'>... $pageend</a>";
						?>
								
					</td>
				</tr>
				<tr class="ui-accordion-header ui-helper-reset ui-state-default ui-corner-all" style="font-weight:bold;height:20px;text-align:center;">
					<td>#</td>
					<td>Tên ứng viên</td>
					<td style="width:100px">Đánh giá</td>
				</tr>
			</thead>
			<tfoot>
				<tr id="tfoot_paging"></tr>
			</tfoot>
			<tbody>
				<?php
				$i=0;
				foreach($lstNhathau as $nhathau) {
					$i++;
					if($i%2==0)
						echo "<tr class='alternateRow'>";
					else 
						echo "<tr class='normalRow'>";
					?>
						<td align="center"><?php echo $i ?></td>
						<td align="left"><a class='link' href='<?php echo BASE_PATH ?>/nhathau/xem_ho_so/<?php echo $nhathau["nhathau"]["id"].'/'.$nhathau["nhathau"]['nhathau_alias'] ?>'><?php echo $nhathau["nhathau"]["displayname"]?></a></td>
						<td align="left" style="width:100px">
							<div style="float: left;" id="ctl00_SampleContent_ThaiRating">
								<a style="text-decoration: none;" title="2" id="ctl00_SampleContent_ThaiRating_A" href="javascript:void(0)">
								<?php
								for($j=0;$j<$nhathau["nhathau"]["diemdanhgia"];$j++) {
									echo '<span style="float: left;" class="ratingStar filledRatingStar" id="ctl00_SampleContent_ThaiRating_Star_1">&nbsp;</span>';
								}
								?>
								</a>
							</div>
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
	var arrCondition = {cond_linhvuc:""};
	var searchString = '';
	function checkChangeConditionSearch() {
		var bFlagChange = false;
		if(arrCondition['cond_linhvuc'] != byId("linhvuc_id").value) {
			bFlagChange = true;
			arrCondition['cond_linhvuc'] = byId("linhvuc_id").value;
		}
		return bFlagChange;
	}
	function selectpage(page) {
		loadListDuans(searchString+"pageindex="+page);
	};
	function doSearch() {
		if(checkChangeConditionSearch() == true) { //Nếu có sự thay đổi đk tìm kiếm
			searchString = "linhvuc_id="+byId("linhvuc_id").value+"&";
			loadListDuans(searchString+"pageindex=1");	
		}	
	}
	function loadListDuans(dataString) {	
		block('#content');
		$.ajax({
			type: "POST",
			cache: false,
			url : url('/nhathau/lstNhathauBySearch'),
			data: dataString,
			success: function(data){
				unblock('#content');
				$("#datagrid").html(data);		
			},
			error: function(data){ alert (data);unblock('#content');}	
		});
		
	}
	
	$(document).ready(function() {
		// pass options to ajaxForm 
		//document.title = "Tìm Kiếm Nhà Thầu - www.jobbid.vn";
		menuid = '#tim-nha-thau';
		byId("linhvuc_id").value="";
		$("#menu "+menuid).addClass("current");
		$("input:submit, input:button", "body").button();
		$("#tfoot_paging").html($("#thead_paging").html());
	});
</script>
