<?php
defined('_JEXEC') or die();
class TableDmdiemden extends JTable {
    var $id = null;
    var $tendiadiem = null;
    function TableDmdiemden(&$db) {
        parent::__construct('jos_tdl_dmdiemden', 'id', $db);
    }

}
?>