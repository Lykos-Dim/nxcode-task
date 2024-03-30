<?php
// Register Custom Post Type
function doctors_custom_post_type() {
    $labels = array(
        'name'                  => 'Doctors',
        'singular_name'         => 'Doctor',
        'menu_name'             => 'Doctors',
        'icon'                  => 'dashicons-id',
        'public'                => true,
        'has_archive'           => true,
        'rewrite'               => array('slug' => 'doctors'),
        'supports'              => array('title', 'editor', 'excerpt', 'thumbnail', 'custom-fields'),
    );
    $args = array(
        'labels'                => $labels,
        'public'                => true,
        'hierarchical'          => false,
        'capability_type'       => 'post',
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-id',
        'supports'              => array('title', 'editor', 'thumbnail', 'excerpt'),
        'rewrite'               => array('slug' => 'doctors'),
        'has_archive'           => true,
    );
    register_post_type('doctors', $args);
}
add_action('init', 'doctors_custom_post_type', 0);

// Register Custom Taxonomy
function doctors_taxonomy() {
    $labels = array(
        'name'                       => 'Specialties',
        'singular_name'              => 'Specialty',
        'menu_name'                  => 'Specialties',
        'all_items'                  => 'All Specialties',
        'parent_item'                => 'Parent Specialty',
        'parent_item_colon'          => 'Parent Specialty:',
        'new_item_name'              => 'New Specialty Name',
        'add_new_item'               => 'Add New Specialty',
        'edit_item'                  => 'Edit Specialty',
        'update_item'                => 'Update Specialty',
        'view_item'                  => 'View Specialty',
        'separate_items_with_commas' => 'Separate specialties with commas',
        'add_or_remove_items'        => 'Add or remove specialties',
        'choose_from_most_used'      => 'Choose from the most used',
        'popular_items'              => 'Popular Specialties',
        'search_items'               => 'Search Specialties',
        'not_found'                  => 'Not Found',
        'no_terms'                   => 'No specialties',
        'items_list'                 => 'Specialties list',
        'items_list_navigation'      => 'Specialties list navigation',
    );
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => false,
        'rewrite'                    => array('slug' => 'specialties'),
    );
    register_taxonomy('specialties', array('doctors'), $args);
}
add_action('init', 'doctors_taxonomy', 0);