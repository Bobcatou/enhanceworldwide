<?php
/**
 * Modification of the Genesis Featured Page Widget
 * to add customizable text area option.
 * 
 */


add_action( 'widgets_init', create_function( '', "register_widget('WSM_CTA_Widget');" ) );


class WSM_CTA_Widget extends WP_Widget {

	/**
	 * Constructor. Set the default widget options and create widget.
	 */
	function WSM_CTA_Widget() {
		$widget_ops = array( 'classname' => 'wsm-cta', 'description' => __('Displays backgrounds and customizable headline and Link', 'genesis') );
		$control_ops = array( 'width' => 200, 'height' => 250, 'id_base' => 'wsm-cta-widget' );
		$this->WP_Widget( 'wsm-cta-widget', __('Web Savvy - CTA Widget', 'genesis'), $widget_ops, $control_ops );
	}

	/**
	 * Echo the widget content.
	 *
	 * @param array $args Display arguments including before_title, after_title, before_widget, and after_widget.
	 * @param array $instance The settings for the particular instance of the widget
	 */
	function widget($args, $instance) {
		extract($args);

		$instance = wp_parse_args( (array) $instance, array(
			'wsm-content' => '',
			'wsm-morelink' => '',
			'wsm-moretext' => '',
			'wsm-img-url' => '',
			'wsm-text-position' => '',
		) );
		
		
		echo $before_widget;
			
			// Set up the CTA
			
			if (!empty( $instance['wsm-img-url'] ) ) {
		
			echo '<div class="cta-box"> ';	
		//Begin changes to make CTA box image linkable and will not open in new tab	
            if (!empty( $instance['wsm-morelink'] ) ) {
			
			// Line below (line 51) _blank removed to line so image won't open on new tab.  August 24, 2014   BC 
				echo '<a href="'. esc_attr( $instance['wsm-morelink'] ) . '">';
            }
            if (!empty( $instance['wsm-img-url'] ) ) {
                echo'<img src="'. esc_attr( $instance['wsm-img-url'] ) . '" class="cta-img" alt="" />';
            }
            if (!empty( $instance['wsm-morelink'] ) ) {
                echo '</a>';
            }	
            //end changes	bc  					
				echo '<div class="cta-text"> ';
				
					if (!empty( $instance['wsm-content'] ) ) {
						$text = wp_kses_post($instance['wsm-content']);
						echo $text;
					}
					
					if (!empty( $instance['wsm-morelink'] ) && !empty( $instance['wsm-moretext'] ) ) {
		
			//Line below _blank removed to line so "learn more" won't open on new tab.  August 24, 2014   BC 
	 					echo '<span class="more-link"><a href="'. esc_attr( $instance['wsm-morelink'] ) . '">';
	 		//end changes
						echo esc_attr( $instance['wsm-moretext'] );
						echo '</a></span>';
					}

				echo '</div><!--end .cta-text-->';

				echo '</div><!--end .cta-box-->';
				
				
				}
				
				echo "\n\n";


		echo $after_widget;
		wp_reset_query();
	}

	/** Update a particular instance.
	 *
	 * This function should check that $new_instance is set correctly.
	 * The newly calculated value of $instance should be returned.
	 * If "false" is returned, the instance won't be saved/updated.
	 *
	 * @param array $new_instance New settings for this instance as input by the user via form()
	 * @param array $old_instance Old settings for this instance
	 * @return array Settings to save or bool false to cancel saving
	 */
	function update($new_instance, $old_instance) {
		$new_instance['wsm-content'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['wsm-content']) ) );
		$new_instance['wsm-morelink'] = strip_tags( $new_instance['wsm-morelink'] );
		$new_instance['wsm-img-url'] = strip_tags( $new_instance['wsm-img-url'] );
		$new_instance['wsm-moretext'] = strip_tags( $new_instance['wsm-moretext'] );

		return $new_instance;
	}

	/** Echo the settings update form.
	 *
	 * @param array $instance Current settings
	 */
	function form($instance) {

		$instance = wp_parse_args( (array)$instance, array(
			'wsm-content' => '',
			'wsm-morelink' => '',
			'wsm-moretext' => '',
			'wsm-img-url' => '',			
		) );
		
		$text = esc_attr($instance['wsm-content']);

?>
	<!-- CTA  -->
	
		<p><label for="<?php echo $this->get_field_id('wsm-content'); ?>"><?php _e('Custom Text:'); ?></label>
		<textarea class="widefat" rows="5" cols="8" id="<?php echo $this->get_field_id('wsm-content'); ?>" name="<?php echo $this->get_field_name('wsm-content'); ?>"><?php echo $text; ?></textarea></p>
		
		<p><label for="<?php echo $this->get_field_id('wsm-morelink'); ?>"><?php _e('Link', 'genesis'); ?>:</label>
		<input type="text" id="<?php echo $this->get_field_id('wsm-morelink'); ?>" name="<?php echo $this->get_field_name('wsm-morelink'); ?>" value="<?php echo esc_attr( $instance['wsm-morelink'] ); ?>" class="widefat" /></p>
				
		<p><label for="<?php echo $this->get_field_id('wsm-moretext'); ?>"><?php _e('Link Text', 'genesis'); ?>:</label>
		<input type="text" id="<?php echo $this->get_field_id('wsm-moretext'); ?>" name="<?php echo $this->get_field_name('wsm-moretext'); ?>" value="<?php echo esc_attr( $instance['wsm-moretext'] ); ?>" class="widefat" /></p>
			
		<p><label for="<?php echo $this->get_field_id('wsm-img-url'); ?>"><?php _e('Image URL ', 'genesis'); ?>:</label>
		<input type="text" id="<?php echo $this->get_field_id('wsm-img-url'); ?>" name="<?php echo $this->get_field_name('wsm-img-url'); ?>" value="<?php echo esc_attr( $instance['wsm-img-url'] ); ?>" class="widefat" /></p>
		
	<?php
	}
}