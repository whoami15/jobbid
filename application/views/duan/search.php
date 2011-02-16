<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/validator.js"></script>
<script type="text/javascript" src="<?php echo BASE_PATH ?>/public/js/utils.js"></script>
<style type="text/css">
	.multiselect {  
		height:200px;
		width:270px; 
	} 
	.divfloat1 {
		float:left;
		padding:5px 5px 5px 15px;
		position:relative;
		width:46%;
		text-align: left;
	}
</style>
<div id="content" style="width:100%;">
	<div class="ui-widget-header ui-helper-clearfix ui-corner-top" style="border:none;padding-left: 5px" id="content_title">Tìm nhanh dự án</div>
	<div class="child_content">
		<table class="center" width="60%">
			<tbody>
			<tr>
				<td align="right">
				Từ khóa :
				</td>
				<td align="left">
				<input type="text" style="width:99%" name="duan_keyword" id="duan_keyword" tabindex=1 value="<?php echo isset($_POST["keyword"])?$_POST["keyword"]:"" ?>"/>
				</td>
			</tr>
			<tr>
				<td align="right">
				Lĩnh vực :
				</td>
				<td align="left">
				<select name="linhvuc_id" id="linhvuc_id" tabindex=2>
					<option value="">---Tất cả lĩnh vực---</option>
					<?php
					foreach($lstLinhvuc as $linhvuc) {
						echo "<option value='".$linhvuc["linhvuc"]["id"]."'>".$linhvuc["linhvuc"]["tenlinhvuc"]."</option>";
					}
					?>
				</select>
				</td>
			</tr>
			<tr>
				<td align="right">
				Tỉnh thành :
				</td>
				<td align="left">
				<select name="tinh_id" id="tinh_id" tabindex=3>
					<option value="">---Tất cả---</option>
					<?php
					foreach($lstTinh as $tinh) {
						echo "<option value='".$tinh["tinh"]["id"]."'>".$tinh["tinh"]["tentinh"]."</option>";
					}
					?>
				</select>
				</td>
			</tr>
			<tr>
				<td colspan="2" align="center">
				<input type="button" id="btSearch" value="Tìm Kiếm" onclick="doSearch()"/>
				</td>
			</tr>
			<tbody>
		</table>
		<div id="datagrid"></div>
	</div>
	<div  class="ui-widget-header ui-helper-clearfix" style="border:none;padding-left: 5px" id="content_title2">Tìm dự án theo kỹ năng</div>
	<?php
	$prevLinhvuc = '';
	$i = 0;
	$flagLoop = true;
	while($flagLoop) {
		if(!isset($lstData2[$i]))
			break;
		$data = $lstData2[$i]; 
		echo '<div class="divfloat1" >';
		echo '<strong>'.$data['linhvuc']['tenlinhvuc'].'</strong><br/>';
		$prevLinhvuc = '';
		while(true) {
			if(!isset($lstData2[$i])){
				$flagLoop = false;
				break;
			}
			$data = $lstData2[$i];
			if($prevLinhvuc == null)
				$prevLinhvuc = $data['linhvuc']['id'];
			else if($prevLinhvuc!=$data['linhvuc']['id'])
				break;
			echo '&nbsp;&nbsp;&nbsp;&nbsp;<a href="'.BASE_PATH.'/skill&skill_id='.$data['skill']['id'].'" class="link">'.$data['skill']['skillname'].'</a> ('.$data['']['soduan'].')<br/>';
			$i++;
		}
		echo '</div>';
	}
	?>
</div>
<script type="text/javascript">
	//Search area
	var arrCondition = {cond_keyword:"",cond_linhvuc:"",cond_tinh:""};
	var searchString = '';
	function checkChangeConditionSearch() {
		var bFlagChange = false;
		if(arrCondition['cond_keyword'] != byId("duan_keyword").value) {	
			bFlagChange = true;
			arrCondition['cond_keyword'] = byId("duan_keyword").value;
		}
		if(arrCondition['cond_linhvuc'] != byId("linhvuc_id").value) {
			bFlagChange = true;
			arrCondition['cond_linhvuc'] = byId("linhvuc_id").value;
		}
		if(arrCondition['cond_tinh'] != byId("tinh_id").value) {
			bFlagChange = true;
			arrCondition['cond_tinh'] = byId("tinh_id").value;
		}
		return bFlagChange;
	}
	function selectpage(page) {
		loadlistduan(searchString+"pageindex="+page);
	};
	function doSearch() {
		if(checkChangeConditionSearch() == true) { //Nếu có sự thay đổi đk tìm kiếm
			searchString = "duan_keyword="+byId("duan_keyword").value+"&linhvuc_id="+byId("linhvuc_id").value+"&tinh_id="+byId("tinh_id").value+"&";
			loadlistduan(searchString+"pageindex=1");	
		}	
	}
	function loadlistduan(dataString) {	
		block('#content');
		$.ajax({
			type: "POST",
			cache: false,
			url : url('/duan/lstDuanBySearch'),
			data: dataString,
			success: function(data){
				unblock('#content');
				$("#datagrid").html(data);	
				document.title = "Tìm Dự Án - Từ khóa : "+byId('duan_keyword').value;
			},
			error: function(data){ alert (data);unblock('#content');}	
		});
		
	}
	//End Search area
	function message(msg,type) {
		if(type==1) { //Thong diep thong bao
			str = "<div class='positive'><span class='bodytext' style='padding-left:30px;'>"+msg+"</span></div>";
			byId("msg").innerHTML = str;
		} else if(type == 0) { //Thong diep bao loi
			str = "<div class='negative'><span class='bodytext' style='padding-left:30px;'>"+msg+"</span></div>";
			byId("msg").innerHTML = str;
		}
	}	
	function doReset() {
		$("#formDuan")[0].reset(); //Reset form cua jquery, giu lai gia tri mac dinh cua cac field	
		$("#formDuan :input").css('border-color','');
		byId("msg").innerHTML="";
	}
	function validateFormDuAn(formData, jqForm, options) {
		location.href = "#top";
		checkValidate=true;
		var kinhphi = getNumber(byId("duan_kinhphi").value);
		validate(['require'],'duan_tenduan',["Vui lòng nhập tên dự án!"]);
		validate(['requireselect'],'duan_linhvuc_id',["Vui lòng chọn 1 lĩnh vực!"]);
		if(checkValidate==false) {
			return false;
		}
		byId("duan_alias").value = remove_space(remove_accents(byId("duan_tenduan").value));
		$("#select2").each(function(){  
			$("#select2 option").attr("selected","selected");
		});
		byId("msg").innerHTML="<div class='loading'><span class='bodytext' style='padding-left:30px;'>Đang xử lý...</span></div>";
		return true;
	}
	function loadListSkills() {
		var value = byId("duan_linhvuc_id").value;
		if(value=="")
			return;
		block("#select1");
		$.ajax({
			type: "GET",
			cache: false,
			url : url("/skill/getSkillsByLinhvuc&linhvuc_id="+value),
			success: function(data){
				unblock("#select1");
				if(data == AJAX_ERROR_NOTLOGIN) {
					location.href = url("/account/login");
					return;
				}
				if(data == AJAX_ERROR_SYSTEM) {
					return;
				}
				var jsonObj = eval( "(" + data + ")" );
				$('#select1').html("");
				for(i=0;jsonObj[i]!=null;i++) {
					$('#select1').append("<option value="+jsonObj[i].id+" >"+jsonObj[i].skillname+"</option>");
				}
			},
			error: function(data){ unblock("#select1");;alert (data);}	
		});
	}
	$(document).ready(function() {
		// pass options to ajaxForm 
		//document.title = "Tìm Dự Án - "+document.title;
		menuid = '#tim-du-an';
		$("#menu "+menuid).addClass("current");
		$("input:submit, input:button", "body").button();
		<?php
		if(isset($_POST["keyword"]))
			echo "doSearch();";
		?>
	});
</script>
