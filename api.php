<?php

/**
 * Core functions.
 */

function return_data( $data )
{
    header( 'Content-Type: application/json; charset=UTF-8' );
    echo json_encode( $data );
    exit;
}

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

function clean_task_name( $string )
{
    return preg_replace( '/[^a-z0-9_]+/', '', $string );
}

function perform_task()
{
    $task_function = 'dynbit_'.clean_task_name( $_GET['task'] ?? '' );

    if ( !function_exists( $task_function ) )
        return dynbit_task_unavailable();

    return $task_function();
}

/**
 * Core tasks.
 */

function dynbit_task_unavailable()
{
    return [
        'success' => false,
        'data'    => 'Task unavailable.',
    ];
}

/**
 * Include custom tasks.
 */

foreach ( glob( __DIR__.'/tasks/*.php' ) as $file )
    include_once( $file );

/**
 * On load.
 */

block_direct_access();
block_third_party_access();

// connect to WordPress
require_once preg_replace( '/wp-content.*$/', '', __DIR__ ).'wp-load.php';

$data = perform_task();

return_data( $data );

