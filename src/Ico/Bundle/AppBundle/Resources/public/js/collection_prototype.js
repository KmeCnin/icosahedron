$(document).ready(function() {
    // Add a new line
    $('.prototype-add').unbind().click(function() {
        var prototype = $(this).closest('[data-prototype]').attr('data-prototype');
        var collection = $(this).closest('[data-prototype]');
        $(collection).find('tbody').append(prototype);
        reindex(collection, 'add');
//        setUnique(collection); // TODO
    });
    // Remove the line
    $(document).on('click', '.prototype-remove', function() {
        var collection = $(this).closest('[data-prototype]');
        $(this).closest('tr').remove();
        reindex(collection, 'remove');
    });
    // Initialize
    $('[data-prototype]').each(function() {
        checkMin(this);
        checkMax(this);
    });
});

function reindex(collection, action) {
    $(collection).find('tr').each(function(index, line) {
        $(line).find('td > [id][name]').each(function(key, input) {
            var oldId = $(input).attr('id');
            var oldName = $(input).attr('name');
            var newIndex = index - 1;
            if ('add' === action) {
                $(input).attr('id', oldId.replace('__name__', newIndex));
                $(input).attr('name', oldName.replace('__name__', newIndex));
            } else {
                $(input).attr('id', oldId.replace(/_\d+_/, '_'+newIndex+'_'));
                $(input).attr('name', oldName.replace(/\[\d+\]/, '['+newIndex+']'));
            }
        });
    });
    checkMin(collection);
    checkMax(collection);
}

function checkMin(collection) {
    if ($(collection).find('tr').length - 1 === +$(collection).attr('data-min')) {
        $(collection).find('.prototype-remove')
                .addClass('disabled')
                .prop('title', 'Nombre minimum atteint')
        ;
    } else {
        $(collection).find('.prototype-remove')
                .removeClass('disabled')
                .prop('title', '')
        ;
    }
}

function checkMax(collection) {
    if ($(collection).find('tr').length - 1 === +$(collection).attr('data-max')) {
        $(collection).find('.prototype-add')
                .addClass('disabled')
                .prop('title', 'Nombre maximum atteint')
        ;
    } else {
        $(collection).find('.prototype-add')
                .removeClass('disabled')
                .prop('title', '')
        ;
    }
}
