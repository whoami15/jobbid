<?php
defined('_JEXEC') or die();
class TableNhomtour extends JTable {
    var $id = null;
    var $tennhomtour = null;
    var $diemxuatphat = null;
    function TableNhomtour(&$db) {
        parent::__construct('jos_tdl_nhomtour', 'id', $db);
    }

}
?>