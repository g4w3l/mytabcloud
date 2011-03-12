<?php

class Application_Model_DbTable_Note extends Zend_Db_Table_Abstract
{

    protected $_name = 'mtc_note';
	protected $_referenceMap	= array(
		'User' => array(
			'columns' 		=> 'note_tab',
			'refTableClass' => 'Application_Model_DbTable_Tab',
			'refColumns'	=> 'tab_id'
		)
	);


}

