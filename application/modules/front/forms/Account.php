<?php

class Front_Form_Account extends Zend_Form {
	protected static $_instance = null;
	public function __construct() {
		parent::__construct ();
		$this->setOptions ( array ('method' => 'get', 'elementDecorators' => array ('ViewHelper' ) ) );
		
		$this->addElement ( 'Password', 'password', array (
			'filters' => array ('StringTrim' ), 
			'attribs' => array ('class' => 'text', 'maxlength' => 255 ) ) 
		);
		$this->addElement ( 'Text', 'name', array (
			'required'   => true,
			'filters' => array ('StringTrim' ), 
			'attribs' => array ('class' => 'text', 'maxlength' => 255 ) ) 
		);
		$this->addElement ( 'Text', 'sodienthoai', array (
			'filters' => array ('StringTrim' ), 
			'attribs' => array ('class' => 'text', 'maxlength' => 50 ) ) 
		);
		$this->setDecorators ( array (array ('ViewScript', array ('viewScript' => '_forms/account.php' ) ) ) );
	}
	
	public static function getInstance() {
		if (empty ( self::$_instance )) {
			self::$_instance = new Front_Form_Account ();
		}
		return self::$_instance;
	}
}

?>