$(document).ready(function() {
    
    // Gestion du menu contextuel en cas de click sur un hexagone
    $('#mapModelWrapper > svg .hex').click(function() {
        $('#modal_'+$(this).attr('id')).modal('show');
    });
    
    // Gestion du statut explored des hexagones
    $('.btn.exploredFalse').click(function() {
	   var trigger = this;
        $.post(Routing.generate('ico_kingmaker_hex_explored'), {id: $(trigger).closest('.modal').attr('data-hex'), explored: 1}, function() {
		  $(trigger).parent().find('.exploredTrue').show();
		  $(trigger).hide();
		  $('#hex_'+$(trigger).closest('.modal').attr('data-hex')).attr('class', 'hex explored');
	   });
    });
    $('.btn.exploredTrue').click(function() {
	   var trigger = this;
        $.post(Routing.generate('ico_kingmaker_hex_explored'), {id: $(trigger).closest('.modal').attr('data-hex'), explored: 0}, function() {
		  $(trigger).parent().find('.exploredFalse').show();
		  $(trigger).hide();
		  $('#hex_'+$(trigger).closest('.modal').attr('data-hex')).attr('class', 'hex');
	   });
    });
    
});