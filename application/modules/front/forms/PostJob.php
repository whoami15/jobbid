<?php

class Front_Form_PostJob extends Zend_Form {
	protected static $_instance = null;
	public function __construct($options = null) {
		parent::__construct ( $options );
		$this->setOptions ( array ('method' => 'get', 'elementDecorators' => array ('ViewHelper' ) ) );
		
		$this->addElement ( 'Text', 'company', array (
			'filters' => array ('StringTrim' ), 
			'attribs' => array ('class' => 'text element', 'maxlength' => 255 ) ) 
		);
		
		$this->addElement ( 'Text', 'title', array (
			'required'=>true,
			'filters' => array ('StringTrim' ), 
			'attribs' => array ('class' => 'text element', 'maxlength' => 255 ) ) 
		);
		
		$this->addElement ( 'Textarea', 'job_description', array (
			'required' => true, 
			'filters' => array ('StringTrim' ), 'attribs' => array ('class' => '', 'rows' => 10,'style' => 'width:100%' ) ) 
		);
		$cities = Application_Model_DbTable_City::findAll ();
		$array = array ();
		foreach ( $cities as $city ) {
			$array [$city ['id']] = $city ['name_city'];
		}
		$this->addElement ( 'Select', 'city_id', array ('multiOptions' => $array ) );
		$this->addElement ( 'Text', 'email_to', array (
			'required' => true, 
			'validators' => array ('EmailAddress' ), 
			'filters' => array ('StringTrim' ), 
			'attribs' => array ('class' => 'text element', 'maxlength' => 255 ) )
		);
		$this->addElement ( 'Select', 'job_type', array ('multiOptions' => array(
			'1' => 'Part-time','2' => 'Full-time', '3' => 'Theo công việc'
		) ) );
		$this->setDecorators ( array (array ('ViewScript', array ('viewScript' => '_forms/post-job.php' ) ) ) );
	}
	
	public static function getInstance() {
		if (empty ( self::$_instance )) {
			self::$_instance = new Front_Form_PostJob ();
		}
		return self::$_instance;
	}
}

?>