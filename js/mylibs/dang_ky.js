var last_check = '';
function checkUsername() {
	var username = $("#username").val();
	if(username == last_check) return;
	
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
}
$(document).ready(function(){	
	$("#form").validate({
		onkeyup: false,
		onfocusout:false,
		rules: {
			username: {
				required: true,
				minlength: 3,
				regex : /^[A-Za-z0-9_]{3,20}$/,
				uniqueUserName : true
			},
			password: {
				required: true,
				minlength: 6
			},
			confirm_password: {
				equalTo: "#password"
			},
			email: {
				required: true,
				email :true,
				uniqueEmail :true
			},
			ho_ten: {
				required: true
			},
			ten_gian_hang: {
				required: true
			},
			dien_thoai: {
				required: true
			},
			dia_chi: {
				required: true
			},
			tinhthanh_id: {
				required: true
			},
			ma_gian_hang: {
				required: true,
				minlength: 3,
				regex : /^[A-Za-z0-9_]{3,20}$/,
				uniqueMagianhang : true
			},
			register: {
				required: true,
				minlength: 4,
				CheckCaptcha : true
			}
		},
		messages: {
			username: {
				required: "Tên đăng nhập ít nhất có 3 ký tự và chỉ bao gồm các ký tự từ A-z, 0-9 và các ký tự -",
				minlength: "Tên đăng nhập ít nhất có 3 ký tự và chỉ bao gồm các ký tự từ A-z, 0-9 và các ký tự -",
				regex : "Tên đăng nhập ít nhất có 3 ký tự và chỉ bao gồm các ký tự từ A-z, 0-9 và các ký tự -",
				uniqueUserName : "Username này đã được sử dụng, vui lòng chọn username khác!"
			},	
			ho_ten: "Vui lòng nhập họ tên",
			/*password: {
				required : "Mật khẩu ít nhất có 6 ký tự",
				minlength : jQuery.format("Mật khẩu phải lớn hơn {0} ký tự")
			},*/
			password: "Mật khẩu nên có ít nhất 6 ký tự, bao gồm cả ký tự chữ + số + ký tự đặc biệt (@,!,*,^, v.v...)",
			confirm_password: {
				equalTo: "Vui lòng nhập lại chính xác mật khẩu ở trên"
			},
			email: {
				required: "Vui lòng nhập email",
				email : "Email không hợp lệ",
				uniqueEmail : "Email này đã được sử dụng, vui lòng chọn email khác!"
			},
			ten_gian_hang: {
				required: "Vui lòng nhập tên gian hàng"
			},
			dien_thoai: {
				required: "Vui lòng nhập số điện thoại"
			},
			dia_chi: {
				required: "Vui lòng nhập địa chỉ liên hệ"
			},
			tinhthanh_id: {
				required: "Vui lòng chọn tỉnh thành"
			},
			ma_gian_hang: {
				required: "Đường dẫn có ít nhất có 3 ký tự và chỉ bao gồm các ký tự từ A-z, 0-9 và các ký tự -",
				minlength: "Đường dẫn có ít nhất có 3 ký tự và chỉ bao gồm các ký tự từ A-z, 0-9 và các ký tự -",
				regex: "Đường dẫn có ít nhất có 3 ký tự và chỉ bao gồm các ký tự từ A-z, 0-9 và các ký tự -",
				uniqueMagianhang : "Đường dẫn này đã được sử dụng, vui lòng chọn đường dẫn khác!"
			},
			register: {
				required: "Vui lòng nhập mã xác nhận",
				minlength: "Mã xác nhận có 4 ký tự",
				CheckCaptcha : "Mã xác nhận chưa đúng"
			}
		}
	});
	$("#btReset").click(function(){
		$("#form")[0].reset();
		return false;
	});
	$("#aggree").click(function(){
		if(this.checked == true) {
			$("#btSubmit").removeClass("disable");
		} else {
			$("#btSubmit").addClass("disable");
		}
	});
	$("#captcha_container #btChangeCaptcha").click(function(){
		$.get(baseUrl+'/front/ajax/refesh-captcha/t/register',function(data){
			$("#captcha_container img").attr("src",data);
		});
	});
	$(document).delegate("#btSubmit.disable","click",function(){
		return false;
	});
	$(document).delegate("#btSubmit:not(.disable)","click",function(){
		this.disabled = true;
		if(!$("#form").valid()) {
			alert("Dữ liệu nhập chưa hợp lệ, vui lòng kiểm tra lại!");
			this.disabled = false;
		} else {
			byId("form").submit();
		}
		return false;
	});
});