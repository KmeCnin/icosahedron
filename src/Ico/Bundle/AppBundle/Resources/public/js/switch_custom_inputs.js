$(document).ready(function() {
    // Init by adding toggle button from reference to custom
    $('[data-switch=reference]').each(function() {
        $(this)
            .wrap('<div class="input-group"></div>')
            .parent()
            .append('<span class="input-group-btn"><button data-toggle="tooltip" title="Personnaliser" class="btn btn-default" type="button" data-switch-to="'+$(this).attr('id').replace('reference', 'custom')+'"><span class="fa fa-pencil"></span></button></span>')
        ;
    });
    // Init by adding toggle button from custom to reference
    $('[data-switch=custom]').each(function() {
        $(this)
            .wrap('<div class="input-group"></div>')
            .parent()
            .append('<span class="input-group-btn"><button data-toggle="tooltip" title="Utiliser prédéfinis" class="btn btn-default" type="button" data-switch-to="'+$(this).attr('id').replace('custom', 'reference')+'"><span class="fa fa-bars"></span></button></span>')
        ;
    });
    // Init dynamicaly created tooltips
    $('[data-toggle="tooltip"]').tooltip({placement: 'top'});
    // Listen to switch request
    $(document).on('click', '[data-switch-to]', function() {
        var target = $(this).attr('data-switch-to');
        $(this)
            .closest('.form-group')
            .addClass('hidden')
            .find('select, input, textarea')
            .val("")
        ;
        $('#'+target)
            .closest('.form-group')
            .removeClass('hidden')
        ;
    });
});
