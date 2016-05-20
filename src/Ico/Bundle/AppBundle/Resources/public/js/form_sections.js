$(document).ready(function() {
    // Get all differents sections
    var sections = new Array();
    var sectionActive = parseInt(window.location.hash.substring(8));
    if (!sectionActive) {
        sectionActive = 0;
        window.location.hash = '#section0';
    } 
    $('[data-section]').each(function () {
        var challenger = $(this).attr('data-section');
        if (sections.indexOf(challenger) === -1) {
            sections.push(challenger);
        }
    });
    // Créate the nav
    $('form > div').prepend('<ul class="nav-sections nav nav-tabs"></ul>');
    // Wrap all form input group of the same section into a common wrapper
    sections.forEach(function (name, id) {
        var classAttr = 'form-section tab-pane fade';
        var classNav = 'nav-section';
        if (sectionActive === id) {
            classAttr += ' active in';
            classNav += ' active';
        }
        $('[data-section='+name+']').closest('.form_row.form-group').wrapAll(
            '<div class="'+classAttr+'" id="section'+id+'"></div>'
        );
        $('.nav-sections').append(
            '<li class="'+classNav+'"><a href="#section'+id+'" data-toggle="tab">'+name+'</a></li>'
        );
    });
    $('.form-section').wrapAll('<div class="form-sections tab-content"></div>');
    // Handle url tab
    $(document).on('shown.bs.tab', '[data-toggle=tab]', function(event) {
        window.location.hash = $(event.target).attr('href');
    });
});
