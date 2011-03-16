<?php

class TabController extends Zend_Controller_Action
{
    private $_auth = null;
    
    public function init()
    {
        /* Initialize action controller here */
        $this->_auth = Zend_Auth::getInstance();
                
    }

    /**
     * Action par d�faut : affiche une liste de tablatures
     */         
    public function indexAction()
    {
        // Action
        $mapper  = new Application_Model_TabMapper();
        
        // Si l'utilisateur est loggé on récupère ses tablatures
        if($this->_auth->hasIdentity()) {
            // Récupération des tablatures
            $tabs    = $mapper->findByUser($this->_auth->getIdentity()->usr_id);
            $this->view->tabs = $tabs;        
        }
    }
    
    /**
     * Action "create" : Cr�e une tablature
     */         
    public function createAction() 
    {     
        // action body
        if($this->_auth->hasIdentity()) {
        	            
            $request = $this->getRequest();
			
			$params = array(
				'artist' 		=> $request->getParam('artist'),
				'title'			=> $request->getParam('title'),
				'nb_strings'	=> $request->getParam('nb_strings'),
				'capo'			=> $request->getParam('capo'),
				'tuning'		=> $request->getParam('tuning'),
			);
             
            // Si le formulaire de cr�ation a �t� envoy�
            if ($request->isPost() && $request->getParam('formname') == 'createtab') {
             
                $this->view->display_form = false; 
             
                // On crée l'objet Tab
                $tab            = new Application_Model_Tab();
                $tab_content    = array();
                
                // On va récupérer les valeurs de chaque note
                foreach($request->getParams() as $key => $value) {
                    // On récupère la note à laquelle cela correspond
                    $arr_key = explode("-", $key); // ["note", ligne, corde, temps]
                    
                    // Si il s'agit bien d'une note
                    if($arr_key[0] == "note") {
                        $beat = (NB_BEATS * (int)$arr_key[1]) + (int)$arr_key[3]; // récupération du temps
                        $string = $arr_key[2]; // récupération de la corde                                                             
                        
                        if($value != "") {
	                        $note_array = array(
								"string" 	=> $string,
								"beat" 		=> $beat,
								"fret"		=> $value
							);
							
							// On ajoute la note à la tablature
							array_push($tab_content, new Application_Model_Note($note_array));
						}                        
                    }
                }
                 
                // On renseigne l'objet $tab qu'on va enregistrer           
                $tab->setArtist($params['artist'])
                    ->setTitle($params['title'])
                    ->setNbStrings($params['nb_strings'])
					->setCapo($params['capo'])
					->setTuning($params['tuning'])
                    ->setContent($tab_content)
                    ->setUser($this->_auth->getIdentity()->usr_id); 
                                    
                // On enregistre l'objet                                
                $mapper  = new Application_Model_TabMapper();
                $mapper->save($tab);
                
                $this->view->message = "Enregistrement OK";                  
                
                
             // Sinon on affiche le formulaire
             } else {
                $this->view->display_form 	= true;
				$this->view->form_name 		= 'createtab';
				//$this->view->params			= $params;
                $this->view->tab_display 	= MyTabCloud_Tab_Display::emptyTabForm(DEFAULT_STRINGS);
             }
        }
    }
    
    /**
     * Action "display" : Affiche une tablature
     */   
    public function displayAction() {
        // Récupération du paramètre ID
        $tab_id = $this->_getParam("id");
                
        // Mapper pour récupérer l'entrée                
        $mapper  = new Application_Model_TabMapper();
        $tab     = new Application_Model_Tab();
        
        if($mapper->find($tab_id, $tab)) {
        	$this->view->has_tab	= true;
        	$this->view->artist 	= $tab->getArtist();
        	$this->view->title 		= $tab->getTitle();
        	
			$this->view->tab_display = MyTabCloud_Tab_Display::displayTabForm($tab);  
        	
        	
        } else {
        	$this->view->has_tab	= false;
        	$this->view->message = 'Tablature introuvable';
        }
        
        
    }
	
	/**
     * Action "display" : Affiche une tablature
     */   
    public function editAction() {
        // Récupération du paramètre ID
        $tab_id = $this->_getParam("id");
                
        // Mapper pour récupérer l'entrée                
        $mapper  = new Application_Model_TabMapper();
        $tab     = new Application_Model_Tab();
        
        if($mapper->find($tab_id, $tab)) {
        	$this->view->has_tab	= true;
        	$this->view->artist 	= $tab->getArtist();
        	$this->view->title 		= $tab->getTitle();
        	
			$this->view->tab_display = MyTabCloud_Tab_Display::displayTabForm($tab, true, false);  
        	
        	
        } else {
        	$this->view->has_tab	= false;
        	$this->view->message = 'Tablature introuvable';
        }
        
        
    }

}
