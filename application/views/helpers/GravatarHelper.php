<?php 
class Zend_View_Helper_GravatarHelper
{   
    protected $_view;
 
	function setView($view)
	{
		$this->_view = $view;
	}
	
	function gravatarHelper($size = GRAVATAR_SIZE, $mail = '', $alt = '') {     
		
		$auth = Zend_Auth::getInstance();
		if($auth->hasIdentity()) {
			// R�cup�re l'identit� de l'utilisateur
			if($mail == '') {
				$user        = $auth->getIdentity();
				$username    = $this->_view->escape($user->usr_login);
				$mail		 = $user->usr_mail;
			}
		
			$url = 'http://www.gravatar.com/avatar/';
			$url .= md5( strtolower( trim( $mail ) ) );
			$url .= "?s=" . $size . "&amp;d=" . GRAVATAR_DEFAULT . "&amp;r=" . GRATAVAR_RATING;			
			$url = '<img alt="' . $alt . '" src="' . $url . '" alt="Gravatar" />';
			
			return $url;
		} else {
			return "";
		}

    }
}
