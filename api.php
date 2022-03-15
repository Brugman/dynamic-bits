<?php

include 'api-tasks.php';

function block_direct_access()
{
    if ( !isset( $_SERVER['HTTP_REFERER'] ) )
    {
        return_data([
            'success' => false,
            'data'    => 'Direct access is not allowed.'
        ]);
    }
}

function block_third_party_access()
{
    $ref = $_SERVER['HTTP_REFERER'] ?? false;

    if ( $ref && strpos( $ref, $_SERVER['HTTP_HOST'] ) === false )
    {
        return_data([
            'success' => false,
            'data'    => 'Third party access is not allowed.'
        ]);
    }
}

function return_data( $data )
{
    header( 'Content-Type: application/json; charset=UTF-8' );
    echo json_encode( $data );
    exit;
}

function perform_task()
{
    switch ( $_GET['task'] ?? false )
    {
        case 'time':
            return dynbit_time();
            break;
        case 'day':
            return dynbit_day();
            break;
        case 'random-number':
            return dynbit_random_number();
            break;
        default:
            return dynbit_task_unavailable();
            break;
    }
}

block_direct_access();
block_third_party_access();

$data = perform_task();

return_data( $data );

