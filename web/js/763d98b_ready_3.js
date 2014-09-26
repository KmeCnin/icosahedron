$(document).ready(function() {
    
    // Initialisation des tooltips
    $('[data-toggle="tooltip"]').tooltip({placement: 'top'});
    
    
    // Initialisation des pop-hover
    $('.preview').each(function() {
	   $(this).attr('data-toggle', 'popover');
	   $(this).attr('title', $(this).html());
	   $(this).attr('data-content', '<img src="'+assets+'images/ajax-loader.gif" alt="Chargement..." />');
	   $(this).popover({placement: 'top', html: true, trigger: 'hover'});
    });
    // Gestion de l'affichage des données en ajax
    $('.preview').hover(function() {
	   $.get($(this).attr('href'), function() {
		  
	   });
    });
    
});