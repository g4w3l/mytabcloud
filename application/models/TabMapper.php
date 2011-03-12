<?php

class Application_Model_TabMapper
{
    protected $_dbTable;
		
	public function setDbTable($dbTable) {
        if (is_string($dbTable)) { $dbTable = new $dbTable(); }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) { throw new Exception('Invalid table data gateway provided'); }
        $this->_dbTable = $dbTable;
        return $this;
	}
 
    public function getDbTable() {
        if (null === $this->_dbTable) { $this->setDbTable('Application_Model_DbTable_Tab'); }
        return $this->_dbTable;
    }
    
    public function save(Application_Model_Tab $tab) {
    	$mapper  = new Application_Model_NoteMapper();
		// Objet à sauvegarder
		// champ de table -> attribut de l'objet
		$data = array(
			'tab_artist' => $tab->getArtist(),
			'tab_title' => $tab->getTitle(),
			'tab_nb_strings' => $tab->getNbStrings(),
			'tab_user' => $tab->getUser()			
		);
		
		// Vérification s'il s'agit d'un update ou d'un insert
		if (null === ($id = $tab->getId())) {
            unset($data['tab_id']);
            $tab_id = $this->getDbTable()->insert($data);
			
			foreach($tab->getContent() as $note) {
				$note->setTab($tab_id);
				$mapper->save($note);
			}
			
			MyTabCloud_Action::logAction($tab->getUser(), 'create', 'tab', $tab_id);			
        } else {
            $this->getDbTable()->update($data, array('tab_id = ?' => $id));
			MyTabCloud_Action::logAction($tab->getUser(), 'update', 'tab', $id);
        }
	}
	
	public function find($id, Application_Model_Tab $tab) {
		// Requ�te permettant de r�cup�rer une tablature par son ID
		$result = $this->getDbTable()->find($id);
        if (0 == count($result)) { return false; }
		
		// On met le résultat de la requ�te dans un objet Application_Model_Tab
        $row = $result->current();
		
		// Initialisation de l'objet qui va nous permettre de récupérer les notes de la tablature
		$noteMap = new Application_Model_NoteMapper();
		
		// Récupération du maximum
		$lastBeat = $noteMap->getLastBeat($id);
		if($lastBeat == "") { $lastBeat = 0; }
				
        $tab->setId($row->tab_id)
			->setArtist($row->tab_artist)
			->setTitle($row->tab_title)
			->setNbStrings($row->tab_nb_strings)
			->setContent($noteMap->findByTab($id))
			->setLastBeat($lastBeat)
			->setUser($row->tab_user);
		
		return true;
	}
		
	public function delete($id)
    {
        $result = $this->getDbTable()->delete($id);
    }
	
	public function fetchAll() {
		$resultSet = $this->getDbTable()->fetchAll();
        $entries   = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_Tab();
            $entry->setId($row->tab_id)
				->setArtist($row->tab_artist)
    			->setTitle($row->tab_title)
    			->setNbStrings($row->tab_nb_strings)
    			->setContent($row->tab_content)
    			->setUser($row->tab_user);
            $entries[] = $entry;
        }
        return $entries;
	}
	
	public function findByUser($user_id) {
	    $resultSet = $this->getDbTable()->fetchAll("tab_user = '" . $user_id . "'");
        $entries   = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_Tab();
            $entry->setId($row->tab_id)
				->setArtist($row->tab_artist)
    			->setTitle($row->tab_title)
    			->setNbStrings($row->tab_nb_strings)
    			->setContent($row->tab_content)
    			->setUser($row->tab_user);
            $entries[] = $entry;
        }
        return $entries;
	}
}

