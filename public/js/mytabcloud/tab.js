/**
 * @author Gawel
 */
 
function bindKeyEvents() {
	//$('input[name^="note"]').val('1');
	$('input[name^="note"]').bind('keypress', function() {alert("OK");});
}

window.onload = (function(){
	bindKeyEvents();
});
