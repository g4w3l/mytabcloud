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
	    $view 	= $this->bootstrap('layout')->getResource('layout')->getView();
	    $config = new Zend_Config_Xml(APPLICATION_PATH . '/configs/navigation.xml', 'nav');
	    $view->navigation(new Zend_Navigation($config));
	}
	
	protected function _initRoute() {
		$front 	= $this->bootstrap('FrontController')->getResource('FrontController');
		$router = $front->getRouter();
		
		// Ajout de la route pour les permalinks de visualisation des tablatures
		$routeRegex = new Zend_Controller_Router_Route_Regex('viewtab/(\d+)-([a-zA-Z0-9_]+)', array('controller' => 'tab', 'action' => 'display'), array(1 => 'id',2=>'name'),'viewtab/%d-%s');
		$router->addRoute('viewtab', $routeRegex);
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

