<?php

class UserController extends Zend_Controller_Action
{

    private $_auth = null;

    public function init()
    {
        /* Initialize action controller here */
        $this->_auth = Zend_Auth::getInstance();
		
		$ajaxContext = $this->_helper->getHelper('AjaxContext');
        $ajaxContext->addActionContext('askfriendship', 'html')
					->addActionContext('removefriendship', 'html')
					->addActionContext('acceptfriend', 'html')
					->addActionContext('declinefriend', 'html')
                    ->initContext();
    }

    public function indexAction()
    {
        // action body
		return $this->_forward('profile');
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
                $user = new Application_Model_User($form->getValues());
                $mapper  = new Application_Model_UserMapper();
                $mapper->save($user);
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
		
		$req_controller = $request->getParam('req_controller');
		$req_action 	= $request->getParam('req_action');
		
		// Par défaut l'utilisateur n'est pas loggé
		$this->view->signupURL    = $this->view->url(array('controller' => 'user', 'action' => 'signup'), 'default', true);
		$this->view->signoutURL   = $this->view->url(array('controller' => 'user', 'action' => 'signout'), 'default', true);
		
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
					if ($req_controller != "")  {
						$this->_helper->_redirector($req_action,$req_controller);
					} else {
						$this->_helper->_redirector('index', 'index');						
					}					
				} else {
					// Message affiché si l'authentification a échoué
					$this->view->loginMessage = '<div class="error">Incorrect login or password</div>';
				}
			}
		} 
		
		$logged = Zend_Auth::getInstance();
		if(!$logged->hasIdentity()) {
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
	
	public function profileAction() {
		// Récupération du paramètre ID
        $user_id = $this->_getParam("id");
		$this->view->selfProfile = false;
		
		// Si on a pas donné d'identifiant, on regarde son propre profil
		if ($this->_auth->hasIdentity()) {
			if($user_id == $this->_auth->getIdentity()->usr_id) $this->view->selfProfile = true;
            if($user_id == "") {
            	$user_id = $this->_auth->getIdentity()->usr_id;
				$this->view->selfProfile = true;
			} 
		}
		
		// On récupère l'identifiant du visualisateur, 0 si il n'est pas loggé
		if($this->_auth->hasIdentity()) {
			$viewer_id = $this->_auth->getIdentity()->usr_id;
		} else {
			$viewer_id = 0;
		}
		
		if($user_id != "") {				
			$mapper  = new Application_Model_UserMapper();
	        $user    = new Application_Model_User();
						
			if(!$mapper->find($user_id, $user)) {
	        	throw new Zend_Controller_Action_Exception('Document non trouvé', 404);
	        } else {
				
				$this->view->friendcount = $mapper->retrieveFriends($user);				
				$this->view->has_user = true;
				$this->view->userobj = $user;
				
				$userArray['Login'] = $user->getLogin();
				$userArray['E-Mail'] = $user->getMail();
				$userArray['Location'] = $user->getLocation();
				$userArray['Member since'] = $user->getCreated();
				
				$this->view->userArray = $userArray;
				
				// On va récupérer les tablatures visibles
				$tabmapper  = new Application_Model_TabMapper();
				
				// Récupération des tablatures
				$tabs    = $tabmapper->findByUser($user_id, $viewer_id);
				$this->view->tabs = $tabs;        
			}
		} else {
	        throw new Zend_Controller_Action_Exception('Document non trouvé', 404);
		}
		
	}
	
	public function editAction() {

		// Si on a pas donné d'identifiant, on regarde son propre profil
		if ($this->_auth->hasIdentity()) $user_id = $this->_auth->getIdentity()->usr_id;
        		
		if($user_id != "") {				
			$mapper  = new Application_Model_UserMapper();
	        $user    = new Application_Model_User();
			
			if(!$mapper->find($user_id, $user)) {
	        	throw new Zend_Controller_Action_Exception('user - edit - utilisateur non trouvé', 404);
	        } else {
				$this->view->has_user = true;
				$this->view->user = $user;
			}
		} else {
	        throw new Zend_Controller_Action_Exception('user - edit - non connecté', 404);
		}
	}
	
	public function askfriendshipAction() {
		$friend = $this->_getParam("friend");
		$message = "";
		
		if($friend != "") {
			if ($this->_auth->hasIdentity()) {
				if(MyTabCloud_Friendship::friendshipRequested($this->_auth->getIdentity()->usr_id, $friend) == MyTabCloud_Friendship::NO_FRIENDSHIP) {
					MyTabCloud_Friendship::askFriendship($this->_auth->getIdentity()->usr_id, $friend);
					$message = "Friendship request sent";
				}
			} else {
				//throw new Zend_Controller_Action_Exception('user - friendship - non connecté', 404);
				$message = "An error has occured";
			}
		} else {
			//throw new Zend_Controller_Action_Exception('user - friendship - friend non entré', 404);
			$message = "An error has occured";
		}
		
		$this->view->message = $message;
	}
	
	public function removefriendshipAction() {
		$friend = $this->_getParam("friend");
		$message = "";
		
		if($friend != "") {
			if ($this->_auth->hasIdentity()) {
				if(MyTabCloud_Friendship::friendshipRequested($this->_auth->getIdentity()->usr_id, $friend) == MyTabCloud_Friendship::FRIENDSHIP) {
					MyTabCloud_Friendship::removeFriendship($this->_auth->getIdentity()->usr_id, $friend);
					$message = "You are not friends anymore";
				}
			} else {
				$message = "An error has occured";
				//throw new Zend_Controller_Action_Exception('user - friendship - non connecté', 404);
			}
		} else {
			$message = "An error has occured";
			//throw new Zend_Controller_Action_Exception('user - friendship - friend non entré', 404);
		}
		
		$this->view->message = $message;
	}
	
	public function acceptfriendAction() {
		$friend = $this->_getParam("friend");
		$message = "";
		
		if($friend != "") {
			if ($this->_auth->hasIdentity()) {
				if(MyTabCloud_Friendship::friendshipRequested($this->_auth->getIdentity()->usr_id, $friend) == MyTabCloud_Friendship::FRIENDSHIP_REQUESTED) {
					MyTabCloud_Friendship::acceptFriendship($this->_auth->getIdentity()->usr_id, $friend);
					$message = "You are now friends";
				}
			} else {
				$message = "An error has occured";
				//throw new Zend_Controller_Action_Exception('user - friendship - non connecté', 404);
			}
		} else {
			$message = "An error has occured";
			//throw new Zend_Controller_Action_Exception('user - friendship - friend non entré', 404);
		}
		
		$this->view->message = $message;
	}
	
	public function declinefriendAction() {
		$friend = $this->_getParam("friend");
		$message = "";
		
		if($friend != "") {
			if ($this->_auth->hasIdentity()) {
				if(MyTabCloud_Friendship::friendshipRequested($this->_auth->getIdentity()->usr_id, $friend) == MyTabCloud_Friendship::FRIENDSHIP_REQUESTED) {
					MyTabCloud_Friendship::declineFriendship($this->_auth->getIdentity()->usr_id, $friend);
					$message = "You declined the friend request";
				}
			} else {
				$message = "An error has occured";
				//throw new Zend_Controller_Action_Exception('user - friendship - non connecté', 404);
			}
		} else {
			$message = "An error has occured";
			//throw new Zend_Controller_Action_Exception('user - friendship - friend non entré', 404);
		}
		
		$this->view->message = $message;
	}

}







