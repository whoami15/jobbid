<?php
defined('_JEXEC') or die();
class TableNoidung extends JTable {
    var $id = null;
    var $tieude = null;
    var $noidung = null;
    var $published = null;
    var $thutu = null;
    var $tour_id = null;
    function TableNoidung(&$db) {
        parent::__construct('jos_tdl_noidung', 'id', $db);
    }

}
?>