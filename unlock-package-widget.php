<?php
/**
 * Plugin Name: Unlock API Widget
 * Description: Widget Elementor per login, pacchetti e acquisto con API Laravel + Stripe.
 * Version: 1.0
 * Author: Steeven
 */

if (!defined('ABSPATH')) exit;

function unlock_api_widget_assets() {
    wp_enqueue_script('unlock-widget', plugins_url('assets/unlock-widget.js', __FILE__), [], null, true);
}
add_action('wp_enqueue_scripts', 'unlock_api_widget_assets');

require_once plugin_dir_path(__FILE__) . 'includes/shortcode.php';
