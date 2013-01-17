function getCheckedValue(radioObj) {
	if(!radioObj)
		return "";
	var radioLength = radioObj.length;
	if(radioLength == undefined)
		if(radioObj.checked)
			return radioObj.value;
		else
			return "";
	for(var i = 0; i < radioLength; i++) {
		if(radioObj[i].checked) {
			return radioObj[i].value;
		}
	}
	return "";
}
// set the radio button with the given value as being checked
// do nothing if there are no radio buttons
// if the given value does not exist, all the radio buttons
// are reset to unchecked
function setCheckedValue(radioObj, newValue) {
	if(!radioObj)
		return;
	var radioLength = radioObj.length;
	if(radioLength == undefined) {
		radioObj.checked = (radioObj.value == newValue.toString());
		return;
	}
	for(var i = 0; i < radioLength; i++) {
		radioObj[i].checked = false;
		if(radioObj[i].value == newValue.toString()) {
			radioObj[i].checked = true;
		}
	}
}

function remove_accents( str ) {
	var r=str.toLowerCase();
	r = r.replace(new RegExp("[àáạảãâầấậẩẫăằắặẳẵ]", 'g'),"a");
	r = r.replace(new RegExp("[èéẹẻẽêềếệểễ]", 'g'),"e");
	r = r.replace(new RegExp("[ìíịỉĩîï]", 'g'),"i");
	r = r.replace(new RegExp("[öòóọỏõôồốộổỗơờớợởỡ]", 'g'),"o");
	r = r.replace(new RegExp("[ùúụủũưừứựửữûü]", 'g'),"u");
	r = r.replace(new RegExp("[ýÿỹỳỵ]", 'g'),"y");
	r = r.replace(new RegExp("[đ]", 'g'),"d");
	r = r.replace(new RegExp("[ÀÁẠẢÃÂẦẤẬẨẪĂẰẮẶẲẴ]", 'g'),"A");
	r = r.replace(new RegExp("[ÈÉẸẺẼÊỀẾỆỂỄ]", 'g'),"E");
	r = r.replace(new RegExp("[ÌÍỊỈĨÎÏ]", 'g'),"I");
	r = r.replace(new RegExp("[ÖÒÓỌỎÕÔỒỐỘỔỖƠỜỚỢỞỠ]", 'g'),"O");
	r = r.replace(new RegExp("[ÙÚỤỦŨƯỪỨỰỬỮÛÜ]", 'g'),"U");
	r = r.replace(new RegExp("[ÝŸỸỲỴ]", 'g'),"Y");
	r = r.replace(new RegExp("[Đ]", 'g'),"D");
	r = r.replace(new RegExp("æ", 'g'),"ae");
	r = r.replace(new RegExp("ç", 'g'),"c");
	r = r.replace(new RegExp("ñ", 'g'),"n");                            
	r = r.replace(new RegExp("œ", 'g'),"oe");
	return r;
}

function FormatMoney(str) {
	rs="";
	dem=0;
	for(i=str.length-1;i>=0;i--) {
		dem++;
		if(dem==3 && i>0)
		{
			rs="."+str.charAt(i)+rs;
			dem=0;
		}
		else
			rs=str.charAt(i)+rs;
	}
	return rs;
}
function getNumber(str) {
	rs = '';
	for(i=0;i<str.length;i++) {
		var c = str.charAt(i);
		if(c>='0' && c<='9')
			rs+=c;
	}
	return rs;
}
function MultiSelect(btadd,btremove,btaddall,btremoveall,select_left,select_right) {
	btadd = '#'+btadd;
	btremove = '#'+btremove;
	btaddall = '#'+btaddall;
	btremoveall = '#'+btremoveall;
	select_left = '#'+select_left;
	select_right = '#'+select_right;
	
	$(btadd).click(function() {			
		if($(select_left+' option:selected').length == 0) {
			alert('Bạn chưa chọn dòng ở cột bên trái!');
			return false;
		}	
		$(select_right+' option').each(function(){
			this.selected = false;
		});
		return !$(select_left+' option:selected').remove().appendTo(select_right);  
	});  
	$(btremove).click(function() {  
		if($(select_right+' option:selected').length == 0) {
			alert('Bạn chưa chọn dòng ở cột bên phải!');
			return false;
		}	
		return !$(select_right+' option:selected').remove().appendTo(select_left);  
	});  
	$(btaddall).click(function() {  
		return !$(select_left+' option').remove().appendTo(select_right);  
	});  
	$(btremoveall).click(function() {  
		return !$(select_right+' option').remove().appendTo(select_left);  
	}); 
	$(select_left).dblclick(function() {
		$(select_right+' option').each(function(){
			this.selected = false;
		});
		return !$(select_left+' option:selected').remove().appendTo(select_right);  
	});  
	$(select_right).dblclick(function() {			
		return !$(select_right+' option:selected').remove().appendTo(select_left);  
	}); 
}

/**********************************************
 * Customize window jquery 
 * create by: toannb
 **********************************************/

var windowObj;
var status = "closing";
function RefreshSite() {
    window.location.href = window.location;
}
function ShowWindow(_title, _width, _height, _url, _scrollable) {
    if (status == "closing") {
        windowObj = $.window({
            title: _title,
            url: _url,
            width: _width,
            height:_height,
            showModal: true,
            resizable: true,
            scrollable: true,
            minimizable: true,
            bookmarkable: false,
            scrollable:_scrollable,
            onClose: function () {
				if(status == 'has_change')
					setTimeout(function() {oTable.fnDraw(true);} , 500);
                status = "closing";
            }
        });
        status = "opening";
    }
}
function MaxWindow()
{
    windowObj.maximize();
}
function CloseWindow() {
    windowObj.close();
}
/*function table_checkbox(classobj) {
    $("table." + classobj + " input[type='checkbox']:first").change(function () {
        var checked = $(this).is(":checked");
        $("table." + classobj + " tr").each(function () {
            $(this).find("input[type='checkbox']:first").attr("checked", checked);
        });
    });
}
*/
function loadDatepicker(element)
{
    $(element).datepicker({
        showOn: 'both'
        , buttonImage: '/images/button/calendar-up.gif'
        , buttonImageOnly: true
        , dateFormat: 'dd/mm/yy'
        , clearText: ''
        , firstDay: 1
        , dayNames: ['Chủ nhật', 'Thứ hai', 'Thứ ba', 'Thứ tư', 'Thứ năm', 'Thứ sáu', 'Thứ bảy']
        , dayNamesMin: ['CN', 'Hai', 'Ba', 'Tư', 'Năm', 'Sáu', 'Bảy']
        , dayNamesShort: ['CN', 'Hai', 'Ba', 'Tư', 'Năm', 'Sáu', 'Bảy']
        , monthNames: ['Tháng 1','Tháng 2','Tháng 3','Tháng 4','Tháng 5','Tháng 6','Tháng 7','Tháng 8','Tháng 9','Tháng 10','Tháng 11','Tháng 12']
        , monthNamesShort: ['Tháng 1','Tháng 2','Tháng 3','Tháng 4','Tháng 5','Tháng 6','Tháng 7','Tháng 8','Tháng 9','Tháng 10','Tháng 11','Tháng 12']
        , changeMonth: true
        , changeYear: true
        , yearRange: '1950:2100'
    });
}
function loadTimepicker(element) {
    $(element).timeEntry({show24Hours: true, showSeconds: true});
}
//Replace multi values in reps array
function replaceText(str,reps) {
	/*var reps = {
		link_view_users_same_rate: "1",  //VN will be replace by "Ali" in str string
		num_same_rate: "2",
		rate_action: "3"
	};*/
	return str.replace(/\[\[(.*?)\]\]/g, function(s, key) {
		return reps[key] || '';
	});
	
}
function parseSize(size) {
	var suffix = ["bytes", "KB", "MB", "GB", "TB", "PB"],
		tier = 0;

	while(size >= 1024) {
		size = size / 1024;
		tier++;
	}

	return Math.round(size * 10) / 10 + " " + suffix[tier];
}
