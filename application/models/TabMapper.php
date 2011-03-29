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
			'tab_capo' => $tab->getCapo(),
			'tab_tuning' => $tab->getTuning(),
			'tab_desc'	=> $tab->getDescription(),
			'tab_instrument'	=> $tab->getInstrument(),
			'tab_user' => $tab->getUser(),
			'tab_visibility' => $tab->getVisibility()
		);
		
		// Vérification s'il s'agit d'un update ou d'un insert
		if (null === ($id = $tab->getId())) {
            unset($data['tab_id']);
            $data['tab_created'] = date('Y-m-d H:i:s');
			
            $tab_id = $this->getDbTable()->insert($data);
			
			foreach($tab->getContent() as $note) {
				$note->setTab($tab_id);
				$mapper->save($note);
			}
			
			MyTabCloud_Action::logAction($tab->getUser(), 'create', 'tab', $tab_id);			
        } else {
        	$mapper->emptyTab($id);
			
			foreach($tab->getContent() as $note) {
				$note->setTab($id);
				$mapper->save($note);
			}
			
        	//$data['tab_created'] = $tab->getCreated();
			
            $this->getDbTable()->update($data, array('tab_id = ?' => $id));
			MyTabCloud_Action::logAction($tab->getUser(), 'update', 'tab', $id);
        }
	}
	
	public function find($id, Application_Model_Tab $tab, $viewer_id, $edit = false) {
		// Adapter pour les jointures
		$db = $this->getDbTable()->getAdapter();
		
		$friend_table 			= new Application_Model_DbTable_Friendship();
		$user_table				= new Application_Model_DbTable_User();
		$instrument_table		= new Application_Model_DbTable_Instrument();
		
		$select_public = $db->select()
							->from($this->getDbTable()->getName())
							->join($user_table->getName(), 'tab_user = usr_id', array('usr_name'))
							->join($instrument_table->getName(), 'tab_instrument = ins_id', array('ins_name'))
							->where('tab_id = ?', $id)
							->where('tab_visibility = ?', MyTabCloud_Constants::VISIBILITY_PUBLIC);
		
		$select_friends = $db->select()
							->from($this->getDbTable()->getName())
							->join($friend_table->getName(), 'fri_user_1 = tab_user', array())
							->join($user_table->getName(), 'tab_user = usr_id', array('usr_name'))
							->join($instrument_table->getName(), 'tab_instrument = ins_id', array('ins_name'))
							->where('tab_id = ?', $id)
							->where('fri_user_2 = ?', $viewer_id)
							->where('fri_active = ?', true)
							->where('tab_visibility = ?', MyTabCloud_Constants::VISIBILITY_FRIENDS);
		
		
		$select_private = $db->select()
							->from($this->getDbTable()->getName())
							->join($user_table->getName(), 'tab_user = usr_id', array('usr_name'))
							->join($instrument_table->getName(), 'tab_instrument = ins_id', array('ins_name'))
							->where('tab_id = ?', $id)
							->where('tab_user = ?', $viewer_id)
							->where('tab_visibility IN (?)', array(MyTabCloud_Constants::VISIBILITY_FRIENDS,MyTabCloud_Constants::VISIBILITY_PRIVATE));
							
		
		$select_self	= $db->select()
							->from($this->getDbTable()->getName())
							->join($user_table->getName(), 'tab_user = usr_id', array('usr_name'))
							->join($instrument_table->getName(), 'tab_instrument = ins_id', array('ins_name'))
							->where('tab_id = ?', $id)
							->where('tab_user = ?', $viewer_id);
		
		if(!$edit) {
			$select = $db->select()
						->union(array($select_public,$select_friends,$select_private))
						->order('tab_id');
		} else {
			$select = $select_self;
		}			
		
		// Requête permettant de r�cup�rer une tablature par son ID
		$stmt = $db->query($select);
		$result = $stmt->fetchAll();	
        if (0 == count($result)) { return false; }
		
		// On met le résultat de la requ�te dans un objet Application_Model_Tab
        $row = $result[0];
		
		// Initialisation de l'objet qui va nous permettre de récupérer les notes de la tablature
		$noteMap = new Application_Model_NoteMapper();
		
		// Récupération du maximum
		$lastBeat = $noteMap->getLastBeat($id);
		if($lastBeat == "") { $lastBeat = 0; }
				
        $tab->setId($row['tab_id'])
			->setArtist($row['tab_artist'])
			->setTitle($row['tab_title'])
			->setNbStrings($row['tab_nb_strings'])
			->setCapo($row['tab_capo'])
			->setTuning($row['tab_tuning'])
			->setDescription($row['tab_desc'])
			->setInstrument($row['tab_instrument'])
			->setInstrumentName($row['ins_name'])
			->setContent($noteMap->findByTab($id))
			->setLastBeat($lastBeat)
			->setUser($row['tab_user'])
			->setUserName($row['usr_name'])
			->setVisibility($row['tab_visibility'])
			->setCreated($row['tab_created']);
		
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
				->setCapo($row->tab_capo)
				->setTuning($row->tab_tuning)
				->setDescription($row->tab_desc)
				->setInstrument($row->tab_instrument)
    			->setContent($row->tab_content)
    			->setUser($row->tab_user)
				->setVisibility($row->tab_visibility)
				->setCreated($row->tab_created);
            $entries[] = $entry;
        }
        return $entries;
	}
	
	public function findByUser($user_id, $viewer_id) {
	    $friend_table = new Application_Model_DbTable_Friendship();
		$db = $this->getDbTable()->getAdapter();
		
		$select_public = $this->getDbTable()->select()
							->where('tab_user = ?', $user_id)
							->where('tab_visibility = ?', MyTabCloud_Constants::VISIBILITY_PUBLIC);
		
		$select_friends = $db->select()
							->from($this->getDbTable()->getName())
							->join($friend_table->getName(), 'fri_user_1 = tab_user', array())
							->where('tab_user = ?', $user_id)
							->where('fri_user_2 = ?', $viewer_id)
							->where('fri_active = ?', true)
							->where('tab_visibility = ?', MyTabCloud_Constants::VISIBILITY_FRIENDS);
		
		
		$select_private = $this->getDbTable()->select()
							->where('tab_user = ?', $user_id)
							->where('tab_visibility IN (?)', array(MyTabCloud_Constants::VISIBILITY_FRIENDS,MyTabCloud_Constants::VISIBILITY_PRIVATE));
		
		if($user_id == $viewer_id) {
			$select = $db->select()
						->union(array($select_public,$select_friends,$select_private))
						->order('tab_id');
		} else {
			$select = $db->select()
						->union(array($select_public,$select_friends))
						->order('tab_id');
		}
						
		$stmt = $db->query($select);
		$resultSet = $stmt->fetchAll();		
		
        $entries   = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_Tab();
            $entry->setId($row['tab_id'])
				->setArtist($row['tab_artist'])
    			->setTitle($row['tab_title'])
    			->setNbStrings($row['tab_nb_strings'])
				->setCapo($row['tab_capo'])
				->setTuning($row['tab_tuning'])
				->setDescription($row['tab_desc'])
				->setInstrument($row['tab_instrument'])
    			->setUser($row['tab_user'])
				->setVisibility($row['tab_visibility'])
				->setCreated($row['tab_created']);
            $entries[] = $entry;
        }
        return $entries;
	}
	
	public function findByName($tab_name, $viewer_id) {
		// Adapter pour les jointures
		$db = $this->getDbTable()->getAdapter();
		
		$friend_table 			= new Application_Model_DbTable_Friendship();
		$user_table				= new Application_Model_DbTable_User();
		$instrument_table		= new Application_Model_DbTable_Instrument();
		
		$select_public = $db->select()
							->from($this->getDbTable()->getName())
							->join($user_table->getName(), 'tab_user = usr_id', array('usr_name'))
							->join($instrument_table->getName(), 'tab_instrument = ins_id', array('ins_name'))
							->where("tab_artist LIKE '%".$tab_name."%' OR tab_title LIKE '%".$tab_name."%'")
							->where('tab_visibility = ?', MyTabCloud_Constants::VISIBILITY_PUBLIC);
		
		$select_friends = $db->select()
							->from($this->getDbTable()->getName())
							->join($friend_table->getName(), 'fri_user_1 = tab_user', array())
							->join($user_table->getName(), 'tab_user = usr_id', array('usr_name'))
							->join($instrument_table->getName(), 'tab_instrument = ins_id', array('ins_name'))
							->where("tab_artist LIKE '%".$tab_name."%' OR tab_title LIKE '%".$tab_name."%'")
							->where('fri_user_2 = ?', $viewer_id)
							->where('fri_active = ?', true)
							->where('tab_visibility = ?', MyTabCloud_Constants::VISIBILITY_FRIENDS);
		
		
		$select_private = $db->select()
							->from($this->getDbTable()->getName())
							->join($user_table->getName(), 'tab_user = usr_id', array('usr_name'))
							->join($instrument_table->getName(), 'tab_instrument = ins_id', array('ins_name'))
							->where("tab_artist LIKE '%".$tab_name."%' OR tab_title LIKE '%".$tab_name."%'")
							->where('tab_user = ?', $viewer_id)
							->where('tab_visibility IN (?)', array(MyTabCloud_Constants::VISIBILITY_FRIENDS,MyTabCloud_Constants::VISIBILITY_PRIVATE));
		
		
		$select = $db->select()
					->union(array($select_public,$select_friends,$select_private))
					->order('tab_id');
				
		
		// Requête permettant de r�cup�rer une tablature par son ID
		$stmt = $db->query($select);
		$resultSet = $stmt->fetchAll();	
        if (0 == count($resultSet)) { return false; }
		
		$entries   = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_Tab();
            $entry->setId($row['tab_id'])
			->setArtist($row['tab_artist'])
			->setTitle($row['tab_title'])
			->setNbStrings($row['tab_nb_strings'])
			->setCapo($row['tab_capo'])
			->setTuning($row['tab_tuning'])
			->setDescription($row['tab_desc'])
			->setInstrument($row['tab_instrument'])
			->setInstrumentName($row['ins_name'])
			->setUser($row['tab_user'])
			->setUserName($row['usr_name'])
			->setVisibility($row['tab_visibility'])
			->setCreated($row['tab_created']);
            $entries[] = $entry;
        }
        return $entries;

	}
}

