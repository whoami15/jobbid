<?phpdefined('_JEXEC')or die('Restricted Access');require_once( JApplicationHelper::getPath('toolbar_html')); jimport('joomla.application.component.view');class TourdulichViewDmdiemxuatphat extends JView {    function display($tpl=null) {        $items= &$this->get('Data');                $pagination = &$this->get('Pagination');        $filter = &$this->get('Filter');        $lists = &$this->get('Lists');        TOOLBAR_Danhmuc::_Danhmuc();        $this->assignRef('items',        $items);        $this->assignRef('pagination',    $pagination);        $this->assignRef('filter',        $filter);        $this->assignRef('lists',        $lists);        parent::display($tpl);    }    function edit($cid=null,$tpl=null) {        $model=$this->getModel();        $info=$model->getDiemxuatphat($cid);        $model = & JModel::getInstance('loaitour','TourdulichModel');        $lstloaitour=$model->getData();                $isNew            =($info->id < 1);        $text            =$isNew ? TOOLBAR_Danhmuc::_NEW_Danhmuc():TOOLBAR_Danhmuc::_EDIT_Danhmuc() ;        $this->assignRef('info',$info);        $this->assignRef('lstloaitour',$lstloaitour);        parent::display($tpl);    }} ?>