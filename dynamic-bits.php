<?php

/*
Plugin Name: Dynamic Bits
Plugin URI: https://timbr.dev
Description: How do we keep things dynamic on a cached site?
Version: 0.2.0
Author: Tim Brugman
Author URI: https://timbr.dev
Text Domain: dynamic-bits
License: GPLv2
*/

if ( !defined( 'ABSPATH' ) )
	exit;

/**
 * Load tasks.
 */

foreach ( glob( __DIR__.'/tasks/*.php' ) as $file )
    include_once( $file );

/**
 * Helper functions.
 */

function clean_task_name( $string )
{
    return preg_replace( '/[^a-z0-9_]+/', '', $string );
}

function dynbit_task_unavailable()
{
    return [
        'success' => false,
        'data'    => 'Task unavailable.',
    ];
}

/**
 * AJAX response.
 */

// _nopriv
add_action( 'wp_ajax_dynbits', function () {
    // verify nonce
    if ( !isset( $_POST['nonce'] ) || !wp_verify_nonce( sanitize_key( $_POST['nonce'] ), 'ajax-nonce' ) )
    {
        wp_send_json_error(
            'Bad nonce.',
            400
        );
    }

    // no YOU add sanitization
    $tasks = $_POST['tasks'] ?? [];
    $tasks = array_unique( $tasks );

    // no tasks
    if ( !$tasks )
    {
        wp_send_json_error(
            'No tasks requested.',
            400
        );
    }

    // yes tasks
    $results = [];

    foreach ( $tasks as $task )
    {
        $task = clean_task_name( $task );

        $task_function = 'dynbit_'.$task;

        if ( !function_exists( $task_function ) )
        {
            $results['tasks'][ $task ] = dynbit_task_unavailable();
            continue;
        }

        $results['tasks'][ $task ] = $task_function();
    }

    // send results
    wp_send_json_success(
        $results
    );
});

/**
 * Load JS.
 */

add_action( 'wp_enqueue_scripts', function () {
    // enqueue script
    wp_enqueue_script(
        'dynamic-bits', // name
        plugin_dir_url( __FILE__ ).'dynamic-bits.js', // url
        ['jquery'], // deps
        '0.2.0', // ver
        true // in_footer
    );
    // provide the admin-ajax url to our js
    wp_add_inline_script(
        'dynamic-bits',
        'const FAO = '.json_encode([
            'ajaxurl' => esc_url( admin_url( 'admin-ajax.php' ) ),
            'nonce'   => wp_create_nonce( 'ajax-nonce' ),
        ]),
        'before'
    );
});

/**
 * Example of marking dynamic bits in PHP or HTML.
 */

add_action( 'wp_footer', function () {
?>
<p>Dynamic Bits Examples</p>
<p>This page was cached on <?=date('Y-m-d H:i:s');?>.</p>
<p>The time is now <span data-dynbit="time"></span>.</p>
<p>The time is now <span data-dynbit="time"></span>.</p>
<p>The time is now <span data-dynbit="time"></span>.</p>
<p>Today is <span data-dynbit="day"></span>.</p>
<p>A random number is <span data-dynbit="random_number"></span>.</p>
<p>The website admin email is <span data-dynbit="admin_email"></span>.</p>
<p>This is a failing task<span data-dynbit="woop_dee_doo"></span>.</p>
<?php
});

