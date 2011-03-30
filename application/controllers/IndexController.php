<?php

class IndexController extends Zend_Controller_Action
{
	protected $_flashMessenger = null;

    public function init()
    {
        /* Initialize action controller here */
		$this->_flashMessenger = $this->_helper
                                      ->getHelper('FlashMessenger');
    }

    public function indexAction()
    {
        // action body
		 $this->view->messages = $this->_flashMessenger->getMessages();
    }


}

