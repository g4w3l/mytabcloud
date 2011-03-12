<?php

class MyTabCloud_Tab_Display {
	
	public static function emptyTabForm() {
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
		
		return $tab_display;
	}

	public static function displayTabForm($tab) {
		$tab_content 			= $tab->getContentAsAnArray();
    	$tab_display 			= "";
		$beat_line 				= 0;
		$beat_begin_line		= 0;
		$current_beat			= 0;
						
		// On va afficher la tablature
		for ($ligne = 0 ; $ligne < count($tab_content[0])/(int)NB_BEATS ; $ligne++) {
			// Pour chaque nouvelle ligne, on retient le premier beat
            $beat_begin_line = $current_beat;
			
			// On dessine une nouvelle ligne de tablature
            $tab_display = $tab_display . '<div class="tab_line">';
	        $tab_display = $tab_display . '<table class="tab" style="margin-left:20px;" border=0 cellspacing="0" cellpadding="0">';
            
			// On va afficher chaque corde
            for($string = 0 ; $string < $tab->getNbStrings() ; $string++) {
            	// Pour chaque changement de corde, on se replace au premier beat de la ligne
            	$current_beat = $beat_begin_line;
                $tab_display = $tab_display . '<tr>';
                
				// Pour chaque temps on va afficher la valeur
                for ($beat_line = 0 ; $beat_line < (int)NB_BEATS ; $beat_line++) {
                    $tab_display = $tab_display .  '<td><input name="note-'.$ligne.'-'.$string.'-'.$current_beat.'" id="note-'.$ligne.'-'.$string.'-'.$current_beat.'" value="' . $tab_content[$string][$current_beat] . '" type="text" maxlength="3" size="2" /></td>';
					$current_beat = $current_beat + 1;
                }
                
                $tab_display = $tab_display . '</tr>';
            }
            
            $tab_display = $tab_display . '</table>';
	        $tab_display = $tab_display . '</div>';
        }

		return $tab_display;
		
	}
	
}    
