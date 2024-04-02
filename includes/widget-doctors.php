<?php
function myplugin_widgets_init()
{
    register_sidebar(array(
        'name'          => __('Sidebar', 'myplugin'),
        'id'            => 'latest_doctors_sidebar',
        'description'   => __('Add widgets here to appear in your sidebar.', 'myplugin'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));
}
add_action('widgets_init', 'myplugin_widgets_init');

class Latest_Doctors_Widget extends WP_Widget
{

    public function __construct()
    {
        $widget_options = array(
            'classname' => 'latest_doctors_widget',
            'description' => 'Display the 10 latest doctors.',
        );
        parent::__construct('latest_doctors_widget', 'Latest Doctors Widget', $widget_options);

        // Add the dashboard widget
        add_action('wp_dashboard_setup', array($this, 'add_dashboard_widget'));
    }

    // Add the dashboard widget
    public function add_dashboard_widget()
    {
        wp_add_dashboard_widget(
            'latest_doctors_dashboard_widget', // Widget slug
            'Latest Doctors', // Title
            array($this, 'render_dashboard_widget') // Display function
        );
    }

    // Get query args
    private function get_query_args()
    {
        return array(
            'post_type' => 'doctors',
            'posts_per_page' => 10,
            'orderby' => 'date',
            'order' => 'DESC'
        );
    }

    // Render doctors list
    private function render_doctors_list($the_query) {
        echo '<div class="latest-doctors-list">';
        $count = 0;
        while ($the_query->have_posts()) {
            $the_query->the_post();
            $count++;
            echo '<article class="doctor-item" itemscope itemtype="http://schema.org/Physician">';
            echo '<a href="' . get_permalink() . '">';
            echo '<span class="doctor-count">' . $count . '</span>';
            echo '<div class="doctor-info">';
            if ( $doctor_name = get_post_meta(get_the_ID(), 'doctor_name', true)) {
                echo '<span class="doctor-name" itemprop="name">' . $doctor_name . '</span>';
            };
            if ($doctor_specialty = get_post_meta(get_the_ID(), 'doctor_specialty', true)) {
                echo '<span class="doctor-name-field">' . $doctor_specialty . '</span>';
            }
            echo '</div>';
            if (has_post_thumbnail()) {
                echo '<div class="doctor-thumbnail">';
                the_post_thumbnail(array(25, 25));
                echo '</div>';
            }
            echo '</a>';
            echo '</article>';
        }
        echo '</div>';
    }

    // Render the dashboard widget
    public function render_dashboard_widget()
    {
        $the_query = new WP_Query($this->get_query_args());

        if ($the_query->have_posts()) {
            $this->render_doctors_list($the_query);
        } else {
            echo 'No doctors found';
        }

        wp_reset_postdata();
    }

    // Output the widget
    public function widget($args, $instance)
    {
        $title = !empty($instance['title']) ? $instance['title'] : 'Latest Doctors';

        echo $args['before_widget'];
        echo $args['before_title'] . $title . $args['after_title'];
        $this->render_dashboard_widget();
        echo $args['after_widget'];
    }

    // Add form for widget options
    public function form($instance)
    {
        $title = !empty($instance['title']) ? $instance['title'] : 'Latest Doctors';
?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
<?php
    }

    // Update widget options
    public function update($new_instance, $old_instance)
    {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';

        return $instance;
    }
}

// Register the widget
function register_latest_doctors_widget()
{
    register_widget('Latest_Doctors_Widget');
}
add_action('widgets_init', 'register_latest_doctors_widget');
?>