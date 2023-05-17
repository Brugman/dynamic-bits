document.addEventListener('DOMContentLoaded', function () {

    // get dynamic bits
    let dynbits = [];

    document.querySelectorAll('[data-dynbit]').forEach( function ( el ) {
        let item = el.getAttribute('data-dynbit');
        if ( dynbits.indexOf( item ) === -1 ) {
            dynbits.push( item );
        }
    });

    // post to our api
    jQuery.post( FAO.ajaxurl, {
        action: 'dynbits',
        nonce: FAO.nonce,
        tasks: dynbits,
    }).fail( function ( response ) {
        // console.log( '---' );
        // console.log( 'dynbits fail' );
        // console.log( response.responseJSON.data );
    }).done( function ( response ) {
        // console.log( '---' );
        // console.log( 'dynbits done' );
        // loop over tasks
        for ( let [ task_name, result ] of Object.entries( response.data.tasks ) ) {
            // console.log( task_name );
            // console.log( result.success );
            // console.log( result.data );

            // failed task
            if ( !result.success ) {
                console.log( '[dynamic bits] '+task_name+' task failed: '+result.data );
                continue;
            }

            // place dynamic bits
            document.querySelectorAll('[data-dynbit="'+task_name+'"]').forEach( function ( el ) {
                el.innerHTML = result.data;
            });
        }
    });
});

