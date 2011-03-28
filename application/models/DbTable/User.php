<?php

class Application_Model_DbTable_User extends Zend_Db_Table_Abstract
{
    protected $_name = 'mtc_user';
	protected $_dependentTables = array('Application_Model_DbTable_Tab');
	
	public function getName() {
		return $this->_name;
	}
}

