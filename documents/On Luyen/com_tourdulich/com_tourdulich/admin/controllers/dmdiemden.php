<?php
defined('_JEXEC')or die('Restricted Access'); 
jimport('joomla.application.component.controller');
jimport('validator');
class TourdulichControllerDmdiemden extends TourdulichController {
    private $_link;
    private $currentSession;
    function  display()
    {
        $view =    $this->getView('dmdiemden', 'html');
        $model =   $this->getModel('dmdiemden');
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
        $view =    $this->getView('dmdiemden', 'html');
        $model =   $this->getModel('dmdiemden');
        $view->setModel($model, true);
        $view->setLayout("form");
        JRequest::setVar('hidemainmenu', 1);
        $view->edit();
    }
    function save() {

        $model = $this->getModel('dmdiemden');    
        $task     = JRequest::getCmd('task','save');
        $post    = JRequest::get( 'post' );
        Validator::valid("require","tendiadiem",$post['tendiadiem']);
        $arr=$this->currentSession->get('missing');
        if(count($arr)>0)
        {
            $this->currentSession->set('saveform',$post);
            $msg = JText::_('Lỗi : Không thể lưu');
            $this->setRedirect($this->link ."&action=dmdiemden&controller=dmdiemden&task=edit", $msg);
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
                    $url = $this->link. "&action=dmdiemden&controller=dmdiemden" ;
                    break;
                case 'save2new':
                    $url = $this->link . "&action=dmdiemden&controller=dmdiemden&task=add";
                    break;
                case 'apply':
                    $url = $this->link ."&action=dmdiemden&controller=dmdiemden&task=edit&cid=".$post['id'];
                    break;
            }
            $this->setRedirect($url, $msg);
        }
    }
    function remove() {
        $model = $this->getModel('dmdiemden');
        if(!$model->delete()) {
            $msg = JText::_('Lỗi : không thể xóa');
        }
        else {
            $msg = JText::_('Xóa thành công');
        }
        $this->setRedirect($this->link. "&action=dmdiemden&controller=dmdiemden", $msg );
    }
    function cancel() {
        $msg = JText::_( 'Hủy bỏ' );
        $this->setRedirect( $this->link. "&action=dmdiemden&controller=dmdiemden" , $msg );
    }
}
?>