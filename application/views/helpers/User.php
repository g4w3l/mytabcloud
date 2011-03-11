<?php
class Zend_View_Helper_User
{
	protected $_view;
 
	function setView($view)
	{
		$this->_view = $view;
	}
 
	function user()
	{
		$auth = Zend_Auth::getInstance();
		if($auth->hasIdentity()) {
			// Récupère l'identité de l'utilisateur
			$user        = $auth->getIdentity();
			$username    = $this->_view->escape($user->usr_login);
            $role = "";
            
            $link = $username;
        } else {
			// On retourne faux
			$link = false;
		}
 
		return $link;
	}
}