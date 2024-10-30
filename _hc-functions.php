<?php


// Load our scripts
add_action( 'admin_enqueue_scripts', 'wphc_enqueue_admin_scripts' );
function wphc_enqueue_admin_scripts( ){
    global $pagenow;

    if( isset($_GET['page']) ) {
        if( $pagenow == 'options-general.php' && $_GET['page'] == 'wphc-settings.php' ){
            wp_enqueue_script( 'rubaxa-sortable-plugin.js', plugin_dir_url( __FILE__ ) . '/assets/js/plugins/rubaxa-sortable-plugin.js', array(), 1, true );
            wp_enqueue_script( 'sortable.js', plugin_dir_url( __FILE__ ) . '/assets/js/plugins/sortable.js', array(), 1, true );
            wp_enqueue_script( 'admin.js', plugin_dir_url( __FILE__ ) . '/assets/js/admin.js', array('jquery') );
            wp_enqueue_style( 'admin.css', plugin_dir_url( __FILE__ ) . '/assets/css/admin.css' );
        }
    }

}

// Register this one option for all the corners
add_action( 'admin_init', 'wphc_register_options' );
function wphc_register_options( ){
    register_setting( 'wphc-option-group', 'wphc-corners' );
}

// Toggle WordPress default toolbar for users ajax
add_action( 'wp_ajax_wphc_toggle_toolbar', 'wphc_toggle_toolbar' );
function wphc_toggle_toolbar( ) {

    $user_id = $_POST['user_id'];
    $toolbar = $_POST['toolbar'];
    update_user_meta( $user_id, 'show_admin_bar_front', $toolbar );
    wp_die();
}

// Toggle WordPress default toolbar for users ajax
add_action( 'wp_ajax_wphc_toggle_toolbar_by_role', 'wphc_toggle_toolbar_by_role' );
function wphc_toggle_toolbar_by_role( ) {
    
    global $wpdb;

    $role_id = $_POST['role_id'];
    $toolbar = $_POST['toolbar'];

    $enabled_roles = get_option('wphc_enabled_roles');
    $enabled_roles = array_values(array_unique($enabled_roles));

    if( !$enabled_roles ) {
        $enabled_roles = array();
    }

    if( $toolbar == 'false' ) {

        for($i=0; $i < count($enabled_roles); $i++) {
            if( strpos( $enabled_roles[$i], $role_id ) !== false ){
                unset( $enabled_roles[$i] );
            }
        }
    } else {
        array_push($enabled_roles, $role_id);
    }
    update_option('wphc_enabled_roles', $enabled_roles);

    wp_die();
}

// Save corner data via ajax call
add_action( 'wp_ajax_wphc_save_corners', 'wphc_save_corners' );
function wphc_save_corners( ) {
    global $wpdb;

    $corners = $_POST['corners'];
    if( update_option( 'wphc-corners', $corners ) ){
        echo 'Saved';
    } else {
        echo 0;
    }
    wp_die();
}

function wphc_get_item( $name, $link = false ){

    switch ( $name ) {
        case 'admin':
            ?>
            <li class="draggable" data-id="admin">
                <span>Admin Link</span>
                <span class="drag-icon"></span>
            </li>
            <?php
            break;
        case 'customizer' :
            ?>
            <li class="draggable" data-id="customizer">
                <span>Customizer Link</span>
                <span class="drag-icon"></span>
            </li>
            <?php
            break;
        case 'edit' :
            ?>
            <li class="draggable" data-id="edit">
                <span>Edit Page Link</span>
                <span class="drag-icon"></span>
            </li>
            <?php
            break;
        case 'new_post' :
            ?>
            <li class="draggable" data-id="new_post">
                <span>New Post</span>
                <span class="drag-icon"></span>
            </li>
            <?php
            break;
        case 'hcsettings' :
            ?>
            <li class="draggable" data-id="hcsettings">
                <span>Hot Corner Settings</span>
                <span class="drag-icon"></span>
            </li>
            <?php
            break;
        case 'logout' :
            ?>
            <li class="draggable" data-id="logout">
                <span>Logout</span>
                <span class="drag-icon"></span>
            </li>
            <?php
            break;
        default:
            # code...
            break;
    }

}

function wphc_admin_bar_nodes() {
    global $wp_admin_bar;
    update_option( 'wphc_tool_bar_array', $wp_admin_bar->get_nodes() );
}
add_action( 'wp_before_admin_bar_render', 'wphc_admin_bar_nodes' );




function wphc_show_system_message( $message ){
    ?>
        <div id="message" class="updated notice notice-success is-dismissible below-h2">
            <p><?php echo $message; ?></p>
            <button type="button" class="notice-dismiss">
            <span class="screen-reader-text">Dismiss this notice.</span>
            </button>
        </div>
    <?php
}


?>
