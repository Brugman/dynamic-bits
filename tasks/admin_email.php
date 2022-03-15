<?php

function dynbit_admin_email()
{
    return [
        'success' => true,
        'data'    => get_option( 'admin_email' ),
    ];
}

