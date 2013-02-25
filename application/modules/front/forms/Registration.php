<?php

class Front_Form_Registration extends Zend_Form {
	protected static $_instance = null;
	public function __construct() {
		parent::__construct ();
		$this->setOptions ( array ('method' => 'get', 'elementDecorators' => array ('ViewHelper' ) ) );
		
		$this->addElement ( 'Text', 'username', 
			array (
				'required'   => true,
				'filters' => array ('StringTrim' ), 
				'attribs' => array ('class' => 'text', 'maxlength' => 100,'placeholder' => 'example@gmail.com' ),
				'validators' => array('EmailAddress',new Core_Validate_Email())
			)
		);
		$this->addElement ( 'Password', 'password', array (
			'required'   => true,
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
		$this->setDecorators ( array (array ('ViewScript', array ('viewScript' => '_forms/registration.php' ) ) ) );
	}
	
	public static function getInstance() {
		if (empty ( self::$_instance )) {
			self::$_instance = new Front_Form_Registration ();
		}
		return self::$_instance;
	}
}

?>