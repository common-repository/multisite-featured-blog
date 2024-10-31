<?php

add_action('admin_menu', 'mfb_create_menu');

function mfb_create_menu() {
 add_submenu_page('options-general.php',__('Featured Blogs','mfb'), __('Featured Blogs','mfb'),'manage_options', __FILE__.'mfb_settings_page','mfb_settings_page');
}


function mfb_settings_page() {
?>

<div class="wrap">

<?php
	global $blog_id;
 
	if( isset( $_POST['multisiteoptionssubmit'] ) )	{

		update_blog_option($blog_id,'multisite_featured_blog_list',$_POST['blogidlist']);
	}
		
	?>
	<div id="settingsform">
		<form id='mfbsettingform' method="post" action="">

		<h1><?php  _e('Multisite Featured Blog Setting:','mfb' ); ?></h1>
			
			<input type="hidden"  name="blogidlist" id="blogidlist"/>

			<br/>
	
			<label><?php  _e('Featured Blog List','mfb' );?></label><br/><br/>
			<select name="blogidlistbox" id="blogidlistbox" size="4" style="height: 100px;width:500px;">
			<?php
				$commaseparatedblogids = get_blog_option($blog_id , 'multisite_featured_blog_list');
				$commaseparatedblogids = str_replace (" ", "", $commaseparatedblogids);
				if(strlen($commaseparatedblogids) > 0 ) {
					$blogids = explode(',',$commaseparatedblogids);
									
					foreach($blogids as $blogid) {
						$blogname =  get_blog_details($blogid)->blogname; 
						echo '<option value="'.$blogid.'">'.$blogname.'</option>';
					}
				}
			?>
			  
			</select>
			<br/>
			
			 <input type="button" value="Remove Selected Blog" id="removeblogbutton" name="removeblogbutton"  onclick="removeSelectedBlog();"  />

			<br/><br/>

			<label><?php  _e('Enter the Blog ID:','mfb' );?></label>
			 <input type="text" name="blogid" id="blogid" />
		   
			  <input type="button" value="Get Blog Details" id="getblogdetailsbutton" name="getblogdetailsbutton"  onclick="getblogdetailsbuttonClicked();"  />
		
		  <div id="blogdetails">
		  </div>
			<br/><br/>
			<p class="submit">
			<input type="submit" id="multisiteoptionssubmit" name="multisiteoptionssubmit" class="button-primary" value="<?php _e('Save Changes','mfb') ?>" onclick="mfbsettingformsubmit();return false;"/>
			</p>

		</form>

	</div> 
	
</div>
<?php }


add_action( 'admin_enqueue_scripts', 'mfb_admin_enqueue_scripts' );

function mfb_admin_enqueue_scripts( $hook_suffix ) {

		wp_enqueue_script('multisitefeaturedblogscript', MULTISITEFEARUREDBLOGSURL.'/js/multisitefeaturedblogscript.js', array('jquery'));
		wp_enqueue_style( 'mfbcss', MULTISITEFEARUREDBLOGSURL.'/css/mfb.css');
}

function mfb_ajax_get_blog_details() {

	if ( is_user_logged_in() ) {
	  //get the data from ajax() call
	   $blogid = $_POST['blogid'];  
	   $blog_details = get_blog_details($blogid);

		if(is_object($blog_details)) {

		   $linkcontent = $blog_details->blogname;
		   if ( function_exists('get_blog_avatar') ) {
				$linkcontent.= get_blog_avatar($blogid);
		   }
			$results = '<a href="'.$blog_details->siteurl. '" rel="bookmark">'.$linkcontent.'</a>';
			$results.='<input type="button" value="Add This Blog" id="addblogbutton" name="addblogbutton"  onclick="addblogbuttonClicked('.$blogid.',\''.$blog_details->blogname.'\');"  />';
			$results.='<input type="button" value="Cancel" id="cancelblogbutton" name="cancelblogbutton"  onclick="cancelblogbuttonClicked('.$blogid.');"  />';
		}
		else
			$results = __("Error While fetching blog details",'mfb');
	}
 
  // Return the String
   die($results);
}

// creating Ajax call for WordPress
add_action( 'wp_ajax_nopriv_mfb_ajax_get_blog_details', 'mfb_ajax_get_blog_details' );
add_action( 'wp_ajax_mfb_ajax_get_blog_details', 'mfb_ajax_get_blog_details' );


?>