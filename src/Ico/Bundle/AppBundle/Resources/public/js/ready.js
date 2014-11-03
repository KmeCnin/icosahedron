$(document).ready(function() {
    
    // Surligne les mots clés de la recherche
    if (typeof keywords !== 'undefined') {
	   $('.table.table-results tbody > tr, .modal.modal-results .modal-content').each(function(j, tr) {
		  $(tr).find('td, .panel, h4').each(function(index, td) {
			 if (
				($(td).is('td') && $.inArray(index, keywords_contexts_list) !== -1) || 
				($(td).is('.panel') && $.inArray(index, keywords_contexts_modal) !== -1) ||
				$(td).is('h4')
			 ) {
				console.log($(td));
				$.each(keywords, function(i, keyword) {
				    var context = $(td).html();
				    var regex = new RegExp('((?![^<]*>)'+keyword+')', "gi"); // On remplace uniquement le texte qui n'est pas dans les balises html
				    var output = context.replace(regex, '<mark>$1</mark>');
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

function ucfirst(str) {
  //  discuss at: http://phpjs.org/functions/ucfirst/
  // original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // bugfixed by: Onno Marsman
  // improved by: Brett Zamir (http://brett-zamir.me)
  //   example 1: ucfirst('kevin van zonneveld');
  //   returns 1: 'Kevin van zonneveld'

  str += '';
  var f = str.charAt(0)
    .toUpperCase();
  return f + str.substr(1);
}

function lcfirst(str) {
  //  discuss at: http://phpjs.org/functions/lcfirst/
  // original by: Brett Zamir (http://brett-zamir.me)
  //   example 1: lcfirst('Kevin Van Zonneveld');
  //   returns 1: 'kevin Van Zonneveld'

  str += '';
  var f = str.charAt(0)
    .toLowerCase();
  return f + str.substr(1);
}