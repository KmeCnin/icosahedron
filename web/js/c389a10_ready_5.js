$(document).ready(function() {
        
    // Change tous les td se trouvant dans des tr.titre en th
    $("tr.titre td").changeElementType("th");
    
    // Supprime les ancres du wiki
    $('.headeranchor').remove();
    
    // Calcule de la hauteur des décorations des arborescences à postériori
    $('div.vWrapper').each(function(){
	   $(this).height($(this).parent('td').height());
    });
    $('.modal').on('shown.bs.modal', function() {
	   $(this).find('div.vWrapper').each(function(){
		  $(this).height($(this).parent('td').height());
	   });
    });
    // Ajout de target blank sur tous les liens preview
    $('.preview').attr('target', '_blank');
    // Inactive le click sur les liens qui ne sont pas encore traduits en url locale
    var wikiUrl = 'http://www.pathfinder-fr.org/Wiki/';
//    $('.preview[href^=Pathfinder]').attr('href', 'disabled');
//    $('.disabled[href^=Pathfinder]').click(function() {
//	   return false;
//    });
    $('.preview[href^=Pathfinder]').each(function() {
	   $(this).attr('href', wikiUrl+$(this).attr('href'));
    });
    
    // Initialisation des select multiples avec Chosen
    $('select[multiple]').chosen();
    $('.chosen-choices').addClass('form-control');
    
    // Initialisation des tooltips
    $('[data-toggle="tooltip"]').tooltip({placement: 'top'});  
    
    // Initialisation des pop-hover    
    $('.preview').each(function() {
	   $(this).attr('data-toggle', 'popover');
	   $(this).popover({placement: 'auto', html: true, trigger: 'manual', animation: false, dataContainer : '.modal-body'});
    });
    $('[data-toggle="popover"]').popover({placement: 'auto', html: true, trigger: 'hover', animation: false, dataContainer : '.modal-body'});
    $(document).on('mouseover', '.preview', function() {
	   var toggler = $(this);
	   var id = toggler.uniqueId().attr('id');
	   if(typeof(Storage) !== "undefined" && localStorage.getItem(toggler.attr('href')) !== null) {
		  toggler.attr('data-content', localStorage.getItem(toggler.attr('href')));
		  toggler.popover('show');
	   } else {
		  $.get(toggler.attr('href').replace('/r%C3%A8gles-pathfinder/', '/règles-pathfinder-aperçu/'), function(preview) {
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
    
    // Saut entre les modales
    $('[data-modal-jump]').click(function() {
	   var jumpModal = '#'+$(this).attr('data-modal-jump');
	   var currentModal = $(this).closest('.modal');
//	   if ($(this).is('.modalJumpPrevious')) {
//		  var animOut = 'animated bounceOutRight';
//		  var animIn = 'animated bounceInLeft';
//	   }
//	   if ($(this).is('.modalJumpNext')) {
//		  var animOut = 'animated bounceOutLeft';
//		  var animIn = 'animated bounceInRight';
//	   }
//	   // On cache la barre de scrolling lorsqu'on montre la modal pour éviter le décallage en largeur du layout
//	   $(currentModal).css('overflow', 'hidden');
//	   $(currentModal).addClass(animOut); // On anime l'ancienne modale
//	   $(currentModal).one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
//		  // Lorsque l'animation est terminée
//		  $(currentModal).removeClass(animOut); // On nettoie les classes
		  $(currentModal).modal('hide'); // On cache la modale
//		  $(currentModal).on('hidden.bs.modal', function (e) {
//			 // Lorsque la modale est cachée
//			 $(jumpModal).addClass(animIn); // On anime la suivante
//			 $(jumpModal).one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
//				// Lorsque l'animation est terminée
//				$(jumpModal).removeClass(animIn); // On nettoie les classes
				$(jumpModal).modal('show'); // On montre la modale
//				// On cache la barre de scrolling lorsqu'on montre la modal pour éviter le décallage en largeur du layout
//				$('body').css('overflow', 'hidden');
//			 });
//		  });
//	   });
    });
    // On réaffiche la barre de scrolling lorsqu'on cache la modale
//    $('.modal').on('hide.bs.modal', function() {
//	   $('body').css('overflow', 'auto');
//    });
    
    // Surligne les mots clés de la recherche
    if (typeof keywords !== 'undefined') {
	   $('.table.table-results tbody > tr, .modal.modal-results .modal-content').each(function(j, tr) {
		  $(tr).find('td, .panel, h4').each(function(index, td) {
			 if (
				($(td).is('td') && $.inArray(index, keywords_contexts_list) !== -1) || 
				($(td).is('.panel') && $.inArray(index, keywords_contexts_modal) !== -1) ||
				$(td).is('h4')
			 ) {
//				console.log($(td));
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
    
    // ouverture de la modale si besoin 
    if (localStorage.getItem('openModal') !== null) {
	   var index = localStorage.getItem('openModal');
//	   if ($('.modal').length < index+1) {
//		  $('.modal').last().modal('show');
//	   } else {
	   $('.modal').eq(index).modal('show');
//	   }
	   localStorage.removeItem('openModal');
    }
    
});

function initChosen() {
    // Initialisation des select multiples avec Chosen
    
    $('select[multiple]').chosen();
    $('.chosen-choices').addClass('form-control');
}

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

// http://stackoverflow.com/questions/8584098/how-to-change-an-element-type-using-jquery
// Fonction permettant de changer le type d'une balise html
(function($) {
    $.fn.changeElementType = function(newType) {
        var attrs = {};
	   if (typeof this[0] !== 'undefined') {
		  $.each(this[0].attributes, function(idx, attr) {
			 attrs[attr.nodeName] = attr.nodeValue;
		  });

		  this.replaceWith(function() {
			 return $("<" + newType + "/>", attrs).append($(this).contents());
		  });
	   }
    };
})(jQuery);