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
     * Action par défaut : affiche une liste de tablatures
     */         
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
    
    /**
     * Action "create" : Crée une tablature
     */         
    public function createAction() 
    {     
        // action body
        if($this->_auth->hasIdentity()) {
            $this->view->logged = true;
            $this->view->username = $this->view->escape($this->_auth->getIdentity()->usr_name);
            
            $request = $this->getRequest();
             
             // Si le formulaire de création a été envoyé
             if ($request->isPost() && $request->getParam('formname') == 'createtab') {
             
                $this->view->display_form = false; 
             
                // On crée l'objet Tab
                $tab            = new Application_Model_Tab();
                $tab_content    = array();
                
                $tab_artist     = $request->getParam('artist');
                $tab_title      = $request->getParam('title');      
                
                // On va récupérer les valeurs de chaque note
                foreach($request->getParams() as $key => $value) {
                    // On récupère la note à laquelle cela correspond
                    $arr_key = explode("-", $key); // ["note", ligne, corde, temps]
                    
                    // Si il s'agit bien d'une note
                    if($arr_key[0] == "note") {
                        $beat = (NB_BEATS * (int)$arr_key[1]) + (int)$arr_key[3]; // récupération du temps
                        $string = $arr_key[2]; // récupération de la corde                                                             
                        // echo 'Array('.$string.','.$beat.') : ' . $value . '<br />';
                        $tab_content[$string][$beat] = $value;
                    }
                }
                 
                // On renseigne l'objet $tab qu'on va enregistrer           
                $tab->setArtist($tab_artist)
                    ->setTitle($tab_title)
                    ->setNbStrings(6)
                    ->setContent(serialize($tab_content))
                    ->setUser($this->_auth->getIdentity()->usr_id); 
                                    
                // On enregistre l'objet                                
                $mapper  = new Application_Model_TabMapper();
                $mapper->save($tab);
                
                $this->view->message = "Enregistrement OK";                  
                
                
             // Sinon on affiche le formulaire
             } else {
             
                $this->view->display_form = true;
                
                // Déclaration des compteurs pour l'affichage
                $ligne      = 0;
                $beat       = 0;
                $string     = 0;
                $cur_beat   = 0;
                
                $tab_display = "";   
                
                for ($ligne = 0 ; $ligne < NB_LINES ; $ligne++) {
                
                    $tab_display = $tab_display . '<div class="tab_line">';
        	        $tab_display = $tab_display . '<table class="tab" style="margin-left:20px;" border=0 cellspacing="0" cellpadding="0">';
                    
                    for($string = 0 ; $string < 6 ; $string++) {
                        $tab_display = $tab_display . '<tr>';
                        
                        for ($beat = 0 ; $beat < NB_BEATS ; $beat++) {
                            $tab_display = $tab_display .  '<td><input name="note-'.$ligne.'-'.$string.'-'.$beat.'" id="note-'.$ligne.'-'.$string.'-'.$beat.'" type="text" maxlength="3" size="2" /></td>';
                        }
                        
                        $tab_display = $tab_display . '</tr>';
                    }
                    
                    $tab_display = $tab_display . '</table>';
        	        $tab_display = $tab_display . '</div>';
                }
                   
                $this->view->tab_display = $tab_display;  
             }
        } else {
            $this->view->logged = false;
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
        
        $mapper->find($tab_id, $tab);
        
        $this->view->tab = $tab;
    }

}
