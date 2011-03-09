<?php
defined('_JEXEC') or die();
jimport('joomla.application.component.model');
class TourdulichModelTourdulich extends JModel {
    function __construct() {
        parent::__construct();
    }
    function getList() {
        $query = "SELECT * FROM jos_tdl_loaitour";
        $rs=$this->_getList($query);
        $arr=array();
        $i=0;
        foreach($rs as $row)
        {
            $query="SELECT t1.* FROM #__tdl_tour as t1 left join #__tdl_nhomtour as t2 on nhomtour=t2.id left join #__tdl_dmdiemxuatphat as t3 on diemxuatphat=t3.id where hienthi=true and loaitour=$row->id order by t1.id desc limit 0,6";
            $rs2=$this->_getList($query);
            $arr[$i]['tenloaitour']=$row->tenloaitour;
            $arr[$i]['loaitour_id']=$row->id;
            $arr[$i]['listtour']=$rs2;
            $i++;
        }
        
        return $arr;
    }
    function getTourList($nhomtour_id) {
        $query = "SELECT * FROM jos_tdl_tour where nhomtour=".$nhomtour_id." order by id desc";
        $db = &JFactory::getDBO();
        $db->setQuery($query);
        return $db->loadAssocList();
    }
    function getTourListByLoaiTour($loaitour_id) {
        $query = "SELECT t1.* FROM #__tdl_nhomtour as t1 left join #__tdl_dmdiemxuatphat as t2 on diemxuatphat=t2.id where loaitour=".$loaitour_id;
        $rs=$this->_getList($query);
        $arr=array();
        $i=0;
        foreach($rs as $row)
        {
            $query="SELECT * FROM jos_tdl_tour where hienthi=true and nhomtour=$row->id order by id desc limit 0,2";
            $rs2=$this->_getList($query);
            $arr[$i]=new stdClass();
            $arr[$i]->tennhomtour=$row->tennhomtour;
            $arr[$i]->nhomtour_id=$row->id;
            $arr[$i]->listtour=$rs2;
            $i++;
        }
        
        return $arr;
    }
    function getNhomTour($id)
    {
        $query = "SELECT * FROM jos_tdl_nhomtour where id=".$id;
        $rs=$this->_getList($query);
        return $rs[0];
    }
    function getDiemxuatphat($id)
    {
        $query = "SELECT * FROM jos_tdl_dmdiemxuatphat where id=".$id;
        $rs=$this->_getList($query);
        return $rs[0];
    }
    function getLoaiTour($id)
    {
        $query = "SELECT * FROM jos_tdl_loaitour where id=".$id;
        $rs=$this->_getList($query);
        return $rs[0];
    }
    function getTour($id)
    {
        $query = "SELECT * FROM jos_tdl_tour where id=".$id;
        $db = &JFactory::getDBO();
        $db->setQuery($query);
        $rs=$db->loadAssocList();
        if(empty($rs))
            return null;
        return $rs[0];
    }
    function getContent($id)
    {
        $query = "SELECT * FROM jos_tdl_noidung where published=true and tour_id=".$id." order by thutu asc";
        $db = &JFactory::getDBO();
        $db->setQuery($query);
        return $db->loadAssocList();
    }
}