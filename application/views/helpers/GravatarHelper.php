<?php 
class Zend_View_Helper_GravatarHelper
{   
    protected $_view;
 
	function setView($view)
	{
		$this->_view = $view;
	}
	
	function gravatarHelper($size = GRAVATAR_SIZE) {     
		
		$auth = Zend_Auth::getInstance();
		if($auth->hasIdentity()) {
			// R�cup�re l'identit� de l'utilisateur
			$user        = $auth->getIdentity();
			$username    = $this->_view->escape($user->usr_login);
		
			$url = 'http://www.gravatar.com/avatar/';
			$url .= md5( strtolower( trim( $user->usr_mail ) ) );
			$url .= "?s=" . $size . "&amp;d=" . GRAVATAR_DEFAULT . "&amp;r=" . GRATAVAR_RATING;			
			$url = '<img src="' . $url . '" alt="Gravatar" />';
			
			return $url;
		} else {
			return "";
		}

    }
}
