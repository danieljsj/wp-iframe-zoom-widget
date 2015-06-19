<?php 

// REFS:
// http://www.wpbeginner.com/wp-tutorials/how-to-create-a-custom-wordpress-widget/
// https://codex.wordpress.org/Widgets_API



// Creating the widget 
class wpb_widget extends WP_Widget {

	const DEFAULT_LEADBOX_URL = 'https://my.leadpages.net/leadbox/14791da73f72a2%3A147c8da44b46dc/5682617542246400/';

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

		// before and after widget arguments are defined by themes
		echo $args['before_widget'];
		if ( ! empty( $title ) )
			echo $args['before_title'] . $title . $args['after_title'];



		// This is where you run the code and display the output
		echo __( 'Here is a leadbox...', 'wpb_widget_domain' );

		$widthStr = sprintf("%.2f%%", ( 1 / $instance['zoom'] ) * 100)


		?>
		<style>
		    #wrap { width: 100%; /*min-width: 200px;*/ height: 390px; padding: 0; }
		    #frame { max-width: <?php echo $widthStr ?>; width: <?php echo $widthStr ?>; height: 680px; border: 1px solid black; }
		    #frame {
		        -ms-zoom: <?php echo $instance['zoom']; ?>;
		        -moz-transform: scale( <?php echo $instance['zoom']; ?> );
		        -moz-transform-origin: 0 0;
		        -o-transform: scale( <?php echo $instance['zoom']; ?> );
		        -o-transform-origin: 0 0;
		        -webkit-transform: scale( <?php echo $instance['zoom']; ?> );
		        -webkit-transform-origin: 0 0;
		    }
		</style>
		<div id="wrap">
			<iframe 
				src="<?php echo $instance['url']; ?>"
				frameborder="0"
				id="frame"
			></iframe>
		</div>
		<?php
		echo $args['after_widget'];
	}

	// Widget Backend 
	public function form( $instance ) {
		if ( isset( $instance[ 'url' ] ) && $instance['url'] ) {
			$url = $instance[ 'url' ];
		}
		else {
			$url = self::DEFAULT_LEADBOX_URL;
		}
		if ( isset( $instance[ 'zoom' ] ) ) {
			$zoom = $instance[ 'zoom' ];
		}
		else {
			$zoom = .9;
		}
		// Widget admin form
		?>
		<p>
			<label 
				for="<?php echo $this->get_field_id( 'url' ); ?>"><?php _e( 'Leadbox URL:' ); ?>
				</label>
			<input 
				id="<?php echo $this->get_field_id( 'url' ); ?>" 
				name="<?php echo $this->get_field_name( 'url' ); ?>" 
				type="text" 
				value="<?php echo esc_attr( $url ); ?>" 
			/>
			<br>
			<label 
				for="<?php echo $this->get_field_id( 'zoom' ); ?>"><?php _e( 'Zoom:' ); ?>
				</label>
			<input 
				id="<?php echo $this->get_field_id( 'zoom' ); ?>" 
				name="<?php echo $this->get_field_name( 'zoom' ); ?>" 
				type="number" 
				min=".3" 
				max="2" 
				step="0.01" 
				value="<?php echo esc_attr( $zoom ); ?>" 
			/>
		</p>
		<?php 
	}
	
	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['url'] = ( ! empty( $new_instance['url'] ) ) ? strip_tags( $new_instance['url'] ) : '';
		$instance['zoom'] = ( ! empty( $new_instance['zoom'] ) ) ? $new_instance['zoom'] : '';
		return $instance;
	}
} // Class wpb_widget ends here


// Register and load the widget
function wpb_load_widget() {
	register_widget( 'wpb_widget' );
}
add_action( 'widgets_init', 'wpb_load_widget' );