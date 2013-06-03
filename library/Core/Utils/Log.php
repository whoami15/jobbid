<?php
class Core_Utils_Log
{	
	public static function log($msg) {
		//echo $msg.PHP_EOL;
		$logFileName = 'LOG_'.date('Y-m-d').'.txt';
		$writer = new Zend_Log_Writer_Stream(PATH_LOG_FILES.$logFileName);
		$logger = new Zend_Log($writer);
		$logger->setTimestampFormat('Y-m-d H:i:s');
		$logger->log($msg, Zend_Log::INFO);
		$writer->shutdown();
		//$logger->error($msg);
	}
	public static function error($e,$pri = Zend_Log::ERR) {
		//echo 'MESSAGE : '.$msg.PHP_EOL;
		$msg = $e->getMessage().PHP_EOL;
		$msg.= $e->getTraceAsString();
		if($pri == null) $pri = Zend_Log::ERR;
		if($pri == Zend_Log::EMERG) { //khan cap
			//send email & sms
			//Core_Utils_MailUtil::getInstance()->send(MASTER_EMAIL,'Grab error',$msg);
			//Worker_Model_Log::getInstance()->writeLog($msg);
			$coreEmail = new Core_Email();
			$coreEmail->send(DEV_EMAIL, '[jobbid.vn] EMERG!', $msg);
		}
		$logFileName = 'ERROR_'.date('Y-m-d').'.txt';
		$writer = new Zend_Log_Writer_Stream(PATH_LOG_FILES.$logFileName);
		$logger = new Zend_Log($writer);
		$logger->setTimestampFormat('Y-m-d H:i:s');
		$logger->log($msg, $pri);
		$writer->shutdown();
		//$logger->error($msg);
	}
	public static function write($msg,$reset=true) {
		$logFileName = PATH_LOG_FILES.'DEBUG_'.date('Y-m-d').'.txt';
		$file = fopen($logFileName, 'w');
		fwrite($file, $msg);
		fclose($file);
		//file_put_contents($logFileName, $msg);
		/*$writer = new Zend_Log_Writer_Stream(PATH_LOG_FILES.$logFileName,'w');
		$logger = new Zend_Log($writer);
		$logger->setTimestampFormat('Y-m-d H:i:s');
		$logger->log($msg, Zend_Log::ERR);
		$writer->shutdown();*/
	}
	public static function log123($msg) {
		$logFileName = PATH_LOG_FILES.'LOG123_'.date('Y-m-d').'.txt';
		$writer = new Zend_Log_Writer_Stream($logFileName);
		$logger = new Zend_Log($writer);
		$logger->setTimestampFormat('Y-m-d H:i:s');
		$logger->log($msg, Zend_Log::INFO);
		$writer->shutdown();
		//file_put_contents($logFileName, $msg);
		/*$writer = new Zend_Log_Writer_Stream(PATH_LOG_FILES.$logFileName,'w');
		$logger = new Zend_Log($writer);
		$logger->setTimestampFormat('Y-m-d H:i:s');
		$logger->log($msg, Zend_Log::ERR);
		$writer->shutdown();*/
	}
	
}