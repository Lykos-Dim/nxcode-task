<?php
/**
 * The template for displaying archive pages for doctors
 *
 * @package WordPress
 * @subpackage Doctors_Plugin_Task
 */

get_header(); ?>
<?php if (have_posts()) : ?>
    <div class="container">
        <div class="doctor-card--top">
            <h1 class="doctor-card--top__title">
                <?php esc_html_e('Doctors', 'Doctors_Plugin_Task'); ?>
            </h1>
        </div>
        <div class="doctor-card--wrapper">
            <?php while (have_posts()) : the_post(); ?>
                <!-- Include the doctor card content template. -->
                <?php include plugin_dir_path(__FILE__) . 'template-parts/content-doctor-card.php'; ?>
                <!-- End of the loop. -->
            <?php endwhile; ?>
            <?php wp_reset_postdata(); ?>
        </div>
        <div class="doctors-pagination">
            <?php 
            // Add the pagination.
            the_posts_pagination(array(
                'mid_size'  => 2,
                'prev_text' => __('« Previous', 'Doctors_Plugin_Task'),
                'next_text' => __('Next »', 'Doctors_Plugin_Task'),
            )); 
            ?>
        </div>
    </div>
<?php else : ?>
    <p><?php esc_html_e('No doctors found.', 'Doctors_Plugin_Task'); ?></p>
<?php endif; ?>
<?php get_footer(); ?>