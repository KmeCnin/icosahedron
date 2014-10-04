$(document).ready(function() {
    
    // Surligne les mots clés de la recherche
    if (typeof keywords !== 'undefined') {
	   $('.table.table-results tbody > tr, .modal.modal-results .modal-content').each(function(j, tr) {
		  $(tr).find('td, .panel, h4').each(function(index, td) {
			 if (
				($(td).is('td') && $.inArray(index, keywords_contexts) !== -1) || 
				($(td).is('.panel') && $.inArray(index, keywords_contexts) !== -1) ||
				$(td).is('h4')
			 ) {
				console.log($(td));
				$.each(keywords, function(i, keyword) {
				    var context = $(td).html();
				    var regex = new RegExp(keyword, "gi");
				    var output = context.replace(regex, '<mark>'+keyword+'</mark>');
				    $(td).html(output);
				});
			 }
		  });
	   });
    }
    
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