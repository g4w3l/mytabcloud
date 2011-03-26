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

}

