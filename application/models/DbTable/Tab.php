<?php

class Application_Model_DbTable_Tab extends Zend_Db_Table_Abstract
{

    protected $_name = 'mtc_tab';
	protected $_referenceMap	= array(
		'User' => array(
			'columns' 		=> 'tab_user',
			'refTableClass' => 'Application_Model_DbTable_User',
			'refColumns'	=> 'usr_id'
		)
	);

}

