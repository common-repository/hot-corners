<?php 
	
	// Add settings page
	function wphc_settings( ){
		add_options_page( 
			'Hot Corners', 
			'Hot Corners', 
			'manage_options', 
			'wphc-settings.php', 
			'wphc_settings_output' 
		);
	}
	add_action( 'admin_menu', 'wphc_settings');

	// Settings page outpu
	function wphc_settings_output( ){
		?>
		<div class="edit-overlay"></div>
		<div class="wrap wphc-settings">
			<div id="wphc-message-container"></div>
			<a target="_blank" class="beer" title="Beer me!" href="https://www.paypal.me/richardkeller" style="padding: 1em;position: absolute;top: 0;right: 0;"><img style="width:20px;" src="<?php echo plugin_dir_url( __FILE__ ) . '/assets/images/beercon.png' ?>" alt="Buy me a beer"></a>
			
			<?php
				// Setting parts
				wphc_hot_corners_editor();
				wphc_enable_corners_by_role();
				wphc_enable_hot_corners_for_user();
			?>
		</div>


		<?php
	}

	function wphc_hot_corners_editor( ){
		?>
		<h3>Hot Corner Editor</h3>

		<div class="wphc-item-list">
			<p>Drag items to a box. Each box represents a corner.</p>
			<div style="font-size:22px;text-align:center;margin-top:-10px;margin-bottom:10px;">&#10551;</div>
			
			<ul id="wphc-draggable-items">
				<?php

					wphc_get_item('admin'); 
					wphc_get_item('customizer');
					wphc_get_item('edit'); 
					wphc_get_item('new_post'); 
					wphc_get_item('hcsettings'); 
					wphc_get_item('logout'); 
				
				?>
			</ul>
		</div>

		<?php $corners = get_option( 'wphc-corners'); ?>

		<table class="wphc-table-corners">
			<thead>
				<td>
					<div id="wphc-saved-notice">Saved</div>
					<a id="wphc-trash" title="Drag items here to remove" style="background-image:url(<?php echo plugin_dir_url(__FILE__) . '/assets/images/trash.png' ?>);"></a>
				</td>
			</thead>
			<tr>
				<td>
					<div class="tl-corner corner">
						<label>Top Left Corner</label>
						<div class="corner-items">
							<ul id="tl-drop" class="droppable-area">
								<?php
									if (isset($corners['top_left'])) {									
										if( count($corners['top_left']) > 0 )  {
											foreach( $corners['top_left'] as $c ) {
												wphc_get_item($c);
											}
										}
									}
								?>
							</ul>
							<span class="empty">inactive</span>
						</div>
					</div>
				</td>
				<td>
					<div class="tr-corner corner">
						<label>Top Right Corner</label>
						<div class="corner-items">
							<ul id="tr-drop" class="droppable-area">
								<?php
									if (isset($corners['top_right'])) {
										if( count($corners['top_right']) > 0 )  {
											foreach( $corners['top_right'] as $c ) {
												wphc_get_item($c);
											}
										}
									}
								?>
							</ul>
							<span class="empty">inactive</span>
						</div>
					</div>
				</td>
			</tr>					
				<td>
					<div class="bl-corner corner">
						<label>Bottom Left Corner</label>
						<div class="corner-items">
							<ul id="bl-drop" class="droppable-area">
								<?php
									if (isset($corners['bottom_left'])) {
										if( count($corners['bottom_left']) > 0 )  {
											foreach( $corners['bottom_left'] as $c ) {
												wphc_get_item($c);
											}
										}
									}
								?>
							</ul>
							<span class="empty">inactive</span>
						</div>
					</div>
				</td>
				<td>
					<div class="br-corner corner">
						<label>Bottom Right Corner</label>
						<div class="corner-items">
							<ul id="br-drop" class="droppable-area">
								<?php
									if (isset($corners['bottom_right'])) {
										if( count($corners['bottom_right']) > 0 )  {
											foreach( $corners['bottom_right'] as $c ) {
												wphc_get_item($c);
											}
										}
									}
								?>
							</ul>
							<span class="empty">inactive</span>
						</div>
					</div>
				</td>
			</tr>
		</table>
		<pre>
		<?php 

			$toolbar = get_option( 'wphc_tool_bar_array' );
			// print_r( $toolbar );
			// global $wp_admin_bar;
			// print_r( $wp_admin_bar->get_nodes() );
			// echo 'test';
		?>
		</pre>
		<?php
	}

	function wphc_enable_hot_corners_for_user( ){
		$users = get_users();
		?>
		<h3>Enable Hot Corners by User</h3>
		<table class="wp-list-table widefat fixed striped posts" style="max-width: 518px;">
			<thead>
				<tr>
					<th>User</th>
					<th>Enabled</th>
				</tr>
			</thead>
			<tbody id="the-list">
				<?php  

				foreach( $users as $user ){

					$checked = '';

					$toolbar_status = get_user_meta($user->data->ID, 'show_admin_bar_front', true);

					if( $toolbar_status == 'true' ){
						$checked = '';
					} else {
						$checked = 'checked';
					}

					echo '<tr>';
					echo '<td>'.$user->data->user_login.'</td>';
					echo '<td><input class="toggle-wphc-user" user-id="'.$user->data->ID.'" type="checkbox" '.$checked.'>';
					echo '<span class="wphc-message"></span></td>';
					echo '</tr>';
				}

				?>
			</tbody>
		</table>
		<?php
	}

	function wphc_enable_corners_by_role( ){
		global $wp_roles;
    	$all_roles = $wp_roles->roles;

		?>
		<h3>Enable Hot Corners by Role</h3>
		<table class="wp-list-table widefat fixed striped posts" style="max-width: 518px;">
			<thead>
				<tr>
					<th>Role</th>
					<th>Enabled</th>
				</tr>
			</thead>
			<tbody id="the-list">
				<?php 

					$enabled_roles = get_option('wphc_enabled_roles');

					if( !$enabled_roles ) {
						$enabled_roles = array();
					}

					foreach( $all_roles as $role => $caps ){

						$checked = '';

						if( in_array($role, $enabled_roles) ) {
							$checked = 'checked';	
						}
						echo '<tr>';
						echo '<td>'.ucfirst($role).'</td>';
						echo '<td><input class="toggle-wphc-role" role-id="'.$role.'" type="checkbox" '.$checked.'>';
						echo '<span class="wphc-message"></span></td>';
						echo '</tr>';
					}

				?>
			</tbody>
		</table>
		<br>
		<?php
	}

?>
