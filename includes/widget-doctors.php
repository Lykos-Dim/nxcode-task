<?php
class Latest_Doctors_Widget extends WP_Widget {

    public function __construct() {
        $widget_options = array(
            'classname' => 'latest_doctors_widget',
            'description' => 'Display the 10 latest doctors.',
        );
        parent::__construct('latest_doctors_widget', 'Latest Doctors Widget', $widget_options);

        // Add the dashboard widget
        add_action('wp_dashboard_setup', array($this, 'add_dashboard_widget'));
    }

    // Add the dashboard widget
    public function add_dashboard_widget() {
        wp_add_dashboard_widget(
            'latest_doctors_dashboard_widget', // Widget slug
            'Latest Doctors', // Title
            array($this, 'render_dashboard_widget') // Display function
        );
    }

    // Render the dashboard widget
    public function render_dashboard_widget() {
        $query_args = array(
            'post_type' => 'doctors',
            'posts_per_page' => 10,
            'orderby' => 'date',
            'order' => 'DESC'
        );
        $the_query = new WP_Query($query_args);

        if ($the_query->have_posts()) {
            echo '<ul>';
            while ($the_query->have_posts()) {
                $the_query->the_post();
                echo '<li><a href="' . get_edit_post_link(get_the_ID()) . '">' . get_the_title() . '</a></li>';
            }
            echo '</ul>';
        } else {
            echo 'No doctors found';
        }

        wp_reset_postdata();
    }

    // Output the widget
    public function widget($args, $instance) {
        echo $args['before_widget'];
        echo $args['before_title'] . 'Latest Doctors' . $args['after_title'];
        $this->render_dashboard_widget();
        echo $args['after_widget'];
    }
}

// Register the widget
function register_latest_doctors_widget() {
    register_widget('Latest_Doctors_Widget');
}
add_action('widgets_init', 'register_latest_doctors_widget');