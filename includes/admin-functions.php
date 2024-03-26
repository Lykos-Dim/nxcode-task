<?php
/**
 * Admin Functions for Doctors Plugin
 */

// Register meta boxes for doctors custom post type
function doctors_register_meta_boxes() {
    add_meta_box(
        'doctor_details_meta_box', // Meta box ID
        'Doctor Details', // Title
        'render_doctor_details_meta_box', // Callback function
        'doctors', // Post type
        'normal', // Context
        'high' // Priority
    );
}
add_action('add_meta_boxes', 'doctors_register_meta_boxes');

// Render meta box content
function render_doctor_details_meta_box($post) {
    // Retrieve existing values from the database
    $doctor_phone = get_post_meta($post->ID, 'doctor_phone', true);
    $doctor_specialty = get_post_meta($post->ID, 'doctor_specialty', true);
    $doctor_facebook = get_post_meta($post->ID, 'doctor_facebook', true);
    ?>
    <div class="meta-box">
        <div class="meta-box__inner">
            <div class="meta-box__row">
                <label for="doctor_phone">Phone:</label>
                <input type="text" id="doctor_phone" name="doctor_phone" value="<?php echo esc_attr($doctor_phone); ?>" class="widefat" />
            </div>

            <div class="meta-box__row">
                <label for="doctor_specialty">Specialty:</label>
                <input type="text" id="doctor_specialty" name="doctor_specialty" value="<?php echo esc_attr($doctor_specialty); ?>" class="widefat" />
            </div>

            <div class="meta-box__row">
                <label for="doctor_facebook">Facebook Page:</label>
                <input type="text" id="doctor_facebook" name="doctor_facebook" value="<?php echo esc_attr($doctor_facebook); ?>" class="widefat" />
            </div>

            <?php wp_nonce_field(basename(__FILE__), 'doctor_meta_box_nonce'); ?>
        </div>
    </div>
    <?php
}

// Save meta box data
function save_doctor_meta_data($post_id) {
    // Verify nonce
    if (!isset($_POST['doctor_meta_box_nonce']) || !wp_verify_nonce($_POST['doctor_meta_box_nonce'], basename(__FILE__))) {
        return $post_id;
    }

    // Check if this is an autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }

    // Check the user's permissions.
    if ('doctors' == $_POST['post_type'] && !current_user_can('edit_post', $post_id)) {
        return $post_id;
    }

    // Update the meta fields
    if (isset($_POST['doctor_phone'])) {
        update_post_meta($post_id, 'doctor_phone', sanitize_text_field($_POST['doctor_phone']));
    }
    if (isset($_POST['doctor_specialty'])) {
        update_post_meta($post_id, 'doctor_specialty', sanitize_text_field($_POST['doctor_specialty']));
    }
    if (isset($_POST['doctor_facebook'])) {
        update_post_meta($post_id, 'doctor_facebook', sanitize_text_field($_POST['doctor_facebook']));
    }
}
add_action('save_post', 'save_doctor_meta_data');

?>