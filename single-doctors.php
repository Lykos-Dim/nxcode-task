<?php
/**
 * The template for displaying single doctors
 *
 * @package WordPress
 * @subpackage Doctors_Plugin_Task
 */

get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">
        <?php
        // Start the loop.
        while ( have_posts() ) : the_post();

            // Include the single post content template.
            include plugin_dir_path(__FILE__) . 'template-parts/content-doctor-single.php';

            // End of the loop.
        endwhile;
        ?>
    </main><!-- .site-main -->
</div><!-- .content-area -->

<?php get_footer(); ?>