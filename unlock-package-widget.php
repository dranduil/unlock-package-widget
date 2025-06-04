<?php
/**
 * Plugin Name:     unlock Elementor Widget
 * Description:     Fully integrated Elementor Pro widget for unlock (login, register, profile, packages, purchase).
 * Version:         1.0
 * Author:          Steeven
 * Text Domain:     unlock-elementor-widget
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// 1) Enqueue our JS (only on pages where Elementor is active).
add_action( 'wp_enqueue_scripts', function() {
	wp_enqueue_script(
		'unlock-widget-js',
		plugins_url( 'assets/unlock-widget.js', __FILE__ ),
		[], // no dependencies
		null,
		true // in footer
	);
} );

// 2) Make sure Elementor is active, then register our widget.
add_action( 'elementor/widgets/register', function( $widgets_manager ) {

	// Include the widget PHP file
	require_once plugin_dir_path( __FILE__ ) . 'includes/widget-unlock.php';

	// Register the widget class
	$widgets_manager->register( new \unlock_Widget_Elementor() );
} );
