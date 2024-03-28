<?php
/**
 * The template for displaying single doctor posts.
 * This template is used when a single post from the 'doctors' custom post type is queried.
 * For example, when a visitor clicks on a doctor post, WordPress uses this template to display the post.
 *
 * @package WordPress
 * @subpackage Doctors_Plugin_Task
 */
function doctors_single_template($single_template) {
	global $post;

	if ($post->post_type == 'doctors') {
		$single_template = plugin_dir_path(__FILE__) . '../single-doctors.php';
	}

	return $single_template;
}
add_filter('single_template', 'doctors_single_template');