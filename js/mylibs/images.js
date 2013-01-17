var zendcms_images = {
	templates : $("#templates"),
	showLoading : function(bShow) {
		if(bShow == true) {
			$("#display_zone .more_zone .more").hide();
			$("#display_zone .more_zone .loading").show();
		} else {
			$("#display_zone .more_zone .loading").hide();
			$("#display_zone .more_zone .more").show();
		}
		
	},
	fillDataIntoImageTemplate : function(data) {
		var image_template = $("#image",this.templates).html();
		reps = {
			id : data.id,
			width : data.width,
			height : data.height,
			path_thumb : baseUrl+data.path_thumb,
			filename : data.filename
		};
		return replaceText(image_template,reps);
	},
	binding_menu1 : {
		bindings: {
			'delete': function(t) {
				var image_id = $("#id",t).val();
				var filename = $("#filename",t).val();
				if(image_id == null)
					return;
				if(!confirm('Bạn muốn xóa file '+filename+'?'))
					return;
				block('#images_zone');
				$.ajax({
					type : "GET",
					cache: false,
					url: baseUrl +'/back/file/delete-image/image_id/'+image_id,
					success : function(data){	
						unblock('#images_zone');
						if(data == 'NOT_LOGIN') {
							location.href = LOGIN_PAGE;
							return;
						}
						if(data == 'OK') {
							$(t).remove();
							zendcms_images.resetViewInfor();
							return;
						}
						alert(ERROR_MESSAGE);
					},
					error: function(data){ 
						alert (ERROR_MESSAGE);
						unblock('#images_zone');
					}			
				});
			},
			'resize': function(t) {
				var orgWidth = parseInt($("#width",t).val());
				var orgHeight = parseInt($("#height",t).val());
				var image_id = parseInt($("#id",t).val());
				reps = {
					width : orgWidth,
					height : orgHeight,
					image_id : image_id
				}
				zendcms_images.showDialog(replaceText($("#resize",zendcms_images.templates).html(),reps),'Đổi kích thước ảnh',200);
				var ratioWidth = orgHeight/orgWidth;
				var ratioHeight = orgWidth/orgHeight;
				var inputWidth = $("#dialog #width");
				var inputHeight = $("#dialog #height");
				inputWidth.select();
				inputWidth.focus(function(){
					$(this).select();
				});
				inputHeight.focus(function(){
					$(this).select();
				});
				inputWidth.keyup(function() {
					if(this.value=='' || $("#dialog #constrain_proprtation")[0].checked==false)
						return;
					if(isNaN(this.value)) {
						alert('Vui lòng nhập số!');
						return;
					}
					width = parseInt(this.value);
					inputHeight.val(Math.round(width*ratioWidth));
				});
				inputHeight.keyup(function() {
					if(this.value=='' || $("#dialog #constrain_proprtation")[0].checked==false)
						return;
					if(isNaN(this.value)) {
						alert('Vui lòng nhập số!');
						return;
					}
					height = parseInt(this.value);
					inputWidth.val(Math.round(height*ratioHeight));
				});
			}
		}
	},
	loadImages : function() {
		var page = $("#images_zone #page").val();
		page = parseInt(page);
		//block('#images_zone');
		var folder_id = $("#form_upload #folder_id").val();
		zendcms_images.showLoading(true);
		$.ajax({
			type : "GET",
			cache: false,
			url: baseUrl +'/back/media/load-images/page/'+page+'/folder_id/'+folder_id,
			success : function(data){	
				zendcms_images.showLoading(false);
				var show = $("#images_zone #display_zone #show");
				$.each(data.data, function() {
					show.append(zendcms_images.fillDataIntoImageTemplate(this));
					var last = show.children().last();
					if(folder_id==-1) {
						last.contextMenu('myMenu2',zendcms_images.binding_menu2);
					} else {
						last.contextMenu('myMenu1',zendcms_images.binding_menu1);
					}
					$("img",last).load(function() {  
						if($(this).width()>200) {
							$(this).width(200);
						}
					}); 
				});
				if(data.bEnd == true) {
					$("#display_zone .more_zone").hide();
				} else {
					$("#display_zone .more_zone").show();
					$("#images_zone #page").val(page+1);
				}
				
			},
			error: function(data){ 
				alert (ERROR_MESSAGE);
				zendcms_images.showLoading(false);
			}			
		});
	},
	resize : function(_this) {
		var width = $("#dialog #width").val();
		var height = $("#dialog #height").val();
		var image_id = $("#dialog #image_id").val();
		if(isNaN(width) || isNaN(height)) {
			alert('Vui lòng nhập kiểu số');
			return;
		}
		if(image_id=='')
			return;
		dataString = 'image_id='+image_id+'&newWidth='+width+'&newHeight='+height;
		_this.disabled = true;
		$.ajax({
			type : "GET",
			cache: false,
			url: baseUrl +'/back/images/resize/',
			data : dataString,
			success : function(data){	
				_this.disabled = false;
				if(data == 'NOT_LOGIN') {
					location.href = LOGIN_PAGE;
					return;
				}
				if(data == 'NOT_EXIST') {
					alert('Ảnh gốc không tồn tại!');
					return;
				}
				if(data == 'OK') {
					zendcms_images.hideDialog();
					var image = $("#image_"+image_id);
					$("#width",image).val(width);
					$("#height",image).val(height);
					return;
				}
				if(data.result == 'ERROR') {
					alert(data.message);
					return;
				}
			},
			error: function(data){ 
				alert (ERROR_MESSAGE);
				_this.disabled = false;
			}			
		});
		
	},
	showDialog : function(msg,title_,width_) {
		$("#dialog").html(msg);
		$("#dialog").dialog({ 
			modal: true,
			resizable: false,
			title : title_,
			width: width_,
			open : function(){
				$("body").css("overflow", "hidden");
			},
			close : function() {
				$("body").css("overflow", "auto");
			}
		});
	},
	hideDialog : function() {
		$("#dialog").dialog('close');
	},
	updatePosition : function() {
		dataString = '';
		order = 1;
		$("#show").children().each(function(){
			dataString+= '&image_id[]='+$("#id",this).val()+'&order[]='+order;
			order++;
		});
		//alert(dataString);
		block("#show");
		$.ajax({
			type : "POST",
			cache: false,
			url: baseUrl +'/back/images/update-position',
			data : dataString,
			success : function(data){	
				unblock("#show");
				if(data == 'NOT_LOGIN') {
					location.href = LOGIN_PAGE;
					return;
				}
				if(data.result == 'ERROR') {
					alert (ERROR_MESSAGE);
					return;
				}
			},
			error: function(data){ 
				unblock("#show");
				alert (ERROR_MESSAGE);
			}			
		});
	}
}
$(document).ready(function(){	 
	$("#file_upload").change(function(){
		if($("#folder_id").val()=='') {
			alert('Error!');
			return;
		}
		//$("#rightwindow #form_upload").hide();
		//$("#rightwindow #progress").show();
		$('#form_upload').submit();
	});
	
	var options = { 
		url:        baseUrl+'/back/file/upload-image1', 
		type:      "post",
		//dataType: "json",
		success:    function(data) { 
			data = jQuery.parseJSON(data);
			if(data.result == 'NOT_LOGIN') {
				location.href = LOGIN_PAGE;
				return;
			}
			if(data.result == 'INVALID') {
				error = "";
				$.each(data.messages,function(){
					error+=this+'\n';
				});
				alert(error);
				return;
			}
			if(data.result == 'OK') {
				$("#images_zone #display_zone #show").prepend(zendcms_images.fillDataIntoImageTemplate(data));
				var first = $("#images_zone #display_zone #show").children().first();
				first.contextMenu('myMenu1',zendcms_images.binding_menu1);
				$("img",first).load(function() {  
					if($(this).width()>200) {
						$(this).width(200);
					}
				});
				return;
			}
			alert(ERROR_MESSAGE);
		},
		error : function(data) {
			alert(ERROR_MESSAGE);
		}
	}; 
	$('#form_upload').ajaxForm(options); 
	zendcms_images.loadImages();
	$.contextMenu.defaults({
		menuStyle : {
			width : "200px"
		},
		itemStyle : {
			cursor: "pointer"
		}
	});
	$( "#show" ).sortable({
		opacity: 0.4,
		revert: true,
		update: function(event, ui) {	
			zendcms_images.updatePosition();
		}
	});
	$( "#show div" ).disableSelection();
});