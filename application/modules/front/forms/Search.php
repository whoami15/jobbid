<?php

class Front_Form_Search extends Zend_Form {
	protected static $_instance = null;
	public function __construct($options = null) {
		parent::__construct ( $options );
		$this->setOptions ( array ('method' => 'get', 'elementDecorators' => array ('ViewHelper' ) ) );
		
		$this->addElement ( 'Text', 'keyword', array (
			'filters' => array ('StringTrim' ), 
			'attribs' => array ('class' => 'text', 'maxlength' => 255,'placeholder' => 'keywords, job title, company...' ) ) 
		);
		$cities = Application_Model_DbTable_City::findAll ();
		$array = array ();
		foreach ( $cities as $city ) {
			$array [$city ['id']] = $city ['name_city'];
		}
		$this->addElement ( 'Select', 'city_id', array (
			'multiOptions' => $array,
			'attribs' => array('style' => 'padding: 5px; position: absolute; height: 30px; left: 320px;')
		) );
		$this->setDecorators ( array (array ('ViewScript', array ('viewScript' => '_forms/search.php' ) ) ) );
	}
	
	public static function getInstance() {
		if (empty ( self::$_instance )) {
			self::$_instance = new Front_Form_PostJob ();
		}
		return self::$_instance;
	}
}

?>