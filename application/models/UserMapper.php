<?php

class Application_Model_UserMapper
{
	protected $_dbTable;
		
	public function setDbTable($dbTable) {
        if (is_string($dbTable)) { $dbTable = new $dbTable(); }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) { throw new Exception('Invalid table data gateway provided'); }
        $this->_dbTable = $dbTable;
        return $this;
	}
 
    public function getDbTable() {
        if (null === $this->_dbTable) { $this->setDbTable('Application_Model_DbTable_User'); }
        return $this->_dbTable;
    }
	
	public function save(Application_Model_User $user) {
		// Objet à sauvegarder
		// champ de table -> attribut de l'objet
		$data = array(
			'usr_login' => $user->getLogin(),
			'usr_mail' => $user->getMail(),
			'usr_password' => md5($user->getPassword()),
			'usr_name' => $user->getName(),
			'usr_location' => $user->getLocation(),
			'usr_created' => date('Y-m-d H:i:s'),
			'usr_role' => $user->getRole()			
		);
		
		// Vérification s'il s'agit d'un update ou d'un insert
		if (null === ($id = $user->getId())) {
            unset($data['usr_id']);
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array('usr_id = ?' => $id));
        }
	}
	
	public function find($id, Application_Model_User $user) {
		// Requête permettant de récupérer un utilisateur par son ID
		$result = $this->getDbTable()->find($id);
        if (0 == count($result)) { return; }
		
		// On met le résultat de la requête dans un objet Application_Model_User
        $row = $result->current();
        $user->setId($row->usr_id)
			 ->setLogin($row->usr_login)
			 ->setPassword($row->usr_password)
			 ->setName($row->usr_name)
			 ->setLocation($row->usr_location)
			 ->setCreated($row->usr_created)
			 ->setMail($row->usr_mail)
			 ->setRole($row->usr_role);
		
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
            $entry = new Application_Model_User();
            $entry->setId($row->usr_id)
				 ->setLogin($row->usr_login)
				 ->setPassword($row->usr_password)
				 ->setName($row->usr_name)
				 ->setLocation($row->usr_location)
				 ->setCreated($row->usr_created)
				 ->setMail($row->usr_mail)
				 ->setRole($row->usr_role);
            $entries[] = $entry;
        }
        return $entries;
	}
	
	public function retrieveFriends(Application_Model_User $user) {
		// Adapter pour les jointures
		$db = $this->getDbTable()->getAdapter();
		$friend_table 			= new Application_Model_DbTable_Friendship();
		
		$select = $db->select()
					->from($this->getDbTable()->getName(), array('usr_id', 'usr_name', 'usr_mail'))
					->join($friend_table->getName(), 'fri_user_2 = usr_id', array())
					->where('fri_user_1 = ?', $user->getId())
					->where('fri_active = ?', true);
		
		// Requête permettant de r�cup�rer une tablature par son ID
		$stmt = $db->query($select);
		$resultSet = $stmt->fetchAll();
		
		$entries   = array();
		
		foreach ($resultSet as $row) {
            $entry = array();
			$entry['id'] 	= $row['usr_id'];
            $entry['name'] 	= $row['usr_name'];
			$entry['mail'] 	= $row['usr_mail'];
            $entries[] 		= $entry;
        }
				
		$user->setFriends($entries);		
        return count($resultSet);
	}
}

