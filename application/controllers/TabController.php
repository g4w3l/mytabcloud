<?php

class TabController extends Zend_Controller_Action
{
    private $_auth = null;
    
    public function init()
    {
        /* Initialize action controller here */
        $this->_auth = Zend_Auth::getInstance();
                
    }

    public function indexAction()
    {
        // action body
        if($this->_auth->hasIdentity()) {
            $this->view->logged = true;
            $this->view->username = $this->view->escape($this->_auth->getIdentity()->usr_name);
        } else {
            $this->view->logged = false;
        }
    }
    
    public function createAction() 
    {
        
    }

}
