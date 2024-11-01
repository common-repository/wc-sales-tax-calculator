<?php

/*
 *
 * Enqueue Styles and Scripts
 *
 */

// Actions
add_action( 'admin_enqueue_scripts', 'wcstc_enqueue' );

/*
 * Enqueue scripts and styles
 */
function wcstc_enqueue( $hook ) {
    
    // SETUP
    $wcstc_scripts_js_ver = date( "ymd-Gis", filemtime( WCSTC_PATH . '/assets/js/wcstc_scripts.min.js' ) );
    $wcstc_stylesheet_css_ver = date( "ymd-Gis", filemtime( WCSTC_PATH . '/assets/css/wcstc_stylesheet.min.css' ) );
     
    // JS
    wp_enqueue_script( 'wcstc_script_js', WCSTC_URL . '/assets/js/wcstc_scripts.min.js', array( 'jquery' ), $wcstc_scripts_js_ver, true );

    // CSS
    wp_register_style( 'wcstc_stylesheet_css', WCSTC_URL . '/assets/css/wcstc_stylesheet.min.css', false, $wcstc_stylesheet_css_ver );

    // ENQUEUE
    wp_enqueue_style( 'wcstc_stylesheet_css' );
 
}