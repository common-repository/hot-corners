<?php
/**
 * All output to front end
 *
 *
 */

function wphc_hot_corners_main(){
  global $post;
  
  $current_user_id = get_current_user_id();
  $corners_enabled = false;

  if( !$current_user_id )
    return;

	$user_data = get_userdata($current_user_id);
	$enabled_roles = get_option('wphc_enabled_roles');
	$new_array = @array_intersect($enabled_roles, $user_data->roles);
		
	if( $new_array && count($new_array) > 0 ) {

		$corners_enabled = true;
		echo '<style>html{margin-top:0!important;}#wpadminbar{display:none!important;}</style>';
	
	} else {

		$admin_bar = get_user_meta( $current_user_id, 'show_admin_bar_front', true );

		if( $admin_bar == 'true' ){ 
			$corners_enabled = false;
		} else {
			$corners_enabled = true;
		}
	
	}

	// No need to doing if user is not logged in.
	if( !$corners_enabled )
		return;

	wp_enqueue_script( 'wp-hot-corners-js', plugin_dir_url( __FILE__ ) . '/assets/js/front.js', array('jquery'), '', true );
	wp_enqueue_style( 'wp-hot-corners-css', plugin_dir_url( __FILE__ ) . '/assets/css/front.css', array(), 1, '' );

	$admin_url = admin_url();
	$current_url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; 
	$customizer_url = $admin_url . 'customize.php?url=' . urlencode($current_url);


	// Set the post edit url
	$id = $post->ID;
	$edit_url = $admin_url . 'post.php?post=' . $id . '&action=edit';
	$front_id = get_option('page_on_front');
	$blog_id = get_option('page_for_posts');

	if ( is_front_page() && is_home() ) {
		$edit_url = $admin_url . 'edit.php';
	} elseif ( is_front_page() ) {
		$edit_url = $admin_url . 'post.php?post=' . $front_id . '&action=edit';
	} elseif ( is_home() ) {
		$edit_url = $admin_url . 'post.php?post=' . $home_id . '&action=edit';
	} else {
		$edit_url = $admin_url . 'post.php?post=' . $id . '&action=edit';
  }
  
  $new_post_link = $admin_url . "post-new.php";

  $new_post_link = "<a href='$new_post_link'>New Post</a>";
	$edit_link = '<a href="'. $edit_url . '">Edit Post</a>';
	$admin_link = '<a href="'.$admin_url.'">Dashboard</a>';
	$cust_link = '<a href="'.$customizer_url.'">Customizer</a>';
  
	$links = array(
		'admin' => $admin_link,
		'edit'  => $edit_link,
		'new_post'  => $new_post_link,
		'customizer' => $cust_link,
		'hcsettings' => '<a href="'.admin_url('options-general.php?page=wphc-settings.php').'">Hot Corners Settings</a>',
		'logout' => '<a href="'.wp_logout_url().'">Logout</a>'
	);

	$corners = get_option( 'wphc-corners' );


	?>
	<?php if( isset($corners['top_left']) ) : ?>
	<div class="wphc wphc-hover-area tl">
		<div class="radar"></div>
		<div class="radar2"></div>
		<div class="radar3"></div>
		<div class="wphc-items wphc-hide tl">
			<?php
				if( count(@$corners['top_left']) > 0 )  {
					foreach( $corners['top_left'] as $c ) {
						echo $links[$c];
					}
				}
			?>
		</div>		
	</div>
	<?php endif; ?>
	<?php if( isset($corners['top_right']) ) : ?>
	<div class="wphc wphc-hover-area tr">
		<div class="radar"></div>
		<div class="radar2"></div>
		<div class="radar3"></div>
		<div class="wphc-items wphc-hide tr">
			<?php
				if( count(@$corners['top_right']) > 0 )  {
					foreach( $corners['top_right'] as $c ) {
						echo $links[$c];
					}
				}
			?>
		</div>	
	</div>
	<?php endif; ?>
	<?php if( isset($corners['bottom_left']) ) : ?>
	<div class="wphc wphc-hover-area bl">
		<div class="radar"></div>
		<div class="radar2"></div>
		<div class="radar3"></div>
		<div class="wphc-items wphc-hide bl">
			<?php
				if( count(@$corners['bottom_left']) > 0 )  {
					foreach( $corners['bottom_left'] as $c ) {
						echo $links[$c];
					}
				}
			?>
		</div>	
	</div>
	<?php endif; ?>
	<?php if( isset($corners['bottom_right']) ) : ?>
	<div class="wphc wphc-hover-area br">
		<div class="radar"></div>
		<div class="radar2"></div>
		<div class="radar3"></div>
		<div class="wphc-items wphc-hide br">
			<?php
				if( count(@$corners['bottom_right']) > 0 )  {
					foreach( $corners['bottom_right'] as $c ) {
						echo $links[$c];
					}
				}
			?>
		</div>	
	</div>
	<?php endif; ?>
	<?php

}
add_action('wp_footer', 'wphc_hot_corners_main');

?>
