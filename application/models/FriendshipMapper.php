<?php

class Application_Model_FriendshipMapper
{
	protected $_dbTable;
		
	public function setDbTable($dbTable) {
        if (is_string($dbTable)) { $dbTable = new $dbTable(); }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) { throw new Exception('Invalid table data gateway provided'); }
        $this->_dbTable = $dbTable;
        return $this;
	}
 
    public function getDbTable() {
        if (null === $this->_dbTable) { $this->setDbTable('Application_Model_DbTable_Friendship'); }
        return $this->_dbTable;
    }
    
    public function ask($user1, $user2) {
		// Objet à sauvegarder
		// champ de table -> attribut de l'objet
		$data = array(
			'fri_user_1' => $user1,
			'fri_user_2' => $user2,
			'fri_active' => false,
			'fri_ask_date' => date('Y-m-d H:i:s')
		);
		
		// Vérification s'il s'agit d'un update ou d'un insert
		$this->getDbTable()->insert($data);        
	}
	
	public function fetchStatus($user1, $user2) {
		// Recherche d'une amitié à partir de l'user 1 vers l'user 2
		$select = $this->getDbTable()->select()
				->from(array('n' => $this->getDbTable()->getName()), array('fri_active'))
				->where('fri_user_1 = ?', $user1)
				->where('fri_user_2 = ?', $user2);
		
		$stmt = $select->query();
		$result = $stmt->fetchAll();
		
		// Si une amitié, activée ou non existe
		if(count($result) > 0) {
			// Si l'amitié est active alors ils sont amis
			if($result[0]['fri_active']) {
				return MyTabCloud_Friendship::FRIENDSHIP;
			} else {
				// Sinon une demande d'amitié est en cours de user 1 vers user 2
				return MyTabCloud_Friendship::PENDING_REQUEST;
			}
		} else {
			// Aucune amitié de user 1 vers user 2 existe, on vérifie si user 2 n'a
			// pas effectué une demande d'amitié vers user 1
			$select = $this->getDbTable()->select()
				->from(array('n' => $this->getDbTable()->getName()), array('fri_active'))
				->where('fri_user_1 = ?', $user2)
				->where('fri_user_2 = ?', $user1)
				->where('fri_active = ?', false);
		
			$stmt = $select->query();
			$result = $stmt->fetchAll();
			
			// Si un enregistrement existe, c'est que user 2 a fait une demande d'amitié à user 1
			if(count($result) > 0) {
				return MyTabCloud_Friendship::FRIENDSHIP_REQUESTED;
			} else {
				// Sinon ils ne sont pas amis du tout
				return MyTabCloud_Friendship::NO_FRIENDSHIP;
			}
		}
		
	}

}

