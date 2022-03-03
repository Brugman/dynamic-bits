(function($) {

    $('[data-dynbit]').each( function () {

        let dynbit = $(this).attr('data-dynbit');

        $.ajax({
            dataType: 'json',
            url: '/my-api/',
            data: { 'task': dynbit },
            success: function ( data ) {
                $('[data-dynbit="'+dynbit+'"]').replaceWith( data );
            }
        });
    });

})( jQuery );