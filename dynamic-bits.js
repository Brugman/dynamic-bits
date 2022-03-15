(function($) {

    let dynbits = [];

    $('[data-dynbit]').each( function () {
        let item = $(this).attr('data-dynbit');
        if ( dynbits.indexOf( item ) === -1 ) {
            dynbits.push( item );
        }
    });

    $.ajax({
        dataType: 'json',
        url: '/dynbit-api/',
        data: { 'tasks': dynbits.join() },
        success: function ( results ) {

            if ( !results.success ) {
                console.log( '[dynamic bits] api call failed: '+results.data );
                return;
            }

            for ( let [ task_name, result ] of Object.entries( results.tasks ) ) {

                if ( !result.success ) {
                    console.log( '[dynamic bits] '+task_name+' task failed: '+result.data );
                    continue;
                }

                $('[data-dynbit="'+task_name+'"]').html( result.data );
            }
        }
    });

})( jQuery );