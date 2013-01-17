var response;
$.validator.addMethod(
	"regex",
	function(value, element, regexp) {
		var re = new RegExp(regexp);
		return this.optional(element) || re.test(value);
	},
	"Please check your input."
);
$.validator.addMethod("uniqueUserName", function(value, element) {
	$.ajax({
		type: "GET",
		url: baseUrl + '/front/tai-khoan/check-username/username/'+value,
		async: false, 
		success: function(msg)
		{
			//If username exists, set response to true
			if(msg == 'ERROR') {
				alert(ERROR_MESSAGE);
				response = true;
			} else {
				response = ( msg == 'NOT_EXIST' ) ? true : false;
			}
		}
	})
	return response;
}, "Username is Already Taken");
$.validator.addMethod("uniqueEmail", function(value, element) {
	$.ajax({
		type: "GET",
		url: baseUrl + '/front/tai-khoan/check-email/email/'+value,
		async: false, 
		success: function(msg)
		{
			if(msg == 'ERROR') {
				alert(ERROR_MESSAGE);
				response = true;
			} else {
				response = ( msg == 'NOT_EXIST' ) ? true : false;
			}
		}
	})
	return response;
}, "Email is Already Taken");
$.validator.addMethod("uniqueMagianhang", function(value, element) {
	$.ajax({
		type: "GET",
		url: baseUrl + '/front/tai-khoan/check-magianhang/ma/'+value,
		async: false, 
		success: function(msg)
		{
			if(msg == 'ERROR') {
				alert(ERROR_MESSAGE);
				response = true;
			} else {
				response = ( msg == 'NOT_EXIST' ) ? true : false;
			}
		}
	})
	return response;
}, "Magianhang is Already Taken");
$.validator.addMethod("CheckCaptcha", function(value, element) {
	$.ajax({
		type: "GET",
		url: baseUrl + '/front/ajax/check-captcha/word/'+value+'/t/'+element.id,
		async: false, 
		success: function(msg)
		{
			if(msg == 'ERROR') {
				alert(ERROR_MESSAGE);
				response = true;
			} else {
				response = ( msg == 'OK' ) ? true : false;
			}
		}
	})
	return response;
}, "Captcha is Already Taken");