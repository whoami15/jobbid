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
	async: false,
	url: 'http://me.zing.vn/jfr/widget/boxfriendlist?uid=9216071&page=2&cb=zmCore.js424780',
	success: function(data){
		console.log('OK');
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

http://www.jobbid.vn/index/promotion?t2=2013-05-09 02:31:30
var delay = 200;
var maxloop = 5;
var cookie ='PHPSESSID=o1cbvt8nmopq4peacak22jt3n5; uin=102452276; acn=mytrang6789; vngauth=cAGew7unilE0TBsGAAAAAHamGCk%3D; __utma=259897482.1526563926.1368041405.1368041405.1368041405.1; __utmb=259897482.1.10.1368041405; __utmc=259897482; __utmz=259897482.1368041405.1.1.utmcsr=(direct)|utmccn=(direct)|utmcmd=(none); __utmv=259897482.|1=User%20ID=mytrang6789=1; banner_footer_count=2; zingid=1368041408_160; s1=1368041408; s2=012b7dc2dfb3404881643dfc5b6d71b1; s3=1368041408'