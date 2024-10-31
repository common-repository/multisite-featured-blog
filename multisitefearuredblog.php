<?php
/*
Plugin Name: Multisite Featured Blog
Plugin URI: 
Description: This plugin provies you with an widget and shortcode to choose featured blogs and display posts,avatar etc for them.
Author: Abbas Suterwala
Version: 1.0
Author URI: http://www.abbassuterwala.com 
*/


define('MULTISITEFEARUREDBLOGSURL', WP_PLUGIN_URL."/multisite-featured-blog" );
define('MULTISITEFEARUREDBLOGSPATH', WP_PLUGIN_DIR."/multisite-featured-blog" ); 


function mfb_get_all_posts_for_blog($blog_id) {
	
	$output = '';
	wp_reset_query();
	switch_to_blog($blog_id);

	global $post;
	$my_query = new WP_Query('order=DSC&posts_per_page=5');
	while ($my_query->have_posts()) : $my_query->the_post();
	    $output .='<li class="post_link"><a href="'.get_permalink(). '" rel="bookmark">'.get_the_title().'</a> </li>';
    endwhile; 
	
	restore_current_blog();

	return $output;
}

function mfb_get_all_posts_for_specified_blogs($commaseparatedblogids){

	global $blog_id;
	$commaseparatedblogids = str_replace (" ", "", $commaseparatedblogids);
	if(strlen($commaseparatedblogids) == 0 ) $commaseparatedblogids = get_blog_option($blog_id , 'multisite_featured_blog_list');

	$output = '';

	if(strlen($commaseparatedblogids) > 0 ) {

		$blogids = explode(',',$commaseparatedblogids);
		
		foreach($blogids as $blogid) {

			$blog_details = get_blog_details($blogid);
			$output .='<li class="blog_link"><a href="'.$blog_details->siteurl. '" rel="bookmark">'.$blog_details->blogname.'</a> </li>';
			$output.='<ul>'.mfb_get_all_posts_for_blog($blogid).'</ul>';
		}
	}

	return $output;
}
add_action('init', 'mfb_init');

function mfb_init() {
	if ( !is_multisite() )
		exit( 'The plugin is only compatible with WordPress Multisite.' );

	load_plugin_textdomain('mfb', false, dirname(plugin_basename(__FILE__)).'/languages');
}

include MULTISITEFEARUREDBLOGSPATH.'/featuredblogwidget.php';
include MULTISITEFEARUREDBLOGSPATH.'/featuredblogshortcode.php';
include MULTISITEFEARUREDBLOGSPATH.'/settings.php';


