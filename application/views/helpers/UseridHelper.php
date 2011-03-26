<?php 
class Zend_View_Helper_UseridHelper
{   
    protected $_view;
 
	function setView($view)
	{
		$this->_view = $view;
	}
	
	function useridHelper() {     
		
		$auth = Zend_Auth::getInstance();
		if($auth->hasIdentity()) {
			return $auth->getIdentity()->usr_id;			
		} else {
			return "";
		}

    }
}
