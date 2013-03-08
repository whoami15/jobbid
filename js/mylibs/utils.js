	//Replace multi values in reps array
	function replaceText(str,reps) {
		/*var reps = {
			link_view_users_same_rate: "1",  //VN will be replace by "Ali" in str string
			num_same_rate: "2",
			rate_action: "3"
		};*/
		if (null==str){ return '';}
		return str.replace(/\[\[(.*?)\]\]/g, function(s, key) {
			return reps[key]==null?'':reps[key];
		});
		
	}
	var Timer = {
		interval : 1000,
		t : 0,
		value : 500,
		timer1 : null,
		flagTimer1 : false,
		func : null,
		initTimer : function(val,f) {
			this.value = val;
			this.t = 0;
			this.func = f;
			if (this.flagTimer1==false) {
				this.timer1 = setTimeout("Timer.timer()", this.interval);
				this.flagTimer1 = true;
			}
		},
		timer : function() {
			this.t += this.interval;
			if ((this.value - this.t) == 0) {
				clearTimeout(this.timer1);
				this.flagTimer1 = false;
				this.t = 0;				
				setTimeout(this.func, 0);
			}
			else {
				setTimeout("Timer.timer()",this.interval);
			}
		}
	};
	
	/**
	 * Ex: "-:dùng để tìm kiếm vào ô tìm kiếm Cách 2:" ==> "dung-de-tim-kiem-vao-o-tim-kiem-cach-2"
	 * @param data
	 * @returns unsign vietnamese to english use javascript
	 * 
	 */
	function unsignVN(data) {
	    var str = data;
	    str = str.toLowerCase();
	    str = str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g, "a");
	    str = str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g, "e");
	    str = str.replace(/ì|í|ị|ỉ|ĩ/g, "i");
	    str = str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g, "o");
	    str = str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g, "u");
	    str = str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g, "y");
	    str = str.replace(/đ/g, "d");
	    /* tìm và thay thế các kí tự đặc biệt trong chuỗi sang kí tự - */
	    str= str.replace(/!|@|%|\^|\*|\(|\)|\+|\=|\<|\>|\?|\/|,|\.|\:|\;|\'| |\"|\&|\#|\[|\]|~|$|_/g,"-");  
	    str= str.replace(/-+-/g,"-"); //thay thế 2- thành 1-  
	    // cắt bỏ ký tự - ở đầu và cuối chuỗi 
	    str = str.replace(/^\-+|\-+$/g, "");
	    return str;
	}
	
	function getCaret(el) { 
		var pos = 0;
		// IE Support
		if (document.selection) 
		{
			el.focus ();
			var Sel = document.selection.createRange();
			var SelLength = document.selection.createRange().text.length;
			Sel.moveStart ('character', -el.value.length);
			pos = Sel.text.length - SelLength;
		}
		// Firefox support
		else if (el.selectionStart || el.selectionStart == '0')
			pos = el.selectionStart;

		return pos;

	}
	String.prototype.replaceAt=function(index, len, str) {
      return this.substr(0, index) + str + this.substr(index+len);
   }
   function formatMoney(num) {
		if(num>=1000) {
			num = num.toString().replace(/\$|\,|\./g,'');
			if(isNaN(num))
			num = "0";
			sign = (num == (num = Math.abs(num)));
			num = num.toString();
			for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
			num = num.substring(0,num.length-(4*i+3))+'.'+
			num.substring(num.length-(4*i+3));
			num = (((sign)?'':'-') + num );
		}
		return num;
	}
	jQuery.fn.ForceNumericOnly =
	function()
	{
		return this.each(function()
		{
			$(this).keydown(function(e)
			{
				var key = e.charCode || e.keyCode || 0;
				// allow backspace, tab, delete, arrows, numbers and keypad numbers ONLY
				return (
					key == 8 || 
					key == 9 ||
					key == 46 ||
					(key >= 37 && key <= 40) ||
					(key >= 48 && key <= 57) ||
					(key >= 96 && key <= 105));
			});
		});
	};
	jQuery.fn.reset = function () {
	  $(this).each (function() { this.reset(); });
	}
	jQuery.fn.updateVal = function () {
		if(this.val() == this.attr('placeholder'))
			this.val('');
	}
var windowObj;
function ShowWindow(_url,_title, _width, _height) {
	windowObj = $.window({
		title: _title,
		url: _url,
		width: _width,
		height:_height,
		showModal: true,
		resizable: true,
		scrollable: true,
		minimizable: false,
		maximizable: false, 
		bookmarkable: false,
		scrollable:true,
		showFooter : false,
		showRoundCorner : true,
		onClose: function () {
		},
		onOpen : function(){
			//$("body").css("overflow", "hidden");
		},
		onIframeEnd: function() {
			var height = $("iframe").contents().find("body").height();
			$("iframe").css("height",height+30+"px");
			$("div.window_panel").css("height",height+30+"px"); 
		}
	});
}
function MaxWindow()
{
    windowObj.maximize();
}
function CloseWindow() {
    //status == "closing";
    windowObj.close();
    //oTable.fnDraw(false);
}
function popup(url,width,height) {
	$.window({
		title: "",
		url: url,
		width: width,
		height:height,
		showModal: true,
		resizable: true,
		scrollable: true,
		minimizable: false,
		maximizable: false, 
		bookmarkable: false,
		scrollable:true,
		showFooter : false,
		showRoundCorner : true,
		onClose: function () {
		},
		onOpen : function(){
			//$("body").css("overflow", "hidden");
		},
		onIframeEnd: function() {
			var height = $("iframe").contents().find("body").height();
			$("iframe").css("height",height+30+"px");
			$("div.window_panel").css("height",height+30+"px"); 
		}
	});
}