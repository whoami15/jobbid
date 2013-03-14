<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	protected function _initRoutes ()
    {
    	/*if( preg_match('/front/', $_SERVER['REQUEST_URI']) == false &&
			preg_match('/back/', $_SERVER['REQUEST_URI']) == false &&
			preg_match('/admin/', $_SERVER['REQUEST_URI']) == false ) {
    		$routeLang = new Zend_Controller_Router_Route(':gianhang/:action',
	        array('gianhang' => '','action'=>''));
	        // Now get router from front controller
	        $front = Zend_Controller_Front::getInstance();
	        $router = $front->getRouter();
	        // Instantiate default module route
	        $routeDefault = new Zend_Controller_Router_Route_Module(array(), 
	        $front->getDispatcher(), $front->getRequest());
	        // Chain it with language route
	        $routeLangDefault = $routeLang->chain($routeDefault);
	        // Add both language route chained with default route and
	        // plain language route
	        $router->addRoute('default', $routeLangDefault);
	        $router->addRoute('gianhang', $routeLang);
    	}*/
    	$front = Zend_Controller_Front::getInstance();
    	
    	// Get Router
    	$router = $front->getRouter();
    	$route = new Zend_Controller_Router_Route(
    			'/duan/view/:id/*',
    			array(
    					'controller' => 'job',
    					'action'     => 'redirect'
    			)
    	);
    	$router->addRoute('route1', $route);
    	$route = new Zend_Controller_Router_Route(
    			'/tag/:key/*',
    			array(
    					'controller' => 'tag',
    					'action'     => 'index'
    			)
    	);
    	$router->addRoute('route2', $route);
    	$route = new Zend_Controller_Router_Route(
    			'/article/view/:id/*',
    			array(
    					'controller' => 'tintuc',
    					'action'     => 'view'
    			)
    	);
    	$router->addRoute('route3', $route);
    	$route = new Zend_Controller_Router_Route(
    			'/raovat/view/:id/*',
    			array(
    					'controller' => 'rao-vat',
    					'action'     => 'view'
    			)
    	);
    	$router->addRoute('route4', $route);
    }
	
	/*protected function _initRoutes() {
		$routeLang = new Zend_Controller_Router_Route(
	        ':lang',
	        array(
	            'lang' => ':lang'
	        )
	    );
	    // Now get router from front controller
	    $front  = Zend_Controller_Front::getInstance();
		$router = $front->getRouter();
	    // Instantiate default module route
	    $routeDefault = new Zend_Controller_Router_Route_Module(
	        array(),
	        $front->getDispatcher(),
	        $front->getRequest()
	    );
	
	    // Chain it with language route
	    $routeLangDefault = $routeLang->chain($routeDefault);
	
	    // Add both language route chained with default route and
	    // plain language route
	    $router->addRoute('default', $routeLangDefault);
	    $router->addRoute('lang', $routeLang);
	}*/
	protected function setconstants($constants){
        foreach ($constants as $key=>$value){
            if(!defined($key)){
                define($key, $value);
            }
        }
	}
	protected  function _initDb(){
	   $dbOption = $this->getOption('resources');
	   $dbOption = $dbOption['db'];
	   $dbOption['params']['driver_options'] = array(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY=>true);
	   //Zend_Registry::setInstance(new Zend_Registry(array("db"=>$dbOption)));
	   $db=Zend_Db::factory($dbOption['adapter'],$dbOption['params']);
	   //$db->setFetchMode(Zend_Db::FETCH_ASSOC);
	   //$db->setFetchMode(Zend_Db::FETCH_OBJ);
	   $db->query("SET NAMES 'UTF8'" );
	   $db->query("SET CHARACTER SET 'UTF8'");
	   Zend_Registry::set("connectDb",$db);
	   Zend_Db_Table::setDefaultAdapter($db);
   	}
}

