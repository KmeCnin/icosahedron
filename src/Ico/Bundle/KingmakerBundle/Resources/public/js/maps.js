$(document).ready(function() {
    
    // Gestion du menu contextuel en cas de click sur un hexagone
    $('#mapModelWrapper > svg .hex').click(function() {
        alert('lol');
        $('#modal_'+$(this).attr('id')).show();
    });
    
});