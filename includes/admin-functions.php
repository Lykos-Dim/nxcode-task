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
    $doctor_name = get_post_meta($post->ID, 'doctor_name', true);
    $doctor_phone = get_post_meta($post->ID, 'doctor_phone', true);
    $doctor_specialty = get_post_meta($post->ID, 'doctor_specialty', true);
    $doctor_facebook = get_post_meta($post->ID, 'doctor_facebook', true);
    $related_post_ids = get_post_meta($post->ID, '_related_post_ids', true);
    $related_post_ids = explode(',', $related_post_ids); // Convert string to array

    // Get all posts
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => -1,
        'post__not_in' => get_all_related_post_ids( $post->ID ) // Exclude posts that have already been selected by other doctors
    );
    $all_posts = get_posts($args);

    ?>

    <div class="meta-box">
        <div class="meta-box__inner">


        <div class="meta-box__row">
                <label for="doctor_name">Doctor Name*</label>
                <input type="text" id="doctor_name" name="doctor_name" value="<?php echo esc_attr($doctor_name); ?>" class="widefat" required />
            </div>

            <div class="meta-box__row">
                <label for="doctor_phone">Phone*</label>
                <input type="tel" id="doctor_phone" name="doctor_phone" value="<?php echo esc_attr($doctor_phone); ?>" class="widefat" required pattern="\d{10}" />
                <small>example: 6934345882</small>
            </div>

            <div class="meta-box__row">
                <label for="doctor_specialty">Specialty*</label>
                <input type="text" id="doctor_specialty" name="doctor_specialty" value="<?php echo esc_attr($doctor_specialty); ?>" class="widefat" required />
            </div>

            <div class="meta-box__row">
                <label for="doctor_facebook">Facebook Page</label>
                <input type="text" id="doctor_facebook" name="doctor_facebook" value="<?php echo esc_attr($doctor_facebook); ?>" class="widefat" />
            </div>

            <div class="meta-box__row">
                <label for="related_post_ids">Related Posts</label>
                <select id="related_post_ids" name="related_post_ids[]" class="widefat" multiple>
                    <option value="">Select posts</option>
                    <?php foreach ($all_posts as $post) : ?>
                        <option value="<?php echo $post->ID; ?>" <?php if (in_array($post->ID, $related_post_ids)) echo 'selected'; ?>><?php echo $post->post_title; ?></option>
                    <?php endforeach; ?>
                </select>
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
    if (isset($_POST['doctor_name'])) {
        update_post_meta($post_id, 'doctor_name', sanitize_text_field($_POST['doctor_name']));
    }
    if (isset($_POST['doctor_phone'])) {
        update_post_meta($post_id, 'doctor_phone', sanitize_text_field($_POST['doctor_phone']));
    }
    if (isset($_POST['doctor_specialty'])) {
        update_post_meta($post_id, 'doctor_specialty', sanitize_text_field($_POST['doctor_specialty']));
    }
    if (isset($_POST['doctor_facebook'])) {
        update_post_meta($post_id, 'doctor_facebook', sanitize_text_field($_POST['doctor_facebook']));
    }

    // Update the related post IDs
    if (isset($_POST['related_post_ids'])) {
        $related_post_ids = array_map('intval', $_POST['related_post_ids']); // Sanitize each ID
        $related_post_ids = implode(',', $related_post_ids); // Convert array to string
        update_post_meta($post_id, '_related_post_ids', $related_post_ids);
    }
}
add_action('save_post', 'save_doctor_meta_data');

// Get all related post IDs
function get_all_related_post_ids($current_doctor_id) {
    $args = array(
        'post_type' => 'doctors',
        'posts_per_page' => -1,
        'post__not_in' => array($current_doctor_id) // Exclude the current doctor
    );
    $all_doctors = get_posts($args);

    $all_related_post_ids = array();
    foreach ($all_doctors as $doctor) {
        $related_post_ids = get_post_meta($doctor->ID, '_related_post_ids', true);
        $related_post_ids = explode(',', $related_post_ids); // Convert string to array
        $all_related_post_ids = array_merge($all_related_post_ids, $related_post_ids);
    }

    return $all_related_post_ids;
}


function clear_related_post_ids() {
    $args = array(
        'post_type' => 'doctors',
        'posts_per_page' => -1
    );
    $all_doctors = get_posts($args);

    foreach ($all_doctors as $doctor) {
        delete_post_meta($doctor->ID, '_related_post_ids');
    }

    // Remove the action after it's run
    remove_action('init', 'clear_related_post_ids', 1);
}
//add_action('init', 'clear_related_post_ids', 1);