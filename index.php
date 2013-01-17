<?php
define('DS', DIRECTORY_SEPARATOR);
define('PS', PATH_SEPARATOR);
define('ROOT_DIR', dirname(__FILE__));
define('LIB_DIR',  ROOT_DIR . DS . 'library');
// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(ROOT_DIR . DS .'application'));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'development'));
	
require_once APPLICATION_PATH.DS.'configs'.DS.'define.php';
// Ensure library/ is on include_path
set_include_path(PS . LIB_DIR  . PS . get_include_path());

/** Zend_Application */
require_once 'Zend/Application.php';
require_once 'functions.php';

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);
$application->bootstrap()
            ->run();