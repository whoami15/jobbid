var i = 0;
while(i < 3) {
	$.ajax({  
		type: 'POST',
		cache: false,
		async: false,
		data: {
			'EVENTTARGET' : '',
			'__EVENTARGUMENT' : '',
			'__VIEWSTATE' : '%2FwEPDwULLTEyMjEzODAyMDcPZBYCZg9kFgQCBQ9kFgoCBw8WAh4LXyFJdGVtQ291bnQCBRYKZg9kFgJmDxUEATEENTI2MQExDFRo4budaSB0cmFuZ2QCAQ9kFgJmDxUEATIENTI2MgEyC03hu7kgcGjhuqltZAICD2QWAmYPFQQBMwQ1MzM1ATMMR2nDoHkgLyBUw7ppZAIDD2QWAmYPFQQBNAQ1MzM2ATQMUGjhu6UgS2nhu4duZAIED2QWAmYPFQQBNQQ1Mzg0ATUGxJBURMSQZAIJDw9kFgIeCm9ua2V5cHJlc3MFOmlmIChldmVudC5rZXlDb2RlID09IDEzKSB7IGZuU2VhcmNoS2V5V2QoKTsgcmV0dXJuIGZhbHNlO31kAgsPFgIeBFRleHQF0wE8YSBocmVmPScvRGlzcGxheS9TZWFyY2hSZXN1bHQuYXNweD9LZXl3b3JkMT1MZXR6eic%2BTGV0eno8L2E%2BPGEgaHJlZj0nL0Rpc3BsYXkvU2VhcmNoUmVzdWx0LmFzcHg%2FS2V5d29yZDE9VmljdG9yaWFzK3NlY3JldCc%2BVmljdG9yaWFzIHNlY3JldDwvYT48YSBocmVmPScvRGlzcGxheS9TZWFyY2hSZXN1bHQuYXNweD9LZXl3b3JkMT1Ub255bW9seSc%2BVG9ueW1vbHk8L2E%2BZAIMD2QWAmYPZBYCZg9kFgRmD2QWCAIBDxBkZBYAZAIFDxBkZBYAZAIJDxBkZBYAZAINDxBkZBYAZAIBDw8WAh4HVmlzaWJsZWdkZAIND2QWFAIFDw8WAh8CBQEwZGQCBg8PFgIfAgUBMGRkAgcPDxYCHwIFATBkZAIIDw8WAh8CBQEwZGQCCQ8PFgIfAgUBMGRkAg8PDxYCHwIFATBkZAIQDw8WAh8CBQEwZGQCEQ8PFgIfAgUBMGRkAhIPDxYCHwIFATBkZAITDw8WAh8CBQEwZGQCBw8WAh8AAgMWBmYPZBYCAgEPFgIfAgWNAjxkaXY%2BPGEgaHJlZj0naHR0cDovL3d3dy55ZXMyNC52bi9FdmVudC8yMDEzLzMwLTA0LU1haW4uYXNweCc%2BPGltZyBzcmM9Jy9VcGxvYWQvQmFubmVySW1hZ2Uvc2t5TF8wMV8yMDEzMDMzMF90YTEuanBnJyBib3JkZXI9JzAnIC8%2BPC9hPjwvZGl2PjxkaXY%2BPGEgaHJlZj0naHR0cDovL3d3dy5mYWNlYm9vay5jb20veWVzMjR2aW5hJyB0YXJnZXQ9J19ibGFuayc%2BPGltZyBzcmM9Jy9VcGxvYWQvQmFubmVySW1hZ2Uvc2t5X2xlZnRfZmFjZWJvb2suZ2lmJz48L2E%2BPC9kaXY%2BZAIBD2QWAgIBDxYCHwIF1wE8ZGl2PjxhIGhyZWY9J2h0dHA6Ly93d3cueWVzMjQudm4va2h1eWVuLW1haS81MzAxNjAvc3VjLWtob2UtbGEtdmFuZy5odG1sJz48aW1nIHNyYz0nL1VwbG9hZC9CYW5uZXJJbWFnZS9za3lMXzAyXzIwMTMwNDI1X3R2LmpwZycgYm9yZGVyPScwJyAvPjwvYT48L2Rpdj48ZGl2PjxpbWcgc3JjPScvVXBsb2FkL0Jhbm5lckltYWdlL3NreUxfZGFzaGVkbGluZS5qcGcnPjwvZGl2PmQCAg9kFgICAQ8WAh8CBZsBPGRpdj48YSBocmVmPSdodHRwOi8vd3d3LnllczI0LnZuL2todXllbi1tYWkvNTE5ODQwL3RoZS1naW9pLXRoYXQtbHVuZy5odG1sJz48aW1nIHNyYz0nL1VwbG9hZC9CYW5uZXJJbWFnZS9za3lMXzAzXzIwMTMwNDE3X3RrLmpwZycgYm9yZGVyPScwJyAvPjwvYT48L2Rpdj5kGAEFHl9fQ29udHJvbHNSZXF1aXJlUG9zdEJhY2tLZXlfXxYKBSVjdGwwMCRDb250ZW50UGxhY2VIb2xkZXIyJGltYWdlRmllbGQxBSVjdGwwMCRDb250ZW50UGxhY2VIb2xkZXIyJGltYWdlRmllbGQyBSVjdGwwMCRDb250ZW50UGxhY2VIb2xkZXIyJGltYWdlRmllbGQzBSVjdGwwMCRDb250ZW50UGxhY2VIb2xkZXIyJGltYWdlRmllbGQ0BSVjdGwwMCRDb250ZW50UGxhY2VIb2xkZXIyJGltYWdlRmllbGQ1BSVjdGwwMCRDb250ZW50UGxhY2VIb2xkZXIyJGltYWdlRmllbGQ2BSVjdGwwMCRDb250ZW50UGxhY2VIb2xkZXIyJGltYWdlRmllbGQ3BSVjdGwwMCRDb250ZW50UGxhY2VIb2xkZXIyJGltYWdlRmllbGQ4BSVjdGwwMCRDb250ZW50UGxhY2VIb2xkZXIyJGltYWdlRmllbGQ5BSZjdGwwMCRDb250ZW50UGxhY2VIb2xkZXIyJGltYWdlRmllbGQxMA%3D%3D',
			'searchType' : '0',
			'ctl00%24hdfSearchType' : '',
			'ctl00%24txtSearch' : '',
			'ctl00%24ContentPlaceHolder2%24imageField1.x' : '58',
			'ctl00%24ContentPlaceHolder2%24imageField1.y' : '54'
		},
		url: 'http://www.yes24.vn/Event/2013/nhan-qua-ung-y.aspx',
		dataType: 'json',
		success: function(data){
			console.log(data);
		},
		error: function(){
			console.log('ERROR');
		}
	}); 
	i++;
}

var viewstate = $("#__VIEWSTATE").val();
var i = 0;
while(i<3) {
setTimeout("hack()",1000);
i++;
}
$.ajax({  
	type: 'GET',
	cache: false,
	url: 'http://local02.lazadavn.com/omslocal/games/save-games?callback=jQuery17022174464504658642_1369301577392&answer_1=MOI&answer_2=U&answer_3=COPAC&answer_4=S&answer_5=SACOMBANK&answer_6=MAYMAN&answer_7=QUOCTETHIEUNHI&answer_8=R&answer_9=NICKVUJICIC&answer_10=ANACONDA&answer_11=T&answer_12=U&answer_13=DAILYDEAL&answer_14=LED&answer_15=N',
	success: function(data){
		console.log(data);
	},
	error: function(){
		console.log('ERROR');
	}
}); 

$.ajax({  
	type: 'GET',
	cache: false,
	url: 'http://local02.lazadavn.com/omslocal/games/save-info?callback=jQuery17022174464504658642_1369301577393&ochu_fullname=Nguyen+Long&ochu_email=nclong87%40gmail.com&ochu_phone=0932337487&ochu_address=70+Van+Cao+Phu+Tho+Hoa+Tan+Phu&ochu_key=9f3e477726447149c04a276cb3045744&ochu_user=533',
	success: function(data){
		console.log(data);
	},
	error: function(){
		console.log('ERROR');
	}
}); 


var viewstate = $("#__VIEWSTATE").val();
var i = 0;
function hack() {
if(i>=30) return;
$.ajax({  
	type: 'POST',
	cache: false,
	data: {
		'EVENTTARGET' : '',
		'__EVENTARGUMENT' : '',
		'__VIEWSTATE' : viewstate,
		'ctl00$ContentPlaceHolder2$imageField1.x' : 47,
		'ctl00$ContentPlaceHolder2$imageField1.y' : 47,
		'ctl00$hdfSearchType' : '',
		'ctl00$txtSearch' : '',
		'searchType' : 0
	},
	url: 'http://www.yes24.vn/Event/2013/nhan-qua-ung-y.aspx',
	success: function(data){
		//console.log('OK');
	},
	error: function(){
		console.log('ERROR');
	}
}); 
setTimeout("hack()",200);
i++;
}
hack();

//http://www.jobbid.vn/index/promotion?t2=2013-05-09 02:31:30

http://www.yes24.vn/Display/MobileProductDetail.aspx?ProductNo=965746
http://www.yes24.vn/Display/MobileProductDetail.aspx?ProductNo=973770
http://www.yes24.vn/Display/MobileProductDetail.aspx?ProductNo=1004786
$.ajax({  
	type: 'POST',
	cache: false,
	data: {
		'Contentdata' : '<table border="0" cellpadding="0" cellspacing="0">        <tbody><tr>        <td>            <ul style="width:628px;">            <li class="draggable1"><img style="cursor: move; position: relative;" src="http://www.yes24.vn/Upload/ProductImage/YES24DTDD/965746_M.jpg" class="drag-image ui-draggable" id="draggable1"></li>            <li class="draggable2"><img style="cursor: move; position: relative;" src="http://www.yes24.vn/Upload/ProductImage/Vienne/1004786_M.jpg" class="drag-image ui-draggable" id="draggable2"></li>            <li class="draggable3"><img style="cursor: move; position: relative;" src="http://www.yes24.vn/Upload/ProductImage/neomax/973770_M.jpg" class="drag-image ui-draggable" id="draggable3"></li>        </ul>        </td>                </tr>        </tbody></table>'
	},
	url: 'http://www.yes24.vn/Event/2013/san-hang-gio-vang-data.aspx?act=submit&hdPro1=851780&hdPro2=965746&hdPro3=944874',
	success: function(data){
		console.log('OK');
	},
	error: function(){
		console.log('ERROR');
	}
}); 
