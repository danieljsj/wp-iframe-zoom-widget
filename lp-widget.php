<?php

/**
 * Plugin Name: Example Plugin - LeadPages Widget
 * Description: A brief example plugin demonstrating some of the bare-bones basics of what I imagine might be expected of me for the role of WP Plugin Developer at LeadPages.
 * Author: Daniel Schulz-Jackson
 * Author URI: http://10x.agency/about
 */



require_once 'includes/widget.php';








function dsj_box_scaling_scripts() {
	// wp_enqueue_style( 'style-name', get_stylesheet_uri() );
	wp_enqueue_script( 'dsj-box-scaling', plugins_url( 'js/src/scale-boxes.js', __FILE__), array('jquery'), '', true );
}

add_action( 'wp_enqueue_scripts', 'dsj_box_scaling_scripts' );