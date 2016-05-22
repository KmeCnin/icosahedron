$(document).ready(function() {
    var updateDisplayedSum = function(element) {
        var output = element;
        var sum = 0;
        $(element).closest('table').find('.modificator-value').each(function() {
            sum += parseInt($(this).val());
        });
        $(output).attr('data-displayed-sum', sum);
        if ($(output).is('.display-mod')) {
            updateMod(output, sum);
        } else {
            $(output).val(sum);
        }
    };
    var updateMod = function(output, sum) {
        var mod = parseInt((sum-10)/2);
        var sign = mod >= 0 ? '+' : '';
        $(output).val(sum+' ('+sign+mod+')');
        $(output).attr('data-displayed-mod', mod);
    };
    var addValueFrom = function(element) {
        var target = $('[id$=_'+$(element).attr('data-add-value-from')+']');
        var mod = 0;
        var label = $(target).closest('.form_row.form-group').find('label').html();
        if ($(target).is('table')) {
            mod = $(target).find('[data-displayed-mod]').attr('data-displayed-mod');
            $(element).find('input').last().val(mod);
            $(element).find('input').first().val(label);
        } else if ($(target).is('input')) {
            mod = parseInt($(target).val());
            $(element).find('input').last().val(mod);
            $(element).find('input').first().val(label);
        }
        updateDisplayedSum($(this).closest('table').find('[data-displayed-sum]'));
    };
    var addModFrom = function(element) {
        var mod = $('table[id$=_'+$(element).attr('data-add-mod-from')+']').find('[data-displayed-mod]').attr('data-displayed-mod');
        var label = $('table[id$=_'+$(element).attr('data-add-mod-from')+']').closest('.form_row.form-group').find('label').html();
        $(element).find('input').last().val(mod);
        $(element).find('input').first().val(label);
        updateDisplayedSum($(element).closest('table').find('[data-displayed-sum]'));
    };
    $('.display-sum').each(function() {
        updateDisplayedSum(this);
    });
    $(document).on('change', '.modificator-value', function() {
        updateDisplayedSum($(this).closest('table').find('.display-sum'));
    });
    // Add auto calculated data for value
    $('[data-add-value-from]').each(function() {
        addValueFrom(this);
    });
    // Add auto calculated data for mod
    $('[data-add-mod-from]').each(function() {
        addModFrom(this);
    });
});
