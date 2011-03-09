<?php
defined('_JEXEC') or die();
class TableTour extends JTable {
    var $id = null;
    var $tentour = null;
    var $giatien = null;
	var $thoigiandi = null;
	var $phuongtien = null;
	var $ngaykhoihanh = null;
	var $nhomtour = null;
	var $diemden = null;
	var $hienthi = null;
	var $gioithieu = null;
	var $anhdaidien = null;
    function TableTour(&$db) {
        parent::__construct('jos_tdl_tour', 'id', $db);
    }

}
?>