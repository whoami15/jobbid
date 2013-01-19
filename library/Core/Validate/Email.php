<?php
class Core_Validate_Email extends Zend_Validate_Abstract
{
	const EMAIL = 'email';
 
    protected $_messageTemplates = array(
        self::EMAIL => "'%value%' has already been registered before!"
    );
 
    public function isValid($value)
    {
        $this->_setValue($value);
        $session = new Zend_Session_Namespace('register');
        $dbUser = new product_Model_DbTable_User();
        if($dbUser->existEmail($value,$session->uid)) {
        	$this->_error(self::EMAIL);
            return false;
        }
        return true;
    }
}
