<?php
defined('_JEXEC') or die('Restrict Access');
jimport('joomla.application.component.model');
class TourdulichModelTourdulich extends JModel {
    var $_data;
    function _buildQuery() {
        $query = "select * from jos_tdl_tour";
        return $query;
    }
    function getData() {
        if (empty( $this->_data )) {
            $query = $this->_buildQuery();
            $this->_data = $this->_getList( $query );
        }
        return $this->_data;
    }
} 
?>