$(document).ready(function() {
    // Add a new line
    $('.prototype-add').unbind().click(function() {
        var prototype = $(this).closest('[data-prototype]').attr('data-prototype');
        var collection = $(this).closest('tbody');
        $(collection).append(prototype);
    });
    // Remove the line
    $(document).on('click', '.prototype-remove', function() {
        var collection = $(this).closest('tbody');
        $(this).closest('tr').remove();
    });
});
