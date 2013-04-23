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
try {
	$application->bootstrap();
	try{
		$opts = new Zend_Console_Getopt(
				array(
						'env|e-s' => 'Env',
						'job|j-s' => 'Job',
						'zid|z-s' => 'zingid',
						'uin|u-s' => 'uin'
				)
		);
	
		$opts->parse();
	}catch (Zend_Console_Getopt_Exception $e){
		exit($e->getMessage() ."\n\n". $e->getUsageMessage());
	}
	if(isset($opts->job)) {
		$worker = ucwords(basename($opts->job));
		$workerName = "Application_Model_Worker_{$worker}";
		if(!class_exists($workerName)) {
			throw new InvalidArgumentException('The worker class: ' . $workerName . ' does not exist in file: ');
		}
		$worker = new $workerName();
		if(isset($opts->zid)) {
			$worker->start($opts->zid,$opts->uin);
		} else {
			$worker->start();
		}
	}
	//Application_Model_DbTable_Tag::insertTag('hello');
	//Application_Model_Worker_Test::getInstance()->start();
	//Application_Worker_Test::getInstance()->start();
	//worker_Test::getInstance()->start();
	
	
} catch (Exception $e) {
	echo $e->getMessage().'<br/>Trace:';
	$error = $e->getTraceAsString();
	$error = str_replace('#', '<br/>#', $error);
	echo $error;
	/*foreach ($arrTrace as $str)
	echo $e->getTraceAsString();*/
	//print_r($arrTrace[0]);
}