<?php
class Core_Validate_Email extends Zend_Validate_Abstract
{
	const EMAIL = 'email';
 
    protected $_messageTemplates = array(
        self::EMAIL => "Email '%value%' đã được sử dụng, vui lòng chọn email khác!"
    );
 
    public function isValid($value)
    {
        $this->_setValue($value);
        $session = new Zend_Session_Namespace('session');
        if(Application_Model_DbTable_TaiKhoan::findByUsername($value) != null && !isset($session->logged)) {
        	$this->_error(self::EMAIL);
            return false;
        }
        return true;
    }
}
