<?php 
class Zend_View_Helper_GravatarHelper
{   
    protected $_view;
 
	function setView($view)
	{
		$this->_view = $view;
	}
	
	function gravatarHelper() {     
		
		$auth = Zend_Auth::getInstance();
		if($auth->hasIdentity()) {
			// Récupère l'identité de l'utilisateur
			$user        = $auth->getIdentity();
			$username    = $this->_view->escape($user->usr_login);
		
			$url = 'http://www.gravatar.com/avatar/';
			$url .= md5( strtolower( trim( $user->usr_mail ) ) );
			$url .= "?s=" . GRAVATAR_SIZE . "&d=" . GRAVATAR_DEFAULT . "&r=" . GRATAVAR_RATING;			
			$url = '<img src="' . $url . '" />';
			
			return $url;
		} else {
			return "";
		}

    }
}
