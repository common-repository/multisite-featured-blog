<?php


class MultiSiteFeaturedBlogWidget extends WP_Widget {

	function MultiSiteFeaturedBlogWidget() {
		// widget actual processes
		$widget_ops = array('classname' => 'MultiSiteFeaturedBlogWidget', 'description' => __('Widget to choose featured blogs and display posts,avatar etc for them.','mfb') );
		$this->WP_Widget('MultiSiteFeaturedBlogWidget', __('MultiSiteFeaturedBlogWidget','mfb'), $widget_ops);
	}

	function form($instance) {
		// outputs the options form on admin
		 $defaults = array( 'title' => __('Featured Blogs','mfb'), 'blogids' => '' );
		 $instance = wp_parse_args( (array) $instance, $defaults );
		 
		 ?>
		 <p>
		 <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:','mfb' ); ?></label>
		 <input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" class="widefat" />
		 </p>
		 <p>
		 <label for="<?php echo $this->get_field_id( 'blogids' ); ?>"><?php _e('Blog Ids: Separated By comma ,','mfb'); ?></label>
		 <input id="<?php echo $this->get_field_id( 'blogids' ); ?>" name="<?php echo $this->get_field_name( 'blogids' ); ?>" value="<?php echo $instance['blogids']; ?>" class="widefat" />
		 </p>

		<?php
		 
	}

	function update($new_instance, $old_instance) {
		// processes widget options to be saved

		 $instance = $old_instance;
		 $instance['title'] = strip_tags( $new_instance['title'] );
		 $instance['blogids'] = $new_instance['blogids'];
		 return $instance;
	}

	function widget($args, $instance) {
		// outputs the content of the widget
		 extract( $args );
		 $title = apply_filters('widget_title', $instance['title'] );
		 echo $before_widget;
		 if ( $title )
			echo $before_title . $title . $after_title;
			
		 echo '<ul>';
		 echo mfb_get_all_posts_for_specified_blogs($instance['blogids']);
 		 echo '</ul>';
		 echo $after_widget;
	}

}

function mfb_widget_init() {

	// Check for the required API functions
	if ( !function_exists('register_widget') )
		return;
	
	register_widget('MultiSiteFeaturedBlogWidget');
}

add_action('widgets_init', 'mfb_widget_init');

?>