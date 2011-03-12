<?php

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    get_include_path(),
)));

// On ajoute l'espace de noms MyTabCloud
require_once 'Zend/Loader/AutoLoader.php';
$autoloader = Zend_Loader_Autoloader::getInstance();
$autoloader->registerNamespace('MyTabCloud_');

/** Zend_Application */
require_once 'Zend/Application.php';

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);

$acl_ini = APPLICATION_PATH . '/configs/acl.ini' ;  
$acl     = new MyTabCloud_Acl_Manager($acl_ini) ; 

// $auth est une r�f�rence vers Zend_Auth (getInstance())  
// $acl a �t� d�fini dans le chapitre pr�c�dent
$front = Zend_Controller_Front::getInstance();  
//$front->registerPlugin(new MyTabCloud_Plugin_Auth($acl)) ;  

// Réglage du timezone
date_default_timezone_set('Europe/Paris');


$application->bootstrap()
            ->run();
            
     