<?php
defined('_JEXEC') or die();
class TableDmdiemxuatphat extends JTable {
    var $id = null;
    var $tendiadiem = null;
    var $loaitour=null;
    function TableDmdiemxuatphat(&$db) {
        parent::__construct('jos_tdl_dmdiemxuatphat', 'id', $db);
    }

}
?>