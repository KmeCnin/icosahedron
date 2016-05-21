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
    // Init by adding toggle button from reference to custom
    $('.display-sum').each(function() {
        updateDisplayedSum(this);
    });
    // Init by adding toggle button from reference to custom
    $(document).on('change', '.modificator-value', function() {
        updateDisplayedSum($(this).closest('table').find('.display-sum'));
    });
    // Add auto calculated data
    $('[data-add-mod-from]').each(function() {
        var mod = $('table[id$='+$(this).attr('data-add-mod-from')+']').find('[data-displayed-mod]').attr('data-displayed-mod');
        var label = $('table[id$='+$(this).attr('data-add-mod-from')+']').closest('.form_row.form-group').find('label').html();
        $(this).find('input').last().val(mod);
        $(this).find('input').first().val(label);
        updateDisplayedSum($(this).closest('table').find('[data-displayed-sum]'));
    });
});
