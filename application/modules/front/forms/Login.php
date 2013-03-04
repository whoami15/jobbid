<?php

class Front_Form_Login extends Zend_Form {
	protected static $_instance = null;
	public function __construct($options = null) {
		parent::__construct ( $options );
		$this->setOptions ( array ('method' => 'get', 'elementDecorators' => array ('ViewHelper' ) ) );
		
		$this->addElement ( 'Text', 'username', array (
			'required'   => true,
			'filters' => array ('StringTrim' ), 
			'attribs' => array ('class' => 'text', 'maxlength' => 100,'placeholder' => 'example@gmail.com' ) ) 
		);
		$this->addElement ( 'Password', 'password', array (
			'required'   => true,
			'filters' => array ('StringTrim' ), 
			'attribs' => array ('class' => 'text', 'maxlength' => 255 ) ) 
		);
		$this->setDecorators ( array (array ('ViewScript', array ('viewScript' => '_forms/login.php' ) ) ) );
	}
	
	public static function getInstance() {
		if (empty ( self::$_instance )) {
			self::$_instance = new Front_Form_Login ();
		}
		return self::$_instance;
	}
}

?>