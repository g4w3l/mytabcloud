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

		$url = 'http://www.gravatar.com/avatar/';
		$url .= md5( strtolower( trim( $mail ) ) );
		$url .= "?s=" . $size . "&amp;d=" . GRAVATAR_DEFAULT . "&amp;r=" . GRATAVAR_RATING;			
		$url = '<img alt="' . $alt . '" src="' . $url . '" />';
		
		return $url;

    }
}
