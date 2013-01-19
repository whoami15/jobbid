<?php
class Core_Validate_Username extends Zend_Validate_Abstract
{
	const MSG1 = 'msg1';
	const MSG2 = 'msg2';
 
    protected $_messageTemplates = array(
        self::MSG1 => "'%value%' has not registed yet!",
        self::MSG2 => "'%value%' not valid username!"
    );
 
    public function isValid($value)
    {
        $this->_setValue($value);
        
    	if (preg_match('/^(?=.{1,15}$)[a-zA-Z][a-zA-Z0-9]*(?: [a-zA-Z0-9]+)*$/', $value)==false) {
    		$this->_error(self::MSG2);
            return false;
   	 	}
        /*$dbUser = new back_Model_DbTable_User();
        $user = $dbUser->getUserByUsername($value);
        if($dbUser->existUsername($value)) {
        	$this->_error(self::MSG1);
            return false;
        }*/
        return true;
    }
    
    
}
?>