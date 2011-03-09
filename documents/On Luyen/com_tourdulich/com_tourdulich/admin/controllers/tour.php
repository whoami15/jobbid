<?php
defined('_JEXEC')or die('Restricted Access'); 
jimport('joomla.application.component.controller');
jimport('validator');
jimport('functionclass');
class TourdulichControllerTour extends TourdulichController {
    private $_link;
    private $currentSession;
    function  display()
    {
        $view =    $this->getView('tour', 'html');
        $model =   $this->getModel('tour');
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
        $view =    $this->getView('tour', 'html');
        $model =   $this->getModel('tour');
        $view->setModel($model, true);
        $view->setLayout("form");
        JRequest::setVar('hidemainmenu', 1);
        $view->edit();
    }
    function manage_content()
    {
        $view =    $this->getView('noidung', 'html');
        $model =   $this->getModel('noidung');
        $view->setModel($model, true);
        $cid=JRequest::getVar('cid');
        $this->currentSession->set('tour_id',$cid);
        $view->display();
    }
    function save() {

        $model = $this->getModel('tour');    
        $task     = JRequest::getCmd('task','save');
        $post    = JRequest::get( 'post',JREQUEST_ALLOWRAW );
        $savepost=$post;
        Validator::valid("require","tentour",$post['tentour']);
        $post['giatien']=FunctionClass::getNum($post['giatien']);
        Validator::valid("require","giatien",$post['giatien']);
        Validator::valid("require","thoigiandi",$post['thoigiandi']);
        Validator::valid("require","ngaykhoihanh",$post['ngaykhoihanh']);
        Validator::valid("requireselect","diemden",$post['diemden']);
        Validator::valid("requireselect","loaitour",$post['loaitour']);
        if(!isset($post['hienthi']))
            $post['hienthi']=0;
        $arr=$this->currentSession->get('missing');
        if(count($arr)>0)
        {
            $this->currentSession->set('saveform',$savepost);
            $msg = JText::_('Lỗi : Không thể lưu. Vui lòng check lại thông tin!');
            $this->setRedirect($this->link ."&action=tour&controller=tour&task=edit", $msg);
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
                case 'apply':
                    $url = $this->link ."&action=tour&controller=tour&task=edit&cid=".$post['id'];
                    break;
                case 'save2new':
                    $url = $this->link . "&action=tour&controller=tour&task=add";
                    break;
                case 'save':
                    $url = $this->link. "&action=tour&controller=tour" ;
                    break;
            }
            $this->setRedirect($url, $msg);
        }
    }
    function remove() {
        $model = $this->getModel('tour');
        if(!$model->delete()) {
            $msg = JText::_('Lỗi : không thể xóa');
        }
        else {
            $msg = JText::_('Xóa thành công');
        }
        $this->setRedirect($this->link. "&action=tour&controller=tour", $msg );
    }
    function cancel() {
        $msg = JText::_( 'Hủy bỏ' );
        $this->setRedirect( $this->link. "&action=tour&controller=tour" , $msg );
    }
}
?>