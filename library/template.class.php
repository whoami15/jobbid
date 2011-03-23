<?php
class Template {

    protected $variables = array();
    protected $_controller;
    protected $_action;

    function __construct($controller,$action) {
        $this->_controller = $controller;
        $this->_action = $action;
    }

    /** Set Variables **/

    function set($name,$value) {
        $this->variables[$name] = $value;
    }

    /** Display Template **/
    function render($doNotRenderHeader = 0)
    {
		global $cache;
		$data = $cache->get("banner");
		$this->set('banner',$data);
		$data = $cache->get("menu");
		$this->set('menu',$data);
		$data = $cache->get("leftcol");
		$this->set('leftcol',$data);
		$data = $cache->get("rightcol");
		$this->set('rightcol',$data);
		$data = $cache->get("footer");
		$this->set('footer',$data);
		$data = $cache->get("menuList");
		
		$this->set('menuList',$data);
        $html = new HTML;
        extract($this->variables);
		include (ROOT . DS . 'application' . DS . 'views' . DS . 'layout.php');
    }  

    function renderAdminPage()
    {
        $html = new HTML;
        extract($this->variables);
		//die(ROOT . DS . 'application' . DS . 'views' . DS . 'admin_layout.php');
        include (ROOT . DS . 'application' . DS . 'views' . DS . 'admin_layout.php');
    }
	function renderPage()
    {
        $html = new HTML;
        extract($this->variables);
		include (ROOT . DS . 'application' . DS . 'views' . DS . $this->_controller . DS . $this->_action . '.php'); 
    }
	function downloadFile($filename)
    {
        $html = new HTML;
        extract($this->variables);
        if (file_exists(ROOT . DS . 'public' . DS . 'upload' . DS . $filename)) {
            include (ROOT . DS . 'application' . DS . 'views' . DS . $this->_controller . DS . $this->_action . '.php');
        }
    }
}