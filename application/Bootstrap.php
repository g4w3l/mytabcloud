<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    
    protected function _initDoctype()
    {
        $this->bootstrap('view');
        $view = $this->getResource('view');
        $view->doctype('XHTML1_STRICT');
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

