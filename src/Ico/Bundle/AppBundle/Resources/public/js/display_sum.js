$(document).ready(function() {
    var updateDisplayedSum = function(element) {
        var output = element;
        var sum = 0;
        $(element).closest('table').find('.modificator-value').each(function() {
            sum += parseInt($(this).val());
        });
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
    };
    // Init by adding toggle button from reference to custom
    $('.display-sum').each(function() {
        updateDisplayedSum(this);
    });
    // Init by adding toggle button from reference to custom
    $(document).on('change', '.modificator-value', function() {
        updateDisplayedSum($(this).closest('table').find('.display-sum'));
    });
});
