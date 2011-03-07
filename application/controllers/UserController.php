<?php

class UserController extends Zend_Controller_Action
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
    }

    /**
     * Action d'enregistrement d'un nouvel utilisateur
     * 
     * 
     */
    public function signupAction()
    {
        $request = $this->getRequest();
        $form    = new Application_Form_UserSignup();

        if ($request->isPost() && $request->getParam('formname') == 'signup') {
            if ($form->isValid($request->getPost())) {
                $comment = new Application_Model_User($form->getValues());
                $mapper  = new Application_Model_UserMapper();
                $mapper->save($comment);
                return $this->_helper->redirector('index');
			}
		}
             
    	$this->view->form = $form;
	}

    /**
     * Action de login
     */
    public function signinAction()
    {
        $db 	 = $this->_getParam('db');
		$request = $this->getRequest();
		$form    = new Application_Form_UserSignin();
		
		// Par défaut l'utilisateur n'est pas loggé
		$this->view->logged = false;
		$this->view->signupURL = $this->view->url(array('controller' => 'user', 'action' => 'signup'), 'default', true);
		
		// Si le formulaire de login a été posté
		if($this->getRequest()->isPost() && $request->getParam('formname') == 'signin') {
			// On vérifie que le formulaire est valide
			if($form->isValid($request->getPost())) {
				// On va authentifier l'utilisateur
				$adapter = new Zend_Auth_Adapter_DbTable(
					$db,
					'mtc_user',
					'usr_login',
					'usr_password',
					'MD5(?)'
				);
				
				$adapter->setIdentity($form->getValue('login'));
				$adapter->setCredential($form->getValue('password'));
				
				// Authentification
				$result = $this->_auth->authenticate($adapter);
				
				// Si l'authentification a réussi
				if($result->isValid()) {
					// On met à jour la session
					$this->_auth->getStorage()->write($res = $adapter->getResultRowObject(null, 'password'));
					Zend_Session::regenerateId();
					
					// Redirection vers la page d'accueil
					$this->_helper->_redirector('index', 'index');					
				} else {
					// Message affiché si l'authentification a échoué
					$this->view->message = '<div class="error">Incorrect login or password</div>';
				}
			}
		} 
		
		$logged = Zend_Auth::getInstance();
		if($logged->hasIdentity()) {
			$ident = $logged->getIdentity();
			$this->view->logged = true;	
			$this->view->username = $this->view->escape($ident->usr_name);
			$this->view->signoutURL = $this->view->url(array('controller' => 'user', 'action' => 'signout'), 'default', true);
		} else {
			$this->view->form = $form;
		}
    }

    public function signoutAction()
    {
        // Réinitialisation et destruction de la session, puis redirection vers la page d'accueil
		Zend_Auth::getInstance()->clearIdentity();
		Zend_Session::destroy();
		$this->_helper->_redirector('index', 'index');
    }


}







