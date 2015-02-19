$(document).ready(function () {
    
    // Initialisation des tooltips
    $('[data-toggle="tooltip"]').tooltip();

    // Gestion du menu contextuel en cas de click sur un hexagone
    $('#mapModelWrapper > svg .hex').click(function () {
        $('#modal_' + $(this).attr('id')).modal('show');
    });

    // Gestion du statut explored des hexagones
    $('.btn.exploredFalse').click(function () {
        var trigger = this;
        $.post(Routing.generate('ico_kingmaker_hex_explored'), {id: $(trigger).closest('.modal').attr('data-hex'), explored: 1}, function () {
            $(trigger).closest('.modal').modal('hide');
            $(trigger).parent().find('.exploredTrue').show();
            $(trigger).hide();
            $(trigger).parent().find('.annexedFalse').show();
            $(trigger).parent().find('.annexedTrue').hide();
            $(trigger).parent().find('.annexedDisabled').hide();
            $('#hex_' + $(trigger).closest('.modal').attr('data-hex')).attr('class', 'hex explored');
        });
    });
    $('.btn.exploredTrue').click(function () {
        var trigger = this;
        $.post(Routing.generate('ico_kingmaker_hex_explored'), {id: $(trigger).closest('.modal').attr('data-hex'), explored: 0}, function () {
            $(trigger).closest('.modal').modal('hide');
            $(trigger).parent().find('.exploredFalse').show();
            $(trigger).hide();
            $(trigger).parent().find('.annexedTrue').hide();
            $(trigger).parent().find('.annexedFalse').hide();
            $(trigger).parent().find('.annexedDisabled').show();
            $('#hex_' + $(trigger).closest('.modal').attr('data-hex')).attr('class', 'hex');
        });
    });

    // Gestion du statut annexed des hexagones
    $('.btn.annexedFalse').click(function () {
        var trigger = this;
        $.post(Routing.generate('ico_kingmaker_hex_annexed'), {id: $(trigger).closest('.modal').attr('data-hex'), annexed: 1}, function () {
            $(trigger).closest('.modal').modal('hide');
            $(trigger).parent().find('.annexedTrue').show();
            $(trigger).hide();
            $(trigger).parent().find('.exploredTrue').hide();
            $(trigger).parent().find('.exploredFalse').hide();
            $(trigger).parent().find('.exploredDisabled').show();
            $('#hex_' + $(trigger).closest('.modal').attr('data-hex')).attr('class', 'hex explored annexed');
            
            $.post(Routing.generate('ico_kingmaker_map_frontier'), {id: $(trigger).closest('.modal').attr('data-hex')}, function (frontier) {
                $('#frontier').html(frontier);
            });
        });
    });
    $('.btn.annexedTrue').click(function () {
        var trigger = this;
        $.post(Routing.generate('ico_kingmaker_hex_annexed'), {id: $(trigger).closest('.modal').attr('data-hex'), annexed: 0}, function () {
            
            $(trigger).closest('.modal').modal('hide');
            $(trigger).parent().find('.annexedFalse').show();
            $(trigger).hide();
            $(trigger).parent().find('.exploredTrue').show();
            $(trigger).parent().find('.exploredFalse').hide();
            $(trigger).parent().find('.exploredDisabled').hide();
            $('#hex_' + $(trigger).closest('.modal').attr('data-hex')).attr('class', 'hex explored');
            
            $.post(Routing.generate('ico_kingmaker_map_frontier'), {id: $(trigger).closest('.modal').attr('data-hex')}, function (frontier) {
                $('#frontier').html(frontier);
            });
            
        });
    });

});