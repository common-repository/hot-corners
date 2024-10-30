<?php

/**
 * Activation setup
 */
register_activation_hook( __FILE__, 'wphc_add_default_options_on_activate' );

function wphc_add_default_options_on_activate() {

    $defaults = array(
        'top_left' => array(
            'admin',
            'customizer',
            'edit',
            'hcsettings'
        ),
        'top_right' => array(),
        'bottom_left' => array(),
        'bottom_right' => array()
    );
    
    if (!get_option('wphc-corners')){
    	update_option( 'wphc-corners', $defaults );
    }
    $current_user_id = get_current_user_id();
    update_user_meta( $current_user_id, 'show_admin_bar_front', false );
}

add_action('admin_notices', 'wphc_plugin_activation_message');

function wphc_plugin_activation_message() {
	if( !get_option('wphc-special-message') ) {

	?>
		<div id="message" class="updated notice is-dismissible">
			<p>
			Thanks for trying Hot Corners! Check out the 
			<a href="<?php echo admin_url( 'options-general.php?page=wphc-settings.php' ) ?>">
					settings page.
				</a>
			</p>
			<button type="button" class="notice-dismiss">
				<span class="screen-reader-text">Dismiss this notice.</span>
			</button>
		</div>
	<?php
		update_option( 'wphc-special-message', true );
	}
}

register_deactivation_hook( __FILE__, 'wphc_plugin_deactivate' );

function wphc_plugin_deactivate() {
	delete_option( 'wphc-special-message' );
}

?>