(function($) {
// document.addEventListener('DOMContentLoaded', function () {

    console.log( 'page ready' );

    let dynbits = [];

    document.querySelectorAll('[data-dynbit]').forEach( function ( el ) {
        let item = el.getAttribute('data-dynbit');
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

                document.querySelectorAll('[data-dynbit="'+task_name+'"]').forEach( function ( el ) {
                    el.innerHTML = result.data;
                });
            }
        }
    });

// });
})( jQuery );