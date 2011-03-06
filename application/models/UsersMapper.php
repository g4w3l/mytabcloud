<?php

class Application_Model_UserMapper
{
	protected $_dbTable;
	
	public function save($model);
    public function find($id, $model);
    public function fetchAll();
	
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
			'usr_password' => $user->getPassword(),
			'usr_name' => $user->getName(),
			'usr_created' => $user->getCreated()			
		);
		
		// Vérification s'il s'agit d'un update ou d'un insert
		if (null === ($id = $guestbook->getId())) {
            unset($data['usr_id']);
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array('usr_id = ?' => $id));
        }
	}

}

