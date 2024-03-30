<?php
/**
 * The template part for displaying single doctors
 *
 * @package WordPress
 * @subpackage Doctors_Plugin_Task
 */
?>

<div class="page-header" itemscope itemtype="http://schema.org/Person">
    <div class="container">
        <div class="page-header__author-wrapper">
            <div class="breadcrumbs" itemprop="breadcrumb">
                <a class="breadcrumbs__link" href="<?php echo esc_url(get_post_type_archive_link('doctors')); ?>" itemprop="url">
                    <span itemprop="name">Doctors</span>
                </a>
                <span class="breadcrumbs__separator"> / </span>
                <span class="breadcrumbs__current" itemprop="name"><?php the_title(); ?></span>
            </div>
            <div class="page-header__info-wrapper">
                <h1 class="page-header__title" itemprop="name">
                    <?php the_title(); ?>
                </h1>
                <?php
                // Display the custom fields
                $doctor_specialty = get_post_meta(get_the_ID(), 'doctor_specialty', true);
                if ($doctor_specialty) {
                    echo '<p class="page-header__specialty" itemprop="jobTitle">' . esc_html($doctor_specialty) . '</p>';
                }
                ?>
                <?php
                // Display the thumbnail
                if ( has_post_thumbnail() ) {
                    echo '<div class="page-header__thumbnail">';
                    the_post_thumbnail('thumbnail');
                    echo '</div>';
                }
                ?>
            </div>
            <div class="page-header__content">
                <?php the_content(); ?>
            </div>
            <div class="page-header__info">
                <?php
                // Display the custom fields
                $doctor_name = get_post_meta(get_the_ID(), 'doctor_name', true);
                $doctor_phone = get_post_meta(get_the_ID(), 'doctor_phone', true);
                $doctor_facebook = get_post_meta(get_the_ID(), 'doctor_facebook', true);

                if ($doctor_name) {
                    echo '<p><strong>Name:</strong> ' . esc_html($doctor_name) . '</p>';
                }
                if ($doctor_phone) {
                    echo '<p><strong>Phone:</strong> ' . esc_html($doctor_phone) . '</p>';
                }
                if ($doctor_facebook) {
                    echo '<p><strong>Facebook:</strong> <a href="' . esc_url($doctor_facebook) . '">' . esc_html($doctor_facebook) . '</a></p>';
                }
                ?>
            </div>
        </div>
        <div class="page-header__content-wrapper">

            <?php
            // Get the related post IDs
            $related_post_ids = get_post_meta(get_the_ID(), '_related_post_ids', true);
            $related_post_ids = explode(',', $related_post_ids); // Convert string to array

            // Query the related posts
            $args = array(
                'post_type' => 'post',
                'post__in' => $related_post_ids
            );
            $related_posts_query = new WP_Query($args);

            // Display the related posts
            if ($related_posts_query->have_posts()) {
                echo '<div class="related-posts">';
                echo '<h2>Related Posts</h2>';
                while ($related_posts_query->have_posts()) {
                    $related_posts_query->the_post();
                    echo '<article class="related-post" itemscope itemtype="http://schema.org/Article">';
                    echo '<a href="' . get_permalink() . '" itemprop="url">';
                    if ( has_post_thumbnail() ) {
                        echo '<div class="related-post__thumbnail">';
                        the_post_thumbnail('full');
                        echo '</div>';
                    }
                    echo '<h3 itemprop="headline">' . get_the_title() . '</h3>';
                    echo '<div itemprop="description">';
                    the_excerpt();
                    echo '</div>';
                    echo '</a>';
                    echo '</article>';
                    echo '<hr>';
                }
                echo '</div>';
                wp_reset_postdata(); // Reset the global post object
            }
            ?>

            <aside class="sidebar">
                <!-- Sidebar content here -->
            </aside>
        </div>
    </div>
</div>