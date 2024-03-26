<?php
/**
 * Plugin Name: Doctors Plugin Tasl
 * Description: Plugin for managing doctors in WordPress.
 * Version: 1.0
 * Author: Dimitris Lykos
 */

// Include widget functionality.
require_once(plugin_dir_path(__FILE__) . 'widget-doctors.php');

// Include archive page functionality.
require_once(plugin_dir_path(__FILE__) . 'doctors-archive-page.php');

// Include admin functionality.
require_once(plugin_dir_path(__FILE__) . 'admin-functions.php');

// Include article linking functionality.
require_once(plugin_dir_path(__FILE__) . 'article-linking.php');

// Enqueue styles and scripts.
function enqueue_doctors_styles_scripts() {
    // Enqueue styles and scripts here.
}
add_action('wp_enqueue_scripts', 'enqueue_doctors_styles_scripts');

// Add structured data for doctors pages.
function add_structured_data_for_doctors() {
    // Add structured data for doctors pages here.
}
add_action('wp_head', 'add_structured_data_for_doctors');