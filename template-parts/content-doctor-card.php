<?php
/**
 * The template part for displaying doctors card
 *
 * @package WordPress
 * @subpackage Doctors_Plugin_Task
 */
?>

<article class="doctor-card" itemscope itemtype="http://schema.org/Physician">
    <a href="<?php echo esc_url(get_permalink(get_the_ID())); ?>" itemprop="url" style="display: block;">
        <?php if (has_post_thumbnail()) : ?>
            <div class="doctor-card__thumbnail">
                <?php the_post_thumbnail('full', array('itemprop' => 'image')); ?>
            </div>
        <?php endif; ?>
        <div class="doctor-card__content">
            <?php $doctor_name = get_post_meta(get_the_ID(), 'doctor_name', true); ?>
            <?php if (!empty($doctor_name)) : ?>
                <h2 class="doctor-card__title" itemprop="name">
                    <?php echo esc_html($doctor_name); ?>
                </h2>
            <?php endif; ?>
            <?php $doctor_specialty = get_post_meta(get_the_ID(), 'doctor_specialty', true); ?>
            <?php if ( !empty( $doctor_specialty ) ) : ?>
                <span>
                    <?php echo esc_html( $doctor_specialty ); ?>
                </span>
            <?php endif; ?>
            <p itemprop="description"><?php echo esc_html(get_the_excerpt()); ?></p>
        </div>
    </a>
</article>