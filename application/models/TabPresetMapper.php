<?php

class Application_Model_TabPresetMapper
{
	protected $_dbTable;
		
	public function setDbTable($dbTable) {
        if (is_string($dbTable)) { $dbTable = new $dbTable(); }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) { throw new Exception('Invalid table data gateway provided'); }
        $this->_dbTable = $dbTable;
        return $this;
	}
 
    public function getDbTable() {
        if (null === $this->_dbTable) { $this->setDbTable('Application_Model_DbTable_TabPreset'); }
        return $this->_dbTable;
    }
	
	public function save(Application_Model_TabPreset $preset) {
		// TODO : Save
	}
	
	public function find($id, Application_Model_TabPreset $preset) {
		// Requête permettant de récupérer un utilisateur par son ID
		$result = $this->getDbTable()->find($id);
        if (0 == count($result)) { return; }
		
		// On met le résultat de la requête dans un objet Application_Model_User
        $row = $result->current();
        $tab->setId($row->pst_id)
			 ->setName($row->pst_name)
			 ->setNbStrings($row->pst_nb_strings)
			 ->setCapo($row->pst_capo)
			 ->setTuning($row->pst_tuning);
	}
	
	public function delete($id)
    {
        $result = $this->getDbTable()->delete($id);
    }
	
	public function fetchAll() {
		$resultSet = $this->getDbTable()->fetchAll();
       
	   $entries   = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_TabPreset();
            $entry->setId($row->pst_id)
				 ->setName($row->pst_name)
				 ->setNbStrings($row->pst_nb_strings)
				 ->setCapo($row->pst_capo)
				 ->setTuning($row->pst_tuning);
            $entries[] = $entry;
        }
        return $entries;
	}
}

