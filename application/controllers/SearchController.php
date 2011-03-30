<?php

class SearchController extends Zend_Controller_Action
{
	private $_auth = null;

    public function init()
    {
		/* Initialize action controller here */
        $this->_auth = Zend_Auth::getInstance();
    }

    public function indexAction()
    {
        $request = $this->getRequest();
        $form    = new Application_Form_Search();
		$this->view->q = "";
		
		if ($request->isPost() && $request->getParam('formname') == 'searchform') {
			if ($form->isValid($request->getPost())) {
				// On récupère l'identifiant du visualisateur, 0 si il n'est pas loggé
				if($this->_auth->hasIdentity()) {
					$viewer_id = $this->_auth->getIdentity()->usr_id;
				} else {
					$viewer_id = 0;
				}
				
				// Recherche des utilisateurs
				$usermapper = new Application_Model_UserMapper();
				$users 		= $usermapper->findByName($request->getParam('q'));
				$this->view->users = $users;
				
				// Recherche des tablatures
				$tabmapper 	= new Application_Model_TabMapper();
				$tabs 		= $tabmapper->findByName($request->getParam('q'), $viewer_id);
				$this->view->tabs = $tabs;			
				
				$this->view->results = true;
				$this->view->q = $request->getParam('q');
			}
		} 
		
		
    }


}

