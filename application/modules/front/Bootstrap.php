<?php

class front_Bootstrap extends Zend_Application_Module_Bootstrap
{
	public function _initAuloload() 
        {
             $autoloader = new Zend_Application_Module_Autoloader(array(
            'namespace' => 'Front_',
            'basePath'  => dirname(__FILE__),
        	));
        	return $autoloader;
        }
}

