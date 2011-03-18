<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    
    protected function _initDoctype()
    {
        $this->bootstrap('view');
        $view = $this->getResource('view');
        $view->doctype('XHTML1_STRICT');
    }
    
	/**
	 * @return Zend_Navigation
	 */
	protected function _initNavigation()    {
	    $view = $this->bootstrap('layout')->getResource('layout')->getView();
	    $config = new Zend_Config_Xml(APPLICATION_PATH . '/configs/navigation.xml', 'nav');
	    $view->navigation(new Zend_Navigation($config));
	}

    // Initialisation des constantes
    protected function setconstants($constants){
        foreach ($constants as $key=>$value){
            if(!defined($key)){
                define($key, $value);
            }
        }
    }
    
}

