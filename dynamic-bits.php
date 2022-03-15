<?php

/*
Plugin Name: Dynamic Bits
Plugin URI: https://timbr.dev
Description: How do we keep things dynamic on a cached site?
Version: 0.1.0
Author: Tim Brugman
Author URI: https://timbr.dev
Text Domain: dynamic-bits
License: GPLv2
*/

if ( !defined( 'ABSPATH' ) )
	exit;

/**
 * Load JS.
 */

add_action( 'wp_enqueue_scripts', function () {

    wp_enqueue_script(
        'dynamic-bits', // name
        plugin_dir_url( __FILE__ ).'dynamic-bits.js', // url
        ['jquery'], // deps
        '0.1.0', // ver
        true // in_footer
    );
});

/**
 * Create API URL.
 */

add_filter( 'generate_rewrite_rules', function ( $wp_rewrite ) {

    $wp_rewrite->non_wp_rules = $wp_rewrite->non_wp_rules + [
        'dynbit-api' => 'wp-content/plugins/'.basename( __DIR__ ).'/api.php',
    ];

    return $wp_rewrite;
}, 10, 1 );

/**
 * Example of marking dynamic bits in PHP or HTML.
 */

add_action( 'wp_footer', function () {
?>
<p>Dynamic Bits Examples</p>
<p>This page was cached on <?=date('Y-m-d H:i:s');?>.</p>
<p>The time is now <span data-dynbit="time"></span>.</p>
<p>Today is <span data-dynbit="day"></span>.</p>
<p>A random number is <span data-dynbit="random_number"></span>.</p>
<p>This is a failing task<span data-dynbit="woop_dee_doo"></span>.</p>
<?php
});

