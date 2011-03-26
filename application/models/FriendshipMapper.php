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
		$select = $this->getDbTable()->select()
				->from(array('n' => $this->getDbTable()->getName()), array('fri_active'))
				->where('fri_user_1 = ?', $user1)
				->where('fri_user_2 = ?', $user2);
		
		$stmt = $select->query();
		$result = $stmt->fetchAll();
				
		if(count($result) > 0) {
			if($result[0]->fri_active) {
				return MyTabCloud_Friendship::FRIENDSHIP;
			} else {
				return MyTabCloud_Friendship::PENDING_REQUEST;
			}
		} else {
			return MyTabCloud_Friendship::NO_FRIENDSHIP;
		}
		
	}

}

