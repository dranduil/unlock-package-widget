<?php
/**
 * Plugin Name:     unlock Elementor Widgets
 * Description:     Collezione di widget Elementor per login/signup, lista pacchetti e dettaglio pacchetto (API Laravel).
 * Version:         1.0
 * Author:          Steeven
 * Text Domain:     unlock-elementor-widgets
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Evitiamo accessi diretti
}

/**
 * 1) Enqueue JS (solo se Elementor è attivo o su front-end)
 */
add_action( 'wp_enqueue_scripts', function() {
    // Enqueue Stripe.js
    wp_enqueue_script(
        'stripe-js',
        'https://js.stripe.com/v3/',
        [],
        null,
        true // Load in footer
    );

	wp_enqueue_script(
		'unlock-widgets-js',
		plugins_url( 'assets/unlock-widgets.js', __FILE__ ),
		['stripe-js'],   // Add stripe-js as a dependency
		null,
		true  // carica in footer
	);

    // Localize script with Stripe public key and other settings
    // IMPORTANT: Replace 'YOUR_STRIPE_PUBLISHABLE_KEY' with your actual Stripe publishable key
    // You should ideally fetch this from WordPress options or a secure constant.
    $stripe_settings = [
        'publishableKey' => defined('UNLOCK_STRIPE_PUBLISHABLE_KEY') ? UNLOCK_STRIPE_PUBLISHABLE_KEY : 'YOUR_STRIPE_PUBLISHABLE_KEY_PLACEHOLDER',
        // Add other settings like API_BASE if not already globally available in JS
        // 'apiBaseUrl' => defined('UNLOCK_API_BASE_URL') ? UNLOCK_API_BASE_URL : 'YOUR_API_BASE_URL_PLACEHOLDER',
    ];
    wp_localize_script( 'unlock-widgets-js', 'unlockStripeSettings', $stripe_settings );

	// Se prevedi CSS custom, potresti aggiungere qui un enqueue_style
	// wp_enqueue_style( 'unlock-widgets-css', plugins_url('assets/unlock-widgets.css', __FILE__) );
	wp_enqueue_style(
		'unlock-profile-widget-css',
		plugins_url( 'assets/css/unlock-profile-widget.css', __FILE__ ),
		[],
		null
	);

	wp_enqueue_style(
		'unlock-packages-widget-css',
		plugins_url( 'assets/css/unlock-packages-widget.css', __FILE__ ),
		[],
		null
	);
} );

/**
 * 2) Registra i widget su Elementor
 */
add_action( 'elementor/widgets/register', function( $widgets_manager ) {

	// Includi tutti i file PHP dei widget
	require_once plugin_dir_path( __FILE__ ) . 'includes/widget-unlock-login.php';
	require_once plugin_dir_path( __FILE__ ) . 'includes/widget-unlock-signup.php';
	require_once plugin_dir_path( __FILE__ ) . 'includes/widget-unlock-packages-list.php';
	require_once plugin_dir_path( __FILE__ ) . 'includes/widget-unlock-single-package.php';
	// Dentro add_action('elementor/widgets/register', … )
	require_once plugin_dir_path( __FILE__ ) . 'includes/widget-unlock-profile.php';



	// Registra ciascuna classe come widget
	$widgets_manager->register( new \unlock_Widget_Login() );
	$widgets_manager->register( new \unlock_Widget_Signup() );
	$widgets_manager->register( new \unlock_Widget_Packages_List() );
	$widgets_manager->register( new \unlock_Widget_Single_Package() );
	$widgets_manager->register( new \Unlock_Widget_Profile() );
} );
