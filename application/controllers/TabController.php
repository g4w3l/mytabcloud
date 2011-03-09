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
         $request = $this->getRequest();
         
         // Si le formulaire de création a été envoyé
         if ($request->isPost() && $request->getParam('formname') == 'createtab') {
            
            $tab = new Application_Model_Tab();
            
            
         // Sinon on affiche le formulaire
         } else {
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
    }

}
