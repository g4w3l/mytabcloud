<?php

class Application_Model_InstrumentMapper
{
	protected $_dbTable;
		
	public function setDbTable($dbTable) {
        if (is_string($dbTable)) { $dbTable = new $dbTable(); }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) { throw new Exception('Invalid table data gateway provided'); }
        $this->_dbTable = $dbTable;
        return $this;
	}
 
    public function getDbTable() {
        if (null === $this->_dbTable) { $this->setDbTable('Application_Model_DbTable_Instrument'); }
        return $this->_dbTable;
    }
	
	public function save(Application_Model_Instrument $preset) {
		// TODO : Save
	}
	
	public function find($id, Application_Model_Instrument $preset) {
		// Requête permettant de récupérer un utilisateur par son ID
		$result = $this->getDbTable()->find($id);
        if (0 == count($result)) { return; }
		
		// On met le résultat de la requête dans un objet Application_Model_User
        $row = $result->current();
        $tab->setId($row->ins_id)
			 ->setName($row->ins_name);
	}
	
	public function delete($id)
    {
        $result = $this->getDbTable()->delete($id);
    }
	
	public function fetchAll() {
		$resultSet = $this->getDbTable()->fetchAll();
       
	   $entries   = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_Instrument();
            $entry->setId($row->ins_id)
				 ->setName($row->ins_name);
            $entries[] = $entry;
        }
        return $entries;
	}
	
	/** Fonction qui donne un tableau valeur=>label **/
	public function fetchAllForSelect() {
		$resultSet = $this->getDbTable()->fetchAll();
       
	   $entries   = array();
        foreach ($resultSet as $row) {
			// Value => Label
            $entries[$row->ins_id] = $row->ins_name;
        }
        return $entries;
	}
}

