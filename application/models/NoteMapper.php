<?php

class Application_Model_NoteMapper
{
	protected $_dbTable;
		
	public function setDbTable($dbTable) {
        if (is_string($dbTable)) { $dbTable = new $dbTable(); }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) { throw new Exception('Invalid table data gateway provided'); }
        $this->_dbTable = $dbTable;
        return $this;
	}
 
    public function getDbTable() {
        if (null === $this->_dbTable) { $this->setDbTable('Application_Model_DbTable_Note'); }
        return $this->_dbTable;
    }
    
    public function save(Application_Model_Note $note) {
		// Objet à sauvegarder
		// champ de table -> attribut de l'objet
		$data = array(
			'note_string' => $note->getString(),
			'note_fret' => $note->getFret(),
			'note_beat' => $note->getBeat(),
			'note_tab' => $note->getTab()			
		);
		
		// Vérification s'il s'agit d'un update ou d'un insert
		$this->getDbTable()->insert($data);
	}

		
	public function emptyTab($tab_id)
    {
        $result = $this->getDbTable()->delete("note_tab = '" . $tab_id . "'");
    }
	
	public function fetchAll() {
		$resultSet = $this->getDbTable()->fetchAll();
        $entries   = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_Note();
            $entry->setString($row->note_string)
				->setFret($row->note_fret)
				->setBeat($row->note_beat)
				->setTab($row->note_tab);
            $entries[] = $entry;
        }
        return $entries;
	}
	
	public function findByTab($tab_id) {
	    $resultSet = $this->getDbTable()->fetchAll("note_tab = '" . $tab_id . "'");
        $entries   = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_Note();
            $entry->setString($row->note_string)
				->setFret($row->note_fret)
				->setBeat($row->note_beat)
				->setTab($row->note_tab);
				
            $entries[] = $entry;
        }
        return $entries;
	}
	
	public function getLastBeat($tab_id) {
		$select = $this->getDbTable()->select()
				->from(array('n' => $this->getDbTable()->getName()), array('MAX(note_beat) AS note_beat'))
				->where('note_tab = ?', $tab_id);
		
		$maxbeat = $this->getDbTable()->fetchRow($select);
		return $maxbeat['note_beat'];
	}

}

