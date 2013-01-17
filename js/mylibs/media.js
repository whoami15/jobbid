var media = {
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
			path : baseUrl+data.path,
			width : data.width,
			height : data.height,
			size : parseSize(data.size),
			create_time : $.format.date(data.create_time,'dd/MM/yyyy HH:mm'),
			create_user : data.create_user,
			path_thumb : baseUrl+data.path_thumb,
			filename : data.filename,
			folder_name : data.folder_name==null?'Images':data.folder_name
		};
		return replaceText(image_template,reps);
	},
	fillDataIntoInfor1 : function(size,create_time,create_user,filename,folder_name,dimensions) {
		var infor1 = $("#infor1",this.templates).html();
		reps = {
			size : size,
			create_time : create_time,
			dimensions : dimensions,
			create_user : create_user,
			filename : filename,
			folder_name : folder_name
		};
		return replaceText(infor1,reps);
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
							media.resetViewInfor();
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
			'insert': function(t) {
				alert('insert');
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
				media.showDialog(replaceText($("#resize",media.templates).html(),reps),'Đổi kích thước ảnh',200);
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
	binding_menu2 : {
		bindings: {
			'restore': function(t) {
				alert('restore');
			},
			'delete': function(t) {
				alert('delete');
			}
		}
	},
	loadImages : function() {
		var page = $("#images_zone #page").val();
		page = parseInt(page);
		//block('#images_zone');
		var folder_id = $("#form_upload #folder_id").val();
		media.showLoading(true);
		$.ajax({
			type : "GET",
			cache: false,
			url: baseUrl +'/back/media/load-images/page/'+page+'/folder_id/'+folder_id,
			success : function(data){	
				media.showLoading(false);
				var show = $("#images_zone #display_zone #show");
				$.each(data.data, function() {
					show.append(media.fillDataIntoImageTemplate(this));
					var last = show.children().last();
					if(folder_id==-1) {
						last.contextMenu('myMenu2',media.binding_menu2);
					} else {
						last.contextMenu('myMenu1',media.binding_menu1);
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
				media.showLoading(false);
			}			
		});
	},
	viewInfo : function(_this) {
		var image = $(_this);
		var path = $("#path",image).val();
		var information = $("#rightwindow #information");
		var infor1 = $("#infor1",information);
		var infor2 = $("#infor2",information);
		infor1.empty();
		infor1.html(media.fillDataIntoInfor1($("#size",image).val(),$("#create_time",image).val(),$("#create_user",image).val(),$("#filename",image).val(),$("#folder_name",image).val(),$("#width",image).val() + ' x ' + $("#height",image).val()));
		//$("#size",information).text($("#size",image).val()).prettynumber();
		//$("#create_time",information).text($("#create_time",image).val());
		//$("#create_user",information).text($("#create_user",image).val());
		//$("#filename",information).html($("#filename",image).val());
		$("#path",infor2).val(DOMAIN + path);
		//$("#size",infor1).prettynumber();
		$("li",infor1).ellipsis({
			setTitle : 'always'
		});
	},
	resetViewInfor : function() {
		var information = $("#rightwindow #information");
		var infor1 = $("#infor1",information);
		var infor2 = $("#infor2",information);
		infor1.empty();
		$("#path",infor2).val('');
	},
	resize : function(_this) {
		var width = $("#dialog #width").val();
		var height = $("#dialog #height").val();
		var image_id = $("#dialog #image_id").val();
		var overwrite = $("#dialog #overwrite")[0].checked==true?'1':'0';
		if(isNaN(width) || isNaN(height)) {
			alert('Vui lòng nhập kiểu số');
			return;
		}
		if(image_id=='')
			return;
		dataString = 'image_id='+image_id+'&newWidth='+width+'&newHeight='+height+'&overwrite='+overwrite;
		_this.disabled = true;
		$.ajax({
			type : "GET",
			cache: false,
			url: baseUrl +'/back/file/resize/',
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
				if(data.result == 'OK') {
					media.hideDialog();
					$("#images_zone #display_zone #show").prepend(media.fillDataIntoImageTemplate(data));
					var first = $("#images_zone #display_zone #show").children().first();
					first.contextMenu('myMenu1',media.binding_menu1);
					$("img",first).load(function() {  
						if($(this).width()>200) {
							$(this).width(200);
						}
					});
					if(overwrite == '1') {
						$("#image_"+image_id).remove();
						media.resetViewInfor();
					}
					return;
				}
				if(data.result == 'ERROR') {
					alert(data.message);
					return;
				}
				alert (ERROR_MESSAGE);
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
	}
}
$(document).ready(function(){	 
	$("#browser").treeview();
	$("#browser .folder").unbind('click');
	$("#file_upload").click(function(){
		if($("#form_upload #folder_id").val()=='') {
			alert('Vui lòng chọn thư mục chứa file upload!');
			return false;
		}
		return true;
	});
	$("#file_upload").change(function(){
		if($("#form_upload #folder_id").val()=='') {
			alert('Vui lòng chọn thư mục chứa file upload!');
			return;
		}
		//$("#rightwindow #form_upload").hide();
		//$("#rightwindow #progress").show();
		$('#form_upload').submit();
	});
	$("#browser .folder").click(function(){
		$("#leftwindow .active").removeClass('active');
		$(this).addClass('active');
		var path = '/'+this.innerHTML;
		$.each($(this).parents('ul').prev('.folder'),function(){
			path='/'+this.innerHTML + path;
		});
		$("#footer #location_zone").text(path);
		$("#form_upload #folder_id").val($(this).attr('folder_id'));
		$("#images_zone #page").val(0);
		$("#images_zone #display_zone #show").empty();
		media.loadImages();
		//alert(this.innerHTML);
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
				$("#images_zone #display_zone #show").prepend(media.fillDataIntoImageTemplate(data));
				var first = $("#images_zone #display_zone #show").children().first();
				first.contextMenu('myMenu1',media.binding_menu1);
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
	$("#information #infor2 input[type=text]").focus(function(){
		$(this).select();
	});
	$('#form_upload').ajaxForm(options); 
	media.loadImages();
	$.contextMenu.defaults({
		menuStyle : {
			width : "200px"
		},
		itemStyle : {
			cursor: "pointer"
		}
	});
});