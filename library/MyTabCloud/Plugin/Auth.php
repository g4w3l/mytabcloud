<?php
/**
 * Plugin d'authentification
 * 
 * Largement inspir� de :
 * http://julien-pauli.developpez.com/tutoriels/zend-framework/atelier/auth-http/?page=modele-MVC
**/

class MyTabCloud_Plugin_Auth extends Zend_Controller_Plugin_Abstract	{
	/**
	 * @var Zend_Auth instance 
	 */
	private $_auth;
	
	/**
	 * @var Zend_Acl instance 
	 */
	private $_acl;
	
	/**
	 * Chemin de redirection lors de l'�chec d'authentification
	 */
	const FAIL_AUTH_MODULE     = 'default';
	const FAIL_AUTH_ACTION     = 'signin';
	const FAIL_AUTH_CONTROLLER = 'user';
	
	/**
	 * Chemin de redirection lors de l'�chec de contr�le des privil�ges
	 */
	const FAIL_ACL_MODULE     = 'default';
	const FAIL_ACL_ACTION     = 'privileges';
	const FAIL_ACL_CONTROLLER = 'error';
	
	/**
	 * Constructeur
	 */
	public function __construct(Zend_Acl $acl)	{
		$this->_acl  = $acl ;
		$this->_auth = Zend_Auth::getInstance() ;
	}
	
	/**
	 * V�rifie les autorisations
	 * Utilise _request et _response h�rit�s et inject�s par le FC
	 */
	public function preDispatch(Zend_Controller_Request_Abstract $request)	{
		// is the user authenticated
		if ($this->_auth->hasIdentity()) {
		  // yes ! we get his role
		  $user = $this->_auth->getIdentity();
		  $role = $user->usr_role;
		} else {
		  // no = guest user
		  $role = 'guest';
		}
		
		$module 	= $request->getModuleName() ;
		$controller = $request->getControllerName() ;
		$action     = $request->getActionName() ;
		
		$front = Zend_Controller_Front::getInstance() ;
		$default = $front->getDefaultModule() ;
		
		// compose le nom de la ressource
		if ($module == $default)	{
			$resource = $controller ;
		} else {
			$resource = $module.'_'.$controller ;
		}
    
		// est-ce que la ressource existe ?
		if (!$this->_acl->has($resource)) {
		  $resource = null;
		}
		
		// contr�le si l'utilisateur est autoris�
		if (!$this->_acl->isAllowed($role, $resource, $action)) {
			// l'utilisateur n'est pas autoris� � acc�der � cette ressource
			// on va le rediriger
			if (!$this->_auth->hasIdentity()) {
				// il n'est pas identifi� -> module de login
				$module = self::FAIL_AUTH_MODULE ;
				$controller = self::FAIL_AUTH_CONTROLLER ;
				$action = self::FAIL_AUTH_ACTION ;
			} else {
				// il est identifi� -> error de privil�ges
				$module = self::FAIL_ACL_MODULE ;
				$controller = self::FAIL_ACL_CONTROLLER ;
				$action = self::FAIL_ACL_ACTION ;
			}
		}

		$request->setParam('req_controller', $request->getControllerName());
		$request->setParam('req_action', $request->getActionName());
		$request->setModuleName($module) ;
		$request->setControllerName($controller) ;
		$request->setActionName($action) ;
		
	}
}