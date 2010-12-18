<style>
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
	<div class="ui-widget-header ui-helper-clearfix ui-corner-all" style='text-align: left; padding-left: 10px; margin-left: -5px; width: 100%;' id="content_title">Content</div>
	<input type="hidden" id="linhvuc_id" value="<?php echo $dataLinhvuc["linhvuc"]["id"]?>"/>
	<div id="datagrid" style="padding-top:10px;padding-bottom:10px;">
		<table width="100%">
			<thead>
				<tr class="ui-accordion-header ui-helper-reset ui-state-default ui-corner-all" style="font-weight:bold;height:20px;text-align:center;">
					<td>Tên dự án</td>
					<td>Chi phí</td>
					<td>Bid</td>
					<td>Ngày post</td>
					<td>Còn</td>
				</tr>
			</thead>
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
	function loadListDuans(page) {
		block("#content");
		$.ajax({
			type : "GET",
			cache: false,
			url: url("/duan/lstDuanByLinhvuc/"+page+"&id="+byId("linhvuc_id").value),
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
		$("#content_title").css("width",width_content-19);
		$("#content_title").html("<a class='link2' href='"+url('/duan/search')+"'>Tìm dự án</a> &#8250 <?php echo $dataLinhvuc["linhvuc"]["tenlinhvuc"]?>");
		$("input:submit, input:button", "body").button();
		loadListDuans(1);
	});
</script>
