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
			__('LeadBox iFrame Widget', 'wpb_widget_domain'), 

			// Widget description
			array( 'description' => __( 'Places a LeadBox (or other) iframe, and provides controls to assure it displays well at all screen-widths', 'wpb_widget_domain' ), ) 
			);
	}

	// Creating widget front-end
	// This is where the action happens
	public function widget( $args, $instance ) {		

		// before and after widget arguments are defined by themes
		echo $args['before_widget'];


		$widthStr = sprintf("%.2f%%", ( 1 / $instance['zoom'] ) * 100)


		?>
		<style>
		    #wrap { padding: 0; /* todo: bring this to js, making sure it doesn't overflow narrow devices: */ margin: 0 -<?php echo $instance['negativeXMargin']?> 0 -<?php echo $instance['negativeXMargin']?>; }
		    #frame { /*max-width: <?php echo $widthStr ?>; width: <?php echo $widthStr ?>; height: 680px;*/ border: 1px solid black; }
		    /*#frame {
		        -ms-zoom: <?php echo $instance['zoom']; ?>;
		        -moz-transform: scale( <?php echo $instance['zoom']; ?> );
		        -moz-transform-origin: 0 0;
		        -o-transform: scale( <?php echo $instance['zoom']; ?> );
		        -o-transform-origin: 0 0;
		        -webkit-transform: scale( <?php echo $instance['zoom']; ?> );
		        -webkit-transform-origin: 0 0;
		    }*/
		</style>
		<div id="wrap" class-NOT="scaleBoxWrapper">
			<iframe 
				class="scaleBox"
				src="<?php echo $instance['url']; ?>"
				frameborder="0"
				id="frame"
				data-content-width="350"
				data-content-height-at-content-width="550"
			></iframe>
		</div>
		<?php
		echo $args['after_widget'];
	}

	// Widget Backend 
	public function form( $instance ) {
		
		// url
		if ( isset( $instance[ 'url' ] ) && $instance['url'] ) {
			$url = $instance[ 'url' ];
		} else {
			$url = self::DEFAULT_LEADBOX_URL;
		}

		// zoom
		// if ( isset( $instance[ 'zoom' ] ) ) {
		// 	$zoom = $instance[ 'zoom' ];
		// } else {
		// 	$zoom = .9;
		// }
		
		// negativeXMargin
		if ( isset( $instance[ 'negativeXMargin' ] ) ) {
			$negativeXMargin = $instance['negativeXMargin'];
		} else {
			$negativeXMargin = '10px';
		}



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
		</p>
		<!-- <p>
			
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
		</p> -->
		<p>
			<label 
				for="<?php echo $this->get_field_id( 'negativeXMargin' ); ?>"><?php _e( 'Widget Expansion:' ); ?>
				</label>
			<input 
				id="<?php echo $this->get_field_id( 'negativeXMargin' ); ?>" 
				name="<?php echo $this->get_field_name( 'negativeXMargin' ); ?>" 
				type="text"
				value="<?php echo esc_attr( $negativeXMargin ); ?>" 
			/>
			<br><em><?php _e( '(e.g. "10px" or "10%")' ); ?></em>
		</p>
		<p>
			
			<label 
				for="<?php echo $this->get_field_id( 'contentWidth' ); ?>"><?php _e( 'contentWidth:' ); ?>
				</label>
			<input 
				id="<?php echo $this->get_field_id( 'contentWidth' ); ?>" 
				name="<?php echo $this->get_field_name( 'contentWidth' ); ?>" 
				type="number"
				value="<?php echo esc_attr( $contentWidth ); ?>" 
			/>
		</p>
		<p>
			
			<label 
				for="<?php echo $this->get_field_id( 'contentHeightAtContentWidth' ); ?>"><?php _e( 'contentHeightAtContentWidth:' ); ?>
				</label>
			<input 
				id="<?php echo $this->get_field_id( 'contentHeightAtContentWidth' ); ?>" 
				name="<?php echo $this->get_field_name( 'contentHeightAtContentWidth' ); ?>" 
				type="number"
				value="<?php echo esc_attr( $contentHeightAtContentWidth ); ?>" 
			/>
		</p>
		<?php 
	}
	
	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['url'] = ( ! empty( $new_instance['url'] ) ) ? strip_tags( $new_instance['url'] ) : '';
		// $instance['zoom'] = ( ! empty( $new_instance['zoom'] ) ) ? strip_tags( $new_instance['zoom'] ) : '';
		$instance['contentWidth'] = ( ! empty( $new_instance['contentWidth'] ) ) ? strip_tags( $new_instance['contentWidth'] ) : '';
		$instance['contentHeightAtContentWidth'] = ( ! empty( $new_instance['contentHeightAtContentWidth'] ) ) ? strip_tags( $new_instance['contentHeightAtContentWidth'] ) : '';
		$instance['negativeXMargin'] = ( ! empty( $new_instance['negativeXMargin'] ) ) ? strip_tags( $new_instance['negativeXMargin'] ) : '';
		return $instance;
	}
} // Class wpb_widget ends here


// Register and load the widget
function wpb_load_widget() {
	register_widget( 'wpb_widget' );
}
add_action( 'widgets_init', 'wpb_load_widget' );