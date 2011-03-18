<?php

class MyTabCloud_Tab_Display {
	
	public static function emptyTabForm($nbstrings = 6) {
		// Déclaration des compteurs pour l'affichage
        $ligne      = 0;
        $beat       = 0;
        $string     = 0;
        $cur_beat   = 0;
        
        $tab_display = "";   
        
        //for ($ligne = 0 ; $ligne < NB_LINES ; $ligne++) {
        
            $tab_display = $tab_display . '<div class="tab_line">';
	        $tab_display = $tab_display . '<table class="tab" id="tab_line_'.$ligne.'" cellspacing="0">';
            
            for($string = 0 ; $string < $nbstrings ; $string++) {
                $tab_display = $tab_display . '<tr>';
                //$tab_display = $tab_display . '<td class="tab_tuning">E4</td>';
                
                for ($beat = 0 ; $beat < NB_BEATS ; $beat++) {
                    $tab_display = $tab_display .  '<td><input name="note-'.$ligne.'-'.$string.'-'.$beat.'" id="note-'.$ligne.'-'.$string.'-'.$beat.'" type="text" maxlength="3" autocomplete="off" /></td>';
                }
                
                $tab_display = $tab_display . '</tr>';
            }
            
            $tab_display = $tab_display . '</table>';
	        $tab_display = $tab_display . '</div>';
        //}
		
		return $tab_display;
	}

	public static function displayTabForm($tab, $page = false, $readonly = true) {
		$tab_content 			= $tab->getContentAsAnArray();
    	$tab_display 			= "";
		$beat_line 				= 0;
		$beat_begin_line		= 0;
		$current_beat			= 0;

		if (!$page) {
			$countlines = count($tab_content[0])/(int)NB_BEATS;
		} else {
			$countlines = NB_LINES;
		}					
		// On va afficher la tablature    
		for ($ligne = 0 ; $ligne <  $countlines ; $ligne++) {
			// Pour chaque nouvelle ligne, on retient le premier beat
            $beat_begin_line = $current_beat;
			
			// On dessine une nouvelle ligne de tablature
            $tab_display = $tab_display . '<div class="tab_line">';
	        $tab_display = $tab_display . '<table class="tab" cellspacing="0">';
            
			// On va afficher chaque corde
            for($string = 0 ; $string < $tab->getNbStrings() ; $string++) {
            	// Pour chaque changement de corde, on se replace au premier beat de la ligne
            	$current_beat = $beat_begin_line;
                $tab_display = $tab_display . '<tr>';
                
				// Pour chaque temps on va afficher la valeur
                for ($beat_line = 0 ; $beat_line < (int)NB_BEATS ; $beat_line++) {
                		
					// Si on a dépassé le beat maximal de la tablature, on va afficher un beat vide
                	if($current_beat > count($tab_content[1])-1) {	
                		$notevalue = "";
					} else {
						$notevalue = $tab_content[$string][$current_beat];
					}
					
					// Si on est en lecture seule
					if($readonly) {
						$tab_display = $tab_display .  '<td><input name="note-'.$ligne.'-'.$string.'-'.$beat_line.'" id="note-'.$ligne.'-'.$string.'-'.$beat_line.'" value="' . $notevalue . '" type="text" maxlength="3" readonly /></td>';
                    } else {
                    	$tab_display = $tab_display .  '<td><input name="note-'.$ligne.'-'.$string.'-'.$beat_line.'" id="note-'.$ligne.'-'.$string.'-'.$beat_line.'" value="' . $notevalue . '" type="text" autocomplete="off" maxlength="3" /></td>';                    	
                    } 
					
					// On passe au beat suivant
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
