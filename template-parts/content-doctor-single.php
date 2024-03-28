<?php
/**
 * The template part for displaying single doctors
 *
 * @package WordPress
 * @subpackage Doctors_Plugin_Task
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
    </header><!-- .entry-header -->

    <div class="entry-content">
        <?php
        // Display the thumbnail
        if ( has_post_thumbnail() ) {
            the_post_thumbnail();
        }

        // Display the content
        the_content();

        // Display the custom fields
        $doctor_name = get_post_meta(get_the_ID(), 'doctor_name', true);
        $doctor_phone = get_post_meta(get_the_ID(), 'doctor_phone', true);
        $doctor_specialty = get_post_meta(get_the_ID(), 'doctor_specialty', true);
        $doctor_facebook = get_post_meta(get_the_ID(), 'doctor_facebook', true);

        if ($doctor_name) {
            echo '<p><strong>Name:</strong> ' . esc_html($doctor_name) . '</p>';
        }
        if ($doctor_phone) {
            echo '<p><strong>Phone:</strong> ' . esc_html($doctor_phone) . '</p>';
        }
        if ($doctor_specialty) {
            echo '<p><strong>Specialty:</strong> ' . esc_html($doctor_specialty) . '</p>';
        }
        if ($doctor_facebook) {
            echo '<p><strong>Facebook:</strong> <a href="' . esc_url($doctor_facebook) . '">' . esc_html($doctor_facebook) . '</a></p>';
        }
        ?>
    </div><!-- .entry-content -->
</article><!-- #post-## -->