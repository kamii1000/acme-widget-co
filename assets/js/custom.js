$(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();
    $('[data-toggle="popover"]').popover({
        html: true,
        container: 'body',
        title: function () {
            return $(this).attr('data-title') + '<span class="close-popover float-right btn btn-link p-0">' +
                '<i class="fas fa-times"></i>' +
                '</span>';
        },
    });
    $(document).on('click', '.close-popover', function () {
        $(this).parent().closest('.popover').popover('hide');
    });
    $('.select2').select2();

    $('.select2-search--hide').select2({
        minimumResultsForSearch: Infinity
    });

});