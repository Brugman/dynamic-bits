document.addEventListener('DOMContentLoaded', function () {

    // get dynamic bits
    let dynbits = [];

    document.querySelectorAll('[data-dynbit]').forEach( function ( el ) {
        let item = el.getAttribute('data-dynbit');
        if ( dynbits.indexOf( item ) === -1 ) {
            dynbits.push( item );
        }
    });

    // send dynamic bits to api
    let request = new XMLHttpRequest();

    request.open( 'GET', '/dynbit-api/?tasks='+dynbits.join(), true );

    request.onload = function () {
        if ( this.status < 200 || this.status >= 400 )
            return;

        let results = JSON.parse( this.response );

        if ( !results.success ) {
            console.log( '[dynamic bits] api call failed: '+results.data );
            return;
        }

        for ( let [ task_name, result ] of Object.entries( results.tasks ) ) {

            if ( !result.success ) {
                console.log( '[dynamic bits] '+task_name+' task failed: '+result.data );
                continue;
            }

            // place dynamic bits
            document.querySelectorAll('[data-dynbit="'+task_name+'"]').forEach( function ( el ) {
                el.innerHTML = result.data;
            });
        }
    };

    request.send();
});