<?php

class mDuan {
	var $tenduan;
	var $alias;
	var $linhvuc_id;
	var $duan_email;
	var $duan_sodienthoai;
	var $tinh_id;
	var $ngayketthuc;
	var $costmax;
	var $costmin;
	var $thongtinchitiet;
	var $file_id;
	var $skills;
	var $isbid;
	function mDuan() {
		$this->tenduan = isset($_COOKIE['duan_tenduan'])?$_COOKIE['duan_tenduan']:null;
		$this->alias = isset($_COOKIE['duan_alias'])?$_COOKIE['duan_alias']:null;
		$this->linhvuc_id = isset($_COOKIE['duan_linhvuc_id'])?$_COOKIE['duan_linhvuc_id']:null;
		$this->email = isset($_COOKIE['duan_email'])?$_COOKIE['duan_email']:null;
		$this->sodienthoai = isset($_COOKIE['duan_sodienthoai'])?$_COOKIE['duan_sodienthoai']:null;
		$this->tinh_id = isset($_COOKIE['duan_tinh_id'])?$_COOKIE['duan_tinh_id']:null;
		$this->ngayketthuc = isset($_COOKIE['duan_ngayketthuc'])?$_COOKIE['duan_ngayketthuc']:null;
		$this->costmax = isset($_COOKIE['duan_costmax'])?$_COOKIE['duan_costmax']:null;
		$this->costmin = isset($_COOKIE['duan_costmin'])?$_COOKIE['duan_costmin']:null;
		$this->thongtinchitiet = isset($_COOKIE['duan_thongtinchitiet'])?$_COOKIE['duan_thongtinchitiet']:null;
		$this->file_id = isset($_COOKIE['duan_file_id'])?$_COOKIE['duan_file_id']:null;
		$this->skills = isset($_COOKIE['duan_skills'])?$_COOKIE['duan_skills']:null;
		$this->isbid = isset($_COOKIE['duan_isbid'])?$_COOKIE['duan_isbid']:null;
	}
	function clear() {
		setcookie('duan_tenduan', null);
		setcookie('duan_alias', null);
		setcookie('duan_linhvuc_id', null);
		setcookie('duan_email', null);
		setcookie('duan_sodienthoai', null);
		setcookie('duan_tinh_id', null);
		setcookie('duan_ngayketthuc', null);
		setcookie('duan_costmax', null);
		setcookie('duan_costmin', null);
		setcookie('duan_thongtinchitiet', null);
		setcookie('duan_file_id', null);
		setcookie('duan_skills', null);
		setcookie('duan_isbid', null);
	}
	function setlinhvuc_id($value) {
		setcookie('duan_linhvuc_id', $value);
	}
	function setalias($value) {
		setcookie('duan_alias', $value);
	}
	function settenduan($value) {
		setcookie('duan_tenduan', $value);
	}
	function setisbid($value) {
		setcookie('duan_isbid', $value);
	}
	function setskills($value) {
		setcookie('duan_skills', $value);
	}
	function setfile_id($value) {
		setcookie('duan_file_id', $value);
	}
	function setthongtinchitiet($value) {
		setcookie('duan_thongtinchitiet', $value);
	}
	function setcostmin($value) {
		setcookie('duan_costmin', $value);
	}
	function setcostmax($value) {
		setcookie('duan_costmax', $value);
	}
	function setngayketthuc($value) {
		setcookie('duan_ngayketthuc', $value);
	}
	function settinh_id($value) {
		setcookie('duan_tinh_id', $value);
	}
	function setduan_sodienthoai($value) {
		setcookie('duan_duan_sodienthoai', $value);
	}
	function setduan_email($value) {
		setcookie('duan_duan_email', $value);
	}
	
}

?>