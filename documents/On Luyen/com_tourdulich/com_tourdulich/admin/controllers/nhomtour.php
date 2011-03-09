<?php
defined('_JEXEC')or die('Restricted Access'); 
jimport('joomla.application.component.controller');
jimport('validator');
class TourdulichControllerNhomtour extends TourdulichController {
    private $_link;
    private $currentSession;
    function  display()
    {
        $view =    $this->getView('nhomtour', 'html');
        $model =   $this->getModel('nhomtour');
        $view->setModel($model, true);
        $view->display();
    }
    function __construct() {
        parent::__construct();
// Register Extra tasks
        $this->registerTask( 'add','edit' );
        $this->registerTask    ( 'save2new','save');
        $this->registerTask('apply','save');
        $this->link = 'index.php?option=com_tourdulich';
        $this->currentSession = JSession::getInstance('none',array());
    }
    function edit() {
        $view =    $this->getView('nhomtour', 'html');
        $model =   $this->getModel('nhomtour');
        $view->setModel($model, true);
        $view->setLayout("form");
        $cid = JRequest::getVar( 'cid', array(0), '', 'array' );
        JRequest::setVar('hidemainmenu', 1);
        $view->edit($cid[0]);
    }
    function save() {

        $model = $this->getModel('nhomtour');
        $task     = JRequest::getCmd('task','save');
        $post    = JRequest::get( 'post' );
        Validator::valid("require","tennhomtour",$post['tennhomtour']);
        Validator::valid("requireselect","diemxuatphat",$post['diemxuatphat']);
        $arr=$this->currentSession->get('missing');
        if(count($arr)>0)
        {
            $this->currentSession->set('saveform',$post);
            $msg = JText::_('Lỗi : Không thể lưu');
            $this->setRedirect($this->link ."&action=nhomtour&controller=nhomtour&task=edit", $msg);
        }
        else
        {
            if($model->store($post)) {
                if($id != 0)
                    $msg = JText::_('Cập nhật thành công');
                else
                    $msg = JText::_('Lưu thành công');
            }
            else
                $msg = JText::_('Lỗi : Không thể lưu');
            switch ($task) {
                case 'save':
                    $url = $this->link. "&action=nhomtour&controller=nhomtour" ;
                    break;
                case 'save2new':
                    $url = $this->link . "&action=nhomtour&controller=nhomtour&task=add";
                    break;
                case 'apply':
                    $url = $this->link ."&action=nhomtour&controller=nhomtour&task=edit&cid=".$post['id'];
                    break;
            }
            $this->setRedirect($url, $msg);
        }
    }
    function remove() {
        $model = $this->getModel('nhomtour');
        if(!$model->delete()) {
            $msg = JText::_('Lỗi : không thể xóa');
        }
        else {
            $msg = JText::_('Xóa thành công');
        }
        $this->setRedirect($this->link. "&action=nhomtour&controller=nhomtour", $msg );
    }
    function cancel() {
        $msg = JText::_( 'Hủy bỏ' );
        $this->setRedirect( $this->link. "&action=nhomtour&controller=nhomtour" , $msg );
    }
    function getList()
    {
        
        $iddiemxuatphat=JRequest::getVar('cid');
        $model =   $this->getModel('nhomtour');
        $rs=$model->getList($iddiemxuatphat);
        print_r($rs);
    }
}
?>