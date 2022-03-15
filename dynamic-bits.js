(function($) {

    $('[data-dynbit]').each( function () {

        let dynbit = $(this).attr('data-dynbit');

        $.ajax({
            dataType: 'json',
            url: '/dynbit-api/',
            data: { 'task': dynbit },
            success: function ( data ) {

                if ( !data.success ) {
                    console.log( '[dynamic bits] '+dynbit+' task failed: '+data.data );
                    return;
                }

                $('[data-dynbit="'+dynbit+'"]').html( data.data );
            }
        });
    });

})( jQuery );