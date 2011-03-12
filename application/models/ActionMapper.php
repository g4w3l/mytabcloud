<?php

class Application_Model_ActionMapper
{
	protected $_dbTable;
		
	public function setDbTable($dbTable) {
        if (is_string($dbTable)) { $dbTable = new $dbTable(); }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) { throw new Exception('Invalid table data gateway provided'); }
        $this->_dbTable = $dbTable;
        return $this;
	}
 
    public function getDbTable() {
        if (null === $this->_dbTable) { $this->setDbTable('Application_Model_DbTable_Action'); }
        return $this->_dbTable;
    }
    
    public function save($user, $action, $type, $resource) {
		// Objet à sauvegarder
		// champ de table -> attribut de l'objet
		$data = array(
			'act_user' => $user,
			'act_action' => $action,
			'act_type' => $type,
			'act_resource' => $resource,
			'act_timestamp' => date('Y-m-d H:i:s')
		);
		
		// Vérification s'il s'agit d'un update ou d'un insert
		$this->getDbTable()->insert($data);        
	}

}

