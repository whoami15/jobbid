<?php
defined('_JEXEC') or die();
class TableLoaitour extends JTable {
    var $id = null;
    var $tenloaitour = null;
    function TableLoaitour(&$db) {
        parent::__construct('jos_tdl_loaitour', 'id', $db);
    }

}
?>