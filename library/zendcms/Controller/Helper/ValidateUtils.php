<?php
class zendcms_Controller_Helper_ValidateUtils
{
	public static function validateRegisterForm($data) {
		if(!isset($data['username']) || strlen($data['username']) < 3) return false;
		if(preg_match('/^[a-zA-Z0-9]+([a-zA-Z0-9](_|-| )[a-zA-Z0-9])*[a-zA-Z0-9]+$/', $data['username'])==false) {
			return false;
		}
		$db = new Application_Model_DbTable_TaiKhoan();
		if($db->checkExistUsername($data['username']) == true) return false;
		if(!isset($data['password']) || strlen($data['password']) < 6) return false;
		$emailValidate = new Zend_Validate_EmailAddress();
		if(!isset($data['email']) || !$emailValidate->isValid($data['email'])) return false;
		if($db->checkExistEmail($data['email']) == true) return false;
		if(!isset($data['ho_ten']) || empty($data['ho_ten'])) return false;
		if(!isset($data['ten_gian_hang']) || empty($data['ten_gian_hang'])) return false;
		if(!isset($data['dia_chi']) || empty($data['dia_chi'])) return false;
		if(!isset($data['dien_thoai']) || empty($data['dien_thoai'])) return false;
		if(!isset($data['tinhthanh_id']) || empty($data['tinhthanh_id'])) return false;
		if(!isset($data['ma_gian_hang']) || strlen($data['ma_gian_hang']) < 3) return false;
		$db = new Application_Model_DbTable_GianHang();
		if($db->checkExistMaGianHang($data['ma_gian_hang']) == true) return false;
		return true;
	}
	public static function validateResetPassForm($data) {
		$emailValidate = new Zend_Validate_EmailAddress();
		if(!isset($data['email']) || !$emailValidate->isValid($data['email'])) return false;
		return true;
	}
	public static function validateLoginForm($data) {
		if(!isset($data['username']) || strlen($data['username']) < 3) return false;
		if(preg_match('/^[a-zA-Z0-9]+([a-zA-Z0-9](_|-| )[a-zA-Z0-9])*[a-zA-Z0-9]+$/', $data['username'])==false) {
			return false;
		}
		if(!isset($data['password']) || strlen($data['password']) < 6) return false;
		return true;
	}
	public static function validateThemSanPhamForm(&$data) {
		if(!isset($data['ten_san_pham']) || empty($data['ten_san_pham'])) return false;
		if(!isset($data['danhmuccon_id']) || empty($data['danhmuccon_id'])) return false;
		if(!isset($data['chkModuleSanPham']) || empty($data['chkModuleSanPham'])) return false;
		if(!isset($data['tinh_trang']) || intval($data['tinh_trang'])==0) return false;
		if(!isset($data['loai_gia']) || intval($data['loai_gia'])==0) return false;
		if($data['loai_gia'] == 1) {
			if(!isset($data['gia_san_pham'])) return false;
			if(($data['gia_san_pham'] = zendcms_Controller_Helper_NumberUtils::parseInt($data['gia_san_pham'])) == 0) return false;
			$data['gia_ban'] = $data['gia_san_pham'];
		}
		if($data['loai_gia'] == 2) {
			if(!isset($data['gia_san_pham'])) return false;
			if(($data['gia_san_pham'] = zendcms_Controller_Helper_NumberUtils::parseInt($data['gia_san_pham'])) == 0) return false;
			if(!isset($data['gia_ban'])) return false;
			if(($data['gia_ban'] = zendcms_Controller_Helper_NumberUtils::parseInt($data['gia_ban'])) == 0) return false;
		}
		if($data['loai_gia'] == 3) {
			$data['gia_san_pham'] = null;
			$data['gia_ban'] = null;
		}
		if(!isset($data['trang_thai']) || intval($data['trang_thai'])==0) return false;
		return true;
	}
	public static function validateCapNhatSanPhamForm(&$data) {
		if(!isset($data['id']) || empty($data['id'])) return false;
		if(!isset($data['ten_san_pham']) || empty($data['ten_san_pham'])) return false;
		if(!isset($data['danhmuccon_id']) || empty($data['danhmuccon_id'])) return false;
		if(!isset($data['chkModuleSanPham']) || empty($data['chkModuleSanPham'])) return false;
		if(!isset($data['tinh_trang']) || intval($data['tinh_trang'])==0) return false;
		if(!isset($data['loai_gia']) || intval($data['loai_gia'])==0) return false;
		if($data['loai_gia'] == 1) {
			if(!isset($data['gia_san_pham'])) return false;
			if(($data['gia_san_pham'] = zendcms_Controller_Helper_NumberUtils::parseInt($data['gia_san_pham'])) == 0) return false;
			$data['gia_ban'] = $data['gia_san_pham'];
		}
		if($data['loai_gia'] == 2) {
			if(!isset($data['gia_san_pham'])) return false;
			if(($data['gia_san_pham'] = zendcms_Controller_Helper_NumberUtils::parseInt($data['gia_san_pham'])) == 0) return false;
			if(!isset($data['gia_ban'])) return false;
			if(($data['gia_ban'] = zendcms_Controller_Helper_NumberUtils::parseInt($data['gia_ban'])) == 0) return false;
		}
		if($data['loai_gia'] == 3) {
			$data['gia_san_pham'] = null;
			$data['gia_ban'] = null;
		}
		if(!isset($data['trang_thai']) || intval($data['trang_thai'])==0) return false;
		return true;
	}
	
	public static function validateCapNhatModuleForm($data) {
		if(!isset($data['ma_module']) || empty($data['ma_module'])) return false;
		//if(!isset($data['gianhang_id']) || empty($data['gianhang_id'])) return false;
		if(!isset($data['ten_module']) || empty($data['ten_module'])) return false;
		if(!isset($data['vitri']) || intval($data['vitri'])==0) return false;
		if(!isset($data['state'])) return false;
		if(in_array(intval($data['state']), array(0,1)) == false) return false;
		return true;
	}
	
	public static function validateOrderForm($data) {
		if(!isset($data['sanpham_soluong']) || empty($data['sanpham_soluong'])) return false;
		$emailValidate = new Zend_Validate_EmailAddress();
		if(!isset($data['email']) || !$emailValidate->isValid($data['email'])) return false;
		if(!isset($data['ho_ten']) || empty($data['ho_ten'])) return false;
		if(!isset($data['dien_thoai']) || empty($data['dien_thoai'])) return false;
		if(!isset($data['tinhthanh_id']) || empty($data['tinhthanh_id'])) return false;
		return true;
	}
	public static function validateUpdateGianhangForm($data) {
		$emailValidate = new Zend_Validate_EmailAddress();
		if(!isset($data['email_gianhang']) || !$emailValidate->isValid($data['email_gianhang'])) return false;
		if(!isset($data['ho_ten']) || empty($data['ho_ten'])) return false;
		if(!isset($data['ten_gian_hang']) || empty($data['ten_gian_hang'])) return false;
		if(!isset($data['dia_chi']) || empty($data['dia_chi'])) return false;
		if(!isset($data['dien_thoai']) || empty($data['dien_thoai'])) return false;
		if(!isset($data['tinhthanh_id']) || empty($data['tinhthanh_id'])) return false;
		return true;
	}
     
}
?>