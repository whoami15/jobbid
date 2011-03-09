<?php
defined('_JEXEC')or die('Restricted Access'); 
jimport('joomla.application.component.controller');
jimport('validator');
jimport('functionclass');
class TourdulichControllerNoidung extends TourdulichController {
    private $_link;
    private $currentSession;
    function  display() {
        $view =    $this->getView('noidung', 'html');
        $model =   $this->getModel('noidung');
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
        $view =    $this->getView('noidung', 'html');
        $model =   $this->getModel('noidung');
        $view->setModel($model, true);
        $view->setLayout("form");
        JRequest::setVar('hidemainmenu', 1);
        $view->edit();
    }
    function save() {

        $model = $this->getModel('noidung');
        $task     = JRequest::getCmd('task','save');
        $post    = JRequest::get( 'post',JREQUEST_ALLOWRAW );
        Validator::valid("require","tieude",$post['tieude']);
        $post['thutu']=FunctionClass::getNum($post['thutu']);
        Validator::valid("require","thutu",$post['thutu']);
        if(!isset($post['published']))
            $post['published']=0;
        Validator::valid("require","tour_id",$post['tour_id']);
        $arr=$this->currentSession->get('missing');
        if(count($arr)>0) {
            $this->currentSession->set('saveform',$post);
            $msg = JText::_('Lỗi : Không thể lưu. Vui lòng check lại thông tin!');
            $this->setRedirect($this->link ."&action=noidung&controller=noidung&task=edit", $msg);
        }
        else {
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
                    $url = $this->link. "&action=noidung&controller=noidung" ;
                    break;
                case 'save2new':
                    $url = $this->link . "&action=noidung&controller=noidung&task=add";
                    break;
                case 'apply':
                    $url = $this->link ."&action=noidung&controller=noidung&task=edit&cid=".$post['id'];
                    break;
            }
            $this->setRedirect($url, $msg);
        }
    }
    function remove() {
        $model = $this->getModel('noidung');
        if(!$model->delete()) {
            $msg = JText::_('Lỗi : không thể xóa');
        }
        else {
            $msg = JText::_('Xóa thành công');
        }
        $this->setRedirect($this->link. "&action=noidung&controller=noidung", $msg );
    }
    function cancel() {
        $msg = JText::_( 'Hủy bỏ' );
        $this->setRedirect( $this->link. "&action=noidung&controller=noidung" , $msg );
    }
    function close()
    {
        $this->setRedirect( $this->link. "&action=tour&controller=tour");
    }
}
?>