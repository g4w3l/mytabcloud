<?php

class SearchController extends Zend_Controller_Action
{

    public function init()
    {
 
    }

    public function indexAction()
    {
        $request = $this->getRequest();
        $form    = new Application_Form_Search();
		
		if ($request->isPost() && $request->getParam('formname') == 'searchform') {
			if ($form->isValid($request->getPost())) {
				// Recherche des utilisateurs
				$usermapper = new Application_Model_UserMapper();
				$users 		= $usermapper->findByName($request->getParam('q'));
				$this->view->users = $users;
				
				
				$this->view->results = true;
			}
		} 
    }


}

