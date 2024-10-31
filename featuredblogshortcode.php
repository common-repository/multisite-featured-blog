<?php
function mfb_shortcode($atts, $content = null) {

	global $blog_id;

	extract(shortcode_atts(array('blogids' => ''), $atts));
	
	if(strlen($blogids) > 0 )
		 return '<ul>' .  mfb_get_all_posts_for_specified_blogs($blogids) . '</ul>';
	else {

		$blogids = get_blog_option($blog_id , 'multisite_featured_blog_list');
		if(strlen($blogids) > 0 )
		 return '<ul>' .  mfb_get_all_posts_for_specified_blogs($blogids) . '</ul>';
	}
}
add_shortcode('multisite_featured_blogs', 'mfb_shortcode');

?>