<?php
/**
 * Plugin Name: Doctors Management Plugin
 * Description: A comprehensive plugin for managing doctors and their specialties in WordPress.
 * Version: 1.0.0
 * Author: Dimitris Lykos
 * Text Domain: nxcode-task
 */


// Add CPT functionality.
require_once(plugin_dir_path(__FILE__) . 'includes/cpt.php');

// Include widget functionality.
require_once(plugin_dir_path(__FILE__) . 'includes/widget-doctors.php');

// Include admin functionality.
require_once(plugin_dir_path(__FILE__) . 'includes/admin-functions.php');

// Enqueue styles and scripts.
require_once(plugin_dir_path(__FILE__) . 'includes/enqueue-scripts.php');

// Template functions.
require_once(plugin_dir_path(__FILE__) . 'includes/template-functions.php');