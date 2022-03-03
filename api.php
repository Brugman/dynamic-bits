<?php

function dynbit_random_number()
{
    return rand( 1, 10 );
}

switch ( $_GET['task'] ?? false )
{
    case 'time':
        $result = date('H:i:s');
        break;
    case 'day':
        $result = date('l');
        break;
    case 'random-number':
        $result = dynbit_random_number();
        break;
    default:
        $result = false;
        break;
}

header( 'Content-Type: application/json; charset=UTF-8' );

echo json_encode( $result );

