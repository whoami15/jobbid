<?php

class admin_Model_DbTable_ChucNang extends Zend_Db_Table_Abstract
{

    protected $_name = 'chucnang';
	public function getMenu() {
		$db = Zend_Registry::get('connectDb');
		$stmt = $db->prepare('select * from chucnang where is_root=1 and deleted = 0');
        $stmt->execute();
        $result = $stmt->fetchAll();
		$roots = array();
        foreach($result as $row) {
        	$roots[$row->id] = $row;
        }
        $query = 'select * from chucnang where is_root=0 and deleted = 0 order by menu_name';
        $stmt = $db->prepare($query);
        $stmt->execute();
        $menus = $stmt->fetchAll();
        $stmt->closeCursor();
        $db->closeConnection();
        foreach($menus as $menu)
        	$roots[$menu->parent_id]->childs[] = $menu; 
        return $roots;
	}

}

