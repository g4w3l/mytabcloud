<?php
class Zend_View_Helper_UserMail
{
	protected $_view;
 
	function setView($view)
	{
		$this->_view = $view;
	}
 
	function userMail()
	{
		$auth = Zend_Auth::getInstance();
		if($auth->hasIdentity()) {
			// Récupère l'identité de l'utilisateur
			$user        = $auth->getIdentity();
			$usermail    = $this->_view->escape($user->usr_mail);
            
            $mail = $usermail;
        } else {
			// On retourne faux
			$mail = false;
		}
 
		return $mail;
	}
}