<?php 


// AS A CLASS; WP_REGISTER_WIDGET() :
// https://codex.wordpress.org/Function_Reference/register_widget


class MyNewWidget extends WP_Widget {

	function MyNewWidget() {
		// Instantiate the parent object
		parent::__construct( false, 'My New Widget Title' );
	}

	function widget( $args, $instance ) {
		// Widget output
	}

	function update( $new_instance, $old_instance ) {
		// Save widget options
	}

	function form( $instance ) {
		// Output admin widget options form
	}
}

function myplugin_register_widgets() {
	register_widget( 'MyNewWidget' );
}

add_action( 'widgets_init', 'myplugin_register_widgets' );






// PROCEDURAL; WP_REGISTER_SIDEBAR_WIDGET() :
// https://codex.wordpress.org/Function_Reference/wp_register_sidebar_widget


function your_widget_display($args) {
   echo $args['before_widget'];
   echo $args['before_title'] . 'My Unique Widget' .  $args['after_title'];
   echo $args['after_widget'];
   // print some HTML for the widget to display here
   echo "Your Widget Test";
}

wp_register_sidebar_widget(
    'your_widget_1',        // your unique widget id
    'Your Widget',          // widget name
    'your_widget_display',  // callback function
    array(                  // options
        'description' => 'Description of what your widget does'
    )
);







// MORE INVOLVED: WPBEGINNER: 
// http://www.wpbeginner.com/wp-tutorials/how-to-create-a-custom-wordpress-widget/



// Creating the widget 
class wpb_widget extends WP_Widget {

	function __construct() {
		parent::__construct(
			// Base ID of your widget
			'wpb_widget', 

			// Widget name will appear in UI
			__('WPBeginner Widget', 'wpb_widget_domain'), 

			// Widget description
			array( 'description' => __( 'Sample widget based on WPBeginner Tutorial', 'wpb_widget_domain' ), ) 
			);
	}

	// Creating widget front-end
	// This is where the action happens
	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );
		// before and after widget arguments are defined by themes
		echo $args['before_widget'];
		if ( ! empty( $title ) )
			echo $args['before_title'] . $title . $args['after_title'];

		// This is where you run the code and display the output
		echo __( 'Hello, World!', 'wpb_widget_domain' );
		echo $args['after_widget'];
	}

	// Widget Backend 
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( 'New title', 'wpb_widget_domain' );
		}
		// Widget admin form
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<?php 
	}
	
	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		return $instance;
	}
} // Class wpb_widget ends here


// Register and load the widget
function wpb_load_widget() {
	register_widget( 'wpb_widget' );
}
add_action( 'widgets_init', 'wpb_load_widget' );