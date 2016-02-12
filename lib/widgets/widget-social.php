<?php
/**
 * Social Widget
 *
 * Displays links to Facebook, Twitter and Youtube
 *
 */
class wsm_Social_Widget extends WP_Widget {
	
    /**
     * Constructor
     *
     * @return void
     **/
	function wsm_Social_Widget() {
		$widget_ops = array( 'classname' => 'widget-social', 'description' => 'Social icon widget' );
		$this->WP_Widget( 'social-widget', 'Web Savvy - Social Widget', $widget_ops );
	}

    /**
     * Outputs the HTML for this widget.
     *
     * @param array  An array of standard parameters for widgets in this theme 
     * @param array  An array of settings for this widget instance 
     * @return void Echoes it's output
     **/
	function widget( $args, $instance ) {
		extract( $args, EXTR_SKIP );
		echo $before_widget;
		
		echo '<span class="social-media">';
		
		if(!empty($instance['wsm_twitter'])) { 
		echo '<a href="'. $instance['wsm_twitter'] .'" class="btn-tw" target="_blank">Twitter</a>';
		}
		
		if(!empty($instance['wsm_facebook'])) { 
		echo '<a href="'. $instance['wsm_facebook'] .'" class="btn-fb" target="_blank">Facebook</a>';
		}
		
		if(!empty($instance['wsm_googleplus'])) { 
		echo '<a href="'. $instance['wsm_googleplus'] .'" class="btn-gp" target="_blank">Google+</a>';
		}
		
		if(!empty($instance['wsm_pinterest'])) { 
		echo '<a href="'. $instance['wsm_pinterest'] .'" class="btn-pi" target="_blank">Pinterest</a>';		
		}
		
		if(!empty($instance['wsm_youtube'])) { 
		echo '<a href="'. $instance['wsm_youtube'] .'" class="btn-yt" target="_blank">Youtube</a>';
		}
		echo '</span>';
		echo $after_widget;
	}

    /**
     * Deals with the settings when they are saved by the admin. Here is
     * where any validation should be dealt with.
     *
     * @param array  An array of new settings as submitted by the admin
     * @param array  An array of the previous settings 
     * @return array The validated and (if necessary) amended settings
     **/
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
	
		$instance['wsm_facebook'] = esc_url( $new_instance['wsm_facebook'] );
		$instance['wsm_twitter'] = esc_url( $new_instance['wsm_twitter'] );
		$instance['wsm_pinterest'] = esc_url( $new_instance['wsm_pinterest'] );
		$instance['wsm_youtube'] = esc_url( $new_instance['wsm_youtube'] );
		$instance['wsm_googleplus'] = esc_url( $new_instance['wsm_googleplus'] );		
		return $instance;
	}

    /**
     * Displays the form for this widget on the Widgets page of the WP Admin area.
     *
     * @param array  An array of the current settings for this widget
     * @return void Echoes it's output
     **/
	function form( $instance ) {
	
		$defaults = array( 'wsm_facebook' => '', 'wsm_twitter' => '', 'wsm_youtube' => '', 'wsm_pinterest' => '', 'wsm_googleplus' => '' );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<p><label for="<?php echo $this->get_field_id( 'wsm_twitter' ); ?>">Twitter URL: <input class="widefat" id="<?php echo $this->get_field_id( 'wsm_twitter' ); ?>" name="<?php echo $this->get_field_name( 'wsm_twitter' ); ?>" value="<?php echo $instance['wsm_twitter']; ?>" /></label></p>
	
		<p><label for="<?php echo $this->get_field_id( 'wsm_facebook' ); ?>">Facebook URL: <input class="widefat" id="<?php echo $this->get_field_id( 'wsm_facebook' ); ?>" name="<?php echo $this->get_field_name( 'wsm_facebook' ); ?>" value="<?php echo $instance['wsm_facebook']; ?>" /></label></p>
		
		<p><label for="<?php echo $this->get_field_id( 'wsm_googleplus' ); ?>">Google+ URL: <input class="widefat" id="<?php echo $this->get_field_id( 'wsm_googleplus' ); ?>" name="<?php echo $this->get_field_name( 'wsm_googleplus' ); ?>" value="<?php echo $instance['wsm_googleplus']; ?>" /></label></p>

		<p><label for="<?php echo $this->get_field_id( 'wsm_pinterest' ); ?>">Pinterest URL: <input class="widefat" id="<?php echo $this->get_field_id( 'wsm_pinterest' ); ?>" name="<?php echo $this->get_field_name( 'wsm_pinterest' ); ?>" value="<?php echo $instance['wsm_pinterest']; ?>" /></label></p>
		
		<p><label for="<?php echo $this->get_field_id( 'wsm_youtube' ); ?>">Youtube URL: <input class="widefat" id="<?php echo $this->get_field_id( 'wsm_youtube' ); ?>" name="<?php echo $this->get_field_name( 'wsm_youtube' ); ?>" value="<?php echo $instance['wsm_youtube']; ?>" /></label></p>
		
		<?php

	}
}

add_action( 'widgets_init', create_function( '', "register_widget('wsm_Social_Widget');" ) );