<?php
class zendcms_Controller_Helper_Const
{
	public static $upload_ext = array('jpg','png','gif','bmp','doc','docx','xls','xlsx','pdf','zip','rar','gzip'); 
	public static $upload_image_ext = array('jpeg','jpg','png','gif','bmp'); 
	public static $db_images = array(
		'id',
		'filename',
		'folder_id',
		'path_thumb',
		'path',
		'size',
		'create_time',
		'create_user',
		'deleted',
		'width',
		'height',
		'position'
	);
	public static $langs = array('vi','en');
	public static $messages = array(
		'ERROR' => 'Có lỗi xảy ra, vui lòng thử lại sau',
		'VERIFY_SUCCESS' => 'Bạn đã xác nhận đăng ký tài khoản thành công!',
		'END_SESSION' => 'Vui lòng đăng nhập lại',
		'VERIFY_INVALID' => 'Mã xác nhận không hợp lệ!',
		'LINK_ERROR' => 'Liên kết không hợp lệ!',
		'INVALID_GIANHANG' => 'Gian hàng không tồn tại!',
		'EMAIL_NOT_EXIST' => 'Email %s không tồn tại trong hệ thống',
		'REQUEST_RESET_PASS_SUCCESS' => 'Bạn đã gửi yêu cầu cấp lại mật khẩu thành công, vui lòng kiểm tra email %s để lấy link cập nhật mật khẩu',
		'LOGIN_FAIL' => 'Đăng nhập không thành công!'
	);
	public static $success_messages = array(
		'CHANGE_PASSWORD' => 'Thay đổi mật khẩu thành công!',
		'UPDATE' => 'Cập nhật thành công!'
	);
	public static $error_messages = array(
		'CHANGE_PASSWORD' => 'Thay đổi mật khẩu không thành công!',
		'VALIDATE_FORM' => 'Form nhập chưa hợp lệ',
		'LIMIT_SLIDE' => 'Bạn không thể thêm quá %s hình ảnh!'
	);
	public static $modules = array(
		array(
			'ma_module' => 1,
			'gianhang_id' => null,
		 	'ten_module' => 'Sản phẩm mới',
			'vitri' => 2,
			'state' => 1
		),
		array(
			'ma_module' => 2,
			'gianhang_id' => null,
		 	'ten_module' => 'Sản phẩm khuyến mãi',
			'vitri' => 2,
			'state' => 1
		),
		array(
			'ma_module' => 3,
			'gianhang_id' => null,
		 	'ten_module' => 'Sản phẩm hot',
			'vitri' => 1,
			'state' => 1
		),
		array(
			'ma_module' => 4,
			'gianhang_id' => null,
		 	'ten_module' => 'Sản phẩm được quan tâm',
			'vitri' => 3,
			'state' => 1
		)
	);
	public static $captcha_type = array(
		'register','reset_pass'
	);
}
?>