/**
 * @author Gawel
 */

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
                        }
                        break;
                    // Up
                    case 38:
                        if($("#" + arrNote[0] + '-' + arrNote[1] + '-' + (parseInt(arrNote[2])-1) + '-' + arrNote[3]).length > 0) {
                            $("#" + arrNote[0] + '-' + arrNote[1] + '-' + (parseInt(arrNote[2])-1) + '-' + arrNote[3])[0].focus(); 
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
    
    $('input[name^="note"]').bind('focus', function() {this.select();})
    
    // Hack pour sélectionner l'input même sur les flèches gauche/droite
    $(document).bind('keyup', function(event) {
    	 if(event.target.getAttribute('name')) {
            // Si on est sur une note
            if(event.target.getAttribute('name').substring(0,4) == "note") {
            	switch (event.keyCode) {
                	// Left
                    case 37:
                        event.target.select();
                        break;
                    // Right
                    case 39:
                        event.target.select();
                        break;
                    default:
                        break;
               }
            }
         }
    });
}

window.onload = (function(){
	bindKeyEvents();
});
