<?php

class Application_Model_DbTable_Friendship extends Zend_Db_Table_Abstract
{

    protected $_name = 'mtc_friendship';
	
	public function getName() {
		return $this->_name;
	}

}

