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
			__('LeadBox / iFrame Widget', 'wpb_widget_domain'), 

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
				data-content-width="<?php echo $instance['contentWidth']; ?>"
				data-content-height-at-content-width="<?php echo $instance['contentHeightAtContentWidth']; ?>"
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
		
		// negativeXMargin
		if ( isset( $instance[ 'negativeXMargin' ] ) ) {
			$negativeXMargin = $instance['negativeXMargin'];
		} else {
			$negativeXMargin = '10px';
		}

		// contentWidth
		if ( isset( $instance[ 'contentWidth' ] ) ) {
			$contentWidth = $instance[ 'contentWidth' ];
		} else {
			$contentWidth = 350;
		}

		// contentHeightAtContentWidth
		if ( isset( $instance[ 'contentHeightAtContentWidth' ] ) ) {
			$contentHeightAtContentWidth = $instance[ 'contentHeightAtContentWidth' ];
		} else {
			$contentHeightAtContentWidth = 550;
		}


		?>
		<p>
			<b><label 
				for="<?php echo $this->get_field_id( 'url' ); ?>"><?php _e( 'Leadbox / iFrame URL:' ); ?>
				</label></b>
			<br>
			<input 
				class="widefat"
				id="<?php echo $this->get_field_id( 'url' ); ?>" 
				name="<?php echo $this->get_field_name( 'url' ); ?>" 
				type="text" 
				value="<?php echo esc_attr( $url ); ?>" 
			/>
		</p>
		<p>
			<b><label 
				for="<?php echo $this->get_field_id( 'negativeXMargin' ); ?>"><?php _e( 'Widget Expansion:' ); ?>
				</label></b>
			<br>
			<input 
				id="<?php echo $this->get_field_id( 'negativeXMargin' ); ?>" 
				name="<?php echo $this->get_field_name( 'negativeXMargin' ); ?>" 
				type="text"
				value="<?php echo esc_attr( $negativeXMargin ); ?>" 
			/>
			<br>
			<em><?php _e( '(e.g. "10px" or "10%")' ); ?></em>
		</p>
		<p>
			
			<b><label 
				for="<?php echo $this->get_field_id( 'contentWidth' ); ?>"><?php _e( 'Content&rsquo;s prettiest / ideal width:' ); ?>
				</label></b>
			<br>
			<?php _e( '(in pixels)' ); ?>
			<br>
			<input 
				id="<?php echo $this->get_field_id( 'contentWidth' ); ?>" 
				name="<?php echo $this->get_field_name( 'contentWidth' ); ?>" 
				type="number"
				value="<?php echo esc_attr( $contentWidth ); ?>" 
			/>
		</p>
		<p>
			
			<b><label 
				for="<?php echo $this->get_field_id( 'contentHeightAtContentWidth' ); ?>"><?php _e( 'Content&rsquo;s height at that ideal width:' ); ?>
				</label></b>
			<br>
			<?php _e( '(in pixels)' ); ?>
			<br>
			<input 
				id="<?php echo $this->get_field_id( 'contentHeightAtContentWidth' ); ?>" 
				name="<?php echo $this->get_field_name( 'contentHeightAtContentWidth' ); ?>" 
				type="number"
				value="<?php echo esc_attr( $contentHeightAtContentWidth ); ?>" 
			/>
			<br>
			<em><?php _e( 'If anything, be slightly generous on the height. Firefox is a good browser to use for this testing, because it renders text a bit bigger than other browsers.' ); ?></em>
		</p>
		<br>
		<br>
		<?php 
	}
	
	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['url'] = ( ! empty( $new_instance['url'] ) ) ? strip_tags( $new_instance['url'] ) : '';
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