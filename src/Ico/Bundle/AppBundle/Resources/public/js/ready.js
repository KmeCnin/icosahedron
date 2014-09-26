$(document).ready(function() {
    
    // Initialisation des tooltips
    $('[data-toggle="tooltip"]').tooltip({placement: 'top'});  
    
    // Initialisation des select multiples avec Chosen
    $('select[multiple]').chosen();
    $('.chosen-choices').addClass('form-control');
    
    // Initialisation des pop-hover    
    $('.preview').each(function() {
	   $(this).attr('data-toggle', 'popover');
	   $(this).popover({placement: 'auto', html: true, trigger: 'manual', animation: false, dataContainer : '.modal-body'});
    });
    $(document).on('mouseover', '.preview', function() {
	   var toggler = $(this);
	   var id = toggler.uniqueId().attr('id');
	   if(typeof(Storage) !== "undefined" && localStorage.getItem(toggler.attr('href')) !== null) {
		  toggler.attr('data-content', localStorage.getItem(toggler.attr('href')));
		  toggler.popover('show');
	   } else {
		  $.get(toggler.attr('href').replace('/view/', '/preview/'), function(preview) {
			 localStorage.setItem(toggler.attr('href'), preview);
			 toggler.attr('data-content', preview);
			 if ($('#'+id+':hover').length > 0) { // On montre le resultat seulement si la souris est encore dessus
				toggler.popover('show');
			 }
			 toggler.removeUniqueId();
		  });
	   }
    });
    $(document).on('mouseleave', '.preview', function() {
	   $('.preview').popover('hide');
    });
    
});