/**
 * @author Gawel
 */

function fctUp(id) { $(id)[0].value = (parseInt($(id)[0].value))+1; $(id).change(); }
function fctDown(id) {$(id)[0].value = (parseInt($(id)[0].value))-1; $(id).change(); }

/**
 * Fonction qui va associer les actions des appuis sur les flèches pour se
 * déplacer dans la tablature
 */
function bindKeyEvents() {
	// On keydown : on change d'input
	$(document).bind('keydown', function(event) {
		// Si on est sur un objet qui a un attribut "name"
        if(event.target.getAttribute('name')) {
            // Si on est sur une note
            if(event.target.getAttribute('name').substring(0,4) == "note") {
                // 0 : "note" - 1 : ligne - 2 : string - 3 : beat
                var arrNote = event.target.getAttribute('name').split("-");
                switch (event.keyCode) {
                	// Down
                    case 40:
                        if($("#" + arrNote[0] + '-' + arrNote[1] + '-' + (parseInt(arrNote[2])+1) + '-' + arrNote[3]).length > 0) {
                            $("#" + arrNote[0] + '-' + arrNote[1] + '-' + (parseInt(arrNote[2])+1) + '-' + arrNote[3])[0].focus(); 
                        } else {
                            if($("#" + arrNote[0] + '-' + (parseInt(arrNote[1])+1) + '-0-' + arrNote[3]).length > 0) {
                                $("#" + arrNote[0] + '-' + (parseInt(arrNote[1])+1) + '-0-' + arrNote[3]).focus();
                            }
                        }
                        break;
                    // Up
                    case 38:
                        if($("#" + arrNote[0] + '-' + arrNote[1] + '-' + (parseInt(arrNote[2])-1) + '-' + arrNote[3]).length > 0) {
                            $("#" + arrNote[0] + '-' + arrNote[1] + '-' + (parseInt(arrNote[2])-1) + '-' + arrNote[3])[0].focus(); 
                        } else {
                            if($("#" + arrNote[0] + '-' + (parseInt(arrNote[1])-1) + '-' + (parseInt($('#nb_strings')[0].value)-1) + '-' + arrNote[3]).length > 0) {
                                $("#" + arrNote[0] + '-' + (parseInt(arrNote[1])-1) + '-' + (parseInt($('#nb_strings')[0].value)-1) + '-' + arrNote[3]).focus();
                            }
                        }
                        break;
                    // Left
                    case 37:
                        if($("#" + arrNote[0] + '-' + arrNote[1] + '-' + arrNote[2] + '-' + (parseInt(arrNote[3])-1)).length > 0) {
                            $("#" + arrNote[0] + '-' + arrNote[1] + '-' + arrNote[2] + '-' + (parseInt(arrNote[3])-1))[0].focus(); 
                        }
                        break;
                    // Right
                    case 39:
                        if($("#" + arrNote[0] + '-' + arrNote[1] + '-' + arrNote[2] + '-' + (parseInt(arrNote[3])+1)).length > 0) {
                            $("#" + arrNote[0] + '-' + arrNote[1] + '-' + arrNote[2] + '-' + (parseInt(arrNote[3])+1))[0].focus(); 
                        }
                        break;
                    default:
                        break;
                }
            }
        }
    });
        
    // Hack pour sélectionner l'input même sur les flèches gauche/droite
    $(document).bind('keyup', function(event) {
    	 if(event.target.getAttribute('name')) {
            // Si on est sur une note
            if(event.target.getAttribute('name').substring(0,4) == "note") {
            	switch (event.keyCode) {
            	    // Down
                    case 40:
                        event.target.select();
                        break;
                	// Left
                    case 37:
                        event.target.select();
                        break;
                    // Right
                    case 39:
                        event.target.select();
                        break;
                    // Up
                    case 38:
                        event.target.select();
                        break;
                    default:
                        break;
               }
            }
         }
    });
}

/**
 * Fonction qui ajoute une nouvelle ligne de tablature
 * vide 
 */ 
function addTabLine() {
    //var nbBeats = 30; Le nombre de beats par ligne est valorisé par application.ini
    // TODO : Passer le nombre de cordes en paramètres
    var nbStrings = $("#nb_strings")[0].value;  // Le nombre de cordes est la valeur donnée par l'input
    
    
    var nbLine = $(".tab_line").length; // On récupère le nombre de lignes existantes
    
    var newDiv      = $('<div>').addClass('tab_line').attr({'style' : 'display:none;'});
    var newTable    = $('<table>').addClass('tab').attr({'cellspacing' : '0',
    														'id':'tab_line_' + nbLine});
                
    // Pour chaque corde on va créer une ligne                
    for(var string = 0 ; string < nbStrings ; string++) {
        var newTR = $('<tr>');
        
        // Pour chaque temps on crée une cellule et un input dedans 
        for(var beat = 0 ; beat < NB_BEATS ; beat++) {
            newTD       = $('<td>');   
            // Création de l'input avec les attributs associés
            newInput    = $('<input>').attr({
                                    name: 'note-' + nbLine + '-' + string + '-' + beat,
                                    id: 'note-' + nbLine + '-' + string + '-' + beat,
                                    value: '',
                                    type: 'text',
                                    maxlength: '3'});
                                                        
            newTD.append(newInput);
            newTR.append(newTD);
        }
        newTable.append(newTR);
    }
    newDiv.append(newTable);   
     
    // On ajoute la ligne de tablature au div
    $('#tab_display').append(newDiv);
    newDiv.show('slow');
}

function setNbStrings(nbStrings) {
    var dispLines = $("table.tab");
        
    //alert(dispLines.length);
    for(var curLine = 0 ; curLine < dispLines.length ; curLine++) {
        //alert(dispLines[curLine].children());
        var dispTable = dispLines[curLine].childNodes.item(0);
        //alert(dispTable.childNodes.length);
        if(dispTable.childNodes.length > nbStrings) {
	        while(dispTable.childNodes.length > nbStrings) {
	            deletedString = dispTable.lastChild;
	            dispTable.removeChild(deletedString);
	        }
		} else {
			// Pour chaque ligne manquante
			for(var string = dispTable.childNodes.length ; string < nbStrings ; string++) {
				// On va créer une nouvelle ligne
				var newTR = $('<tr>');
        
		        // Pour chaque temps on crée une cellule et un input dedans 
		        for(var beat = 0 ; beat < NB_BEATS ; beat++) {
		            newTD       = $('<td>');   
		            // Création de l'input avec les attributs associés
		            newInput    = $('<input>').attr({
		                                    name: 'note-' + curLine + '-' + string + '-' + beat,
		                                    id: 'note-' + curLine + '-' + string + '-' + beat,
		                                    value: '',
		                                    type: 'text',
		                                    maxlength: '3'});
		                                                        
		            newTD.append(newInput);
		            newTR.append(newTD);
		        }
		        
		        $('#tab_line_'+curLine).append(newTR);	
			}
		}
    }
}



window.onload = (function(){
	bindKeyEvents();
	$('#nb_strings').change(function() { setNbStrings($("#nb_strings")[0].value); });
});
