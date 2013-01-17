<?php
class zendcms_Exceptions_Exception extends Exception {
	function zendcms_Exceptions_Exception($message) {
		$this->message = $message;
	}
}