<?php
defined('_JEXEC')or die('Restricted Access'); 
jimport('joomla.application.component.controller');
jimport('validator');
class TourdulichControllerDmdiemxuatphat extends TourdulichController {
    private $_link;
    private $currentSession;
    function  display()
    {
        $view =    $this->getView('dmdiemxuatphat', 'html');
        $model =   $this->getModel('dmdiemxuatphat');
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
        $view =    $this->getView('dmdiemxuatphat', 'html');
        $model =   $this->getModel('dmdiemxuatphat');
        $view->setModel($model, true);
        $view->setLayout("form");
        $cid = JRequest::getVar( 'cid', array(0), '', 'array' );
        JRequest::setVar('hidemainmenu', 1);
        $view->edit($cid[0]);
    }
    function save() {

        $model = $this->getModel('dmdiemxuatphat');    
        $task     = JRequest::getCmd('task','save');
        $post    = JRequest::get( 'post' );
        Validator::valid("require","tendiadiem",$post['tendiadiem']);
        Validator::valid("requireselect","loaitour",$post['loaitour']);
        $arr=$this->currentSession->get('missing');
        if(count($arr)>0)
        {
            $this->currentSession->set('saveform',$post);
            $msg = JText::_('Lỗi : Không thể lưu');
            $this->setRedirect($this->link ."&action=dmdiemxuatphat&controller=dmdiemxuatphat&task=edit", $msg);
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
                    $url = $this->link. "&action=dmdiemxuatphat&controller=dmdiemxuatphat" ;
                    break;
                case 'save2new':
                    $url = $this->link . "&action=dmdiemxuatphat&controller=dmdiemxuatphat&task=add";
                    break;
                case 'apply':
                    $url = $this->link ."&action=dmdiemxuatphat&controller=dmdiemxuatphat&task=edit&cid=".$post['id'];
                    break;
            }
            $this->setRedirect($url, $msg);
        }
    }
    function remove() {
        $model = $this->getModel('dmdiemxuatphat');
        if(!$model->delete()) {
            $msg = JText::_('Lỗi : không thể xóa');
        }
        else {
            $msg = JText::_('Xóa thành công');
        }
        $this->setRedirect($this->link. "&action=dmdiemxuatphat&controller=dmdiemxuatphat", $msg );
    }
    function cancel() {
        $msg = JText::_( 'Hủy bỏ' );
        $this->setRedirect( $this->link. "&action=dmdiemxuatphat&controller=dmdiemxuatphat" , $msg );
    }
    function getList()
    {

        $idloaitour=JRequest::getVar('cid');
        $model =   $this->getModel('dmdiemxuatphat');
        $rs=$model->getList($idloaitour);
        $buffer="<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
        $buffer=$buffer."<response>\n";
        foreach($rs as $row)
        {
            $buffer.="<result>\n";
            $buffer.="\t<id>".$row['id']."</id>\n";
            $buffer.="\t<tendiadiem>".$row['tendiadiem']."</tendiadiem>\n";
            $buffer.="</result>\n";
        }
        $buffer.="</response>\n";
        print_r($buffer);
    }
}
?>