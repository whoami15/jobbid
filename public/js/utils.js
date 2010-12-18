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
function remove_space(str) {
	sResult = "";
	i=0;
	flag = false;
	array = new Array(" ",",",":","'","\"","`");
	while(i<str.length) {
		c = str.charAt(i);
		if(array.indexOf(c)>=0) {
			if(flag == false)
				sResult = sResult+"-";
			flag = true;
		} else {
			sResult = sResult+c;
			flag = false;
		}
		i++;
	}
	return sResult;
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