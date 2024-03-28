<?php
// Enqueue styles and scripts.
function enqueue_doctors_styles_scripts() {
    $version = time();

    wp_enqueue_style( 'nxcode-task-css', plugin_dir_url( __FILE__ ) . '../assets/css/main.css', '', $version );
    wp_enqueue_script( 'nxcode-task-js', plugin_dir_url( __FILE__ ) . '../assets/js/main.js', array( 'jquery' ), $version, true );
}
add_action('wp_enqueue_scripts', 'enqueue_doctors_styles_scripts');