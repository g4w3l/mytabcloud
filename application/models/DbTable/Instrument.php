<?php

class Application_Model_DbTable_Instrument extends Zend_Db_Table_Abstract
{
    protected $_name = 'mtc_instrument';
	
	public function getName() {
		return $this->_name;
	}
}

