/////////////////////////////////
// File Name: mMBanner.js       //
// Version: 2.1                  //
// By: Manish Kumar Namdeo     //
// http://www.mysticalm.com    //
/////////////////////////////////

// BANNER OBJECT
function MBanner(objName){
	this.obj = objName;
	this.aNodes = [];
	this.currentBanner = 0;
	this.changeOnRefresh = false;
	
};

// ADD NEW BANNER
MBanner.prototype.add = function(bannerType, bannerPath, bannerDuration, height, width, hyperlink, target) {
	this.aNodes[this.aNodes.length] = new MNode(this.obj +"_"+ this.aNodes.length, bannerType, bannerPath, bannerDuration, height, width, hyperlink, target);
};

// MNode object
function MNode(name, bannerType, bannerPath, bannerDuration, height, width, hyperlink, target) {
	this.name = name;
	this.bannerType = bannerType;
	this.bannerPath = bannerPath;
	this.bannerDuration = bannerDuration;
	this.height = height
	this.width = width;
	this.hyperlink= hyperlink;
	this.target= target;
};

// Outputs the banner to the page
MBanner.prototype.toString = function() {
	var str = "";
	var iBannerIndex = 0;
	if(this.changeOnRefresh == true){
		// Read the cookie
		var BannerName = this.obj;
		var lastBannerIndex = readMCookie(BannerName);

		if(isNaN(lastBannerIndex) == true || lastBannerIndex == null){
			iBannerIndex = 0;
		}else if(lastBannerIndex == '' || parseInt(lastBannerIndex) >= this.aNodes.length - 1){
			iBannerIndex = 0;
		}else{
			iBannerIndex = parseInt(lastBannerIndex) + 1;
		}
	
		// Set the new value
		createMCookie(BannerName,iBannerIndex,7);
	}

	for (var iCtr=0; iCtr < this.aNodes.length; iCtr++){
		if(this.changeOnRefresh == true && iBannerIndex != iCtr){
			continue;
		}
		str = str + '<span name="'+this.aNodes[iCtr].name+'" '
		str = str + 'id="'+this.aNodes[iCtr].name+'" ';
		if(this.changeOnRefresh == true && iBannerIndex == iCtr){
			str = str + 'class="jbanner_show" ';
		}else{
			str = str + 'class="jbanner_hide" ';
		}
		str = str + 'bgcolor="#FFFCDA" ';	// CHANGE BANNER COLOR HERE
		str = str + 'align="center" ';
		str = str + 'valign="top" >\n';
			
		if ( this.aNodes[iCtr].bannerType == "FLASH" ){
			str = str + '<OBJECT ';
			str = str + 'classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" ';
			str = str + 'codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" ';
			str = str + 'WIDTH="'+this.aNodes[iCtr].width+'" ';
			str = str + 'HEIGHT="'+this.aNodes[iCtr].height+'" ';
			str = str + 'id="bnr_'+this.aNodes[iCtr].name+'" ';
			str = str + 'ALIGN="" ';
			str = str + 'VIEWASTEXT>';
			str = str + '<PARAM NAME=movie VALUE="'+ this.aNodes[iCtr].bannerPath + '">';
			str = str + '<PARAM NAME=quality VALUE=high>';
			str = str + '<PARAM NAME=bgcolor VALUE=#FFFCDA>';
			if (this.aNodes[iCtr].hyperlink != ""){
				str = str + '<PARAM NAME=flashvars VALUE="clickTag='+this.aNodes[iCtr].hyperlink;
				if(this.aNodes[iCtr].target != ""){
					str = str + '&clickTarget='+this.aNodes[iCtr].target;
				}
				str = str + '" />';
			}
			str = str + '<EMBED ';
			str = str + 'src="'+this.aNodes[iCtr].bannerPath+'" ';
			str = str + 'quality=high ';
//			str = str + 'bgcolor=#FFFCDA ';
			str = str + 'WIDTH="'+this.aNodes[iCtr].width+'" ';
			str = str + 'HEIGHT="'+this.aNodes[iCtr].height+'" ';
			str = str + 'NAME="bnr_'+this.aNodes[iCtr].name+'" ';
			str = str + 'ALIGN="center" ';
			str = str + 'TYPE="application/x-shockwave-flash" ';
			str = str + 'PLUGINSPAGE="http://www.macromedia.com/go/getflashplayer" ';
			if (this.aNodes[iCtr].hyperlink != ""){
				str = str + 'FLASHVARS="clickTag='+this.aNodes[iCtr].hyperlink;
				if(this.aNodes[iCtr].target != ""){
					str = str + '&clickTarget='+this.aNodes[iCtr].target;
				}
				str = str + '" ';
			}
			
			str = str + '>';
			str = str + '</EMBED>'
			str = str + '</OBJECT>'
		}else if ( this.aNodes[iCtr].bannerType == "IMAGE" ){
			if (this.aNodes[iCtr].hyperlink != ""){
				str = str + '<a href="'+this.aNodes[iCtr].hyperlink+'" '
				if(this.aNodes[iCtr].target != ""){
					str = str + ' target="' + this.aNodes[iCtr].target + '" ';
				}
				str = str + '>';
			}
			str = str + '<img src="'+this.aNodes[iCtr].bannerPath+'" ';
			str = str + 'border="0" ';
			str = str + 'height="'+this.aNodes[iCtr].height+'" ';
			str = str + 'width="'+this.aNodes[iCtr].width+'">';
			if (this.aNodes[iCtr].hyperlink != ""){
				str = str + '</a>';
			}
		}


		str += '</span>';


	}
	return str;
};

// START THE BANNER ROTATION
MBanner.prototype.start = function(){
	if(this.changeOnRefresh == false){
		this.changeBanner();
		var thisBannerObj = this.obj;
		// CURRENT BANNER IS ALREADY INCREMENTED IN cahngeBanner() FUNCTION
		setTimeout(thisBannerObj+".start()", this.aNodes[this.currentBanner].bannerDuration * 1000);
	}
}

// CHANGE BANNER
MBanner.prototype.changeBanner = function(){
	var thisBanner;
	var prevBanner = -1;
	if (this.currentBanner < this.aNodes.length ){
		thisBanner = this.currentBanner;
		if (this.aNodes.length > 1){
			if ( thisBanner > 0 ){
				prevBanner = thisBanner - 1;
			}else{
				prevBanner = this.aNodes.length-1;
			}
		}
		if (this.currentBanner < this.aNodes.length - 1){
			this.currentBanner = this.currentBanner + 1;
		}else{
			this.currentBanner = 0;
		}
	}
	

	if (prevBanner >= 0){
		document.getElementById(this.aNodes[prevBanner].name).className = "jbanner_hide";
	}
	document.getElementById(this.aNodes[thisBanner].name).className = "jbanner_show";
}

// Following Cookie Code taken from http://www.quirksmode.org
function createMCookie(name,value,days) {
	if (days) {
		var date = new Date();
		date.setTime(date.getTime()+(days*24*60*60*1000));
		var expires = "; expires="+date.toGMTString();
	}
	else var expires = "";
	document.cookie = name+"="+value+expires+"; path=/";
}

function readMCookie(name) {
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for(var i=0;i < ca.length;i++) {
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
	}
	return null;
}
