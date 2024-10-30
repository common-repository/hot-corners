//ADMIN
jQuery(document).ready(function($){

	$(document).on('change', '.wphc-settings .toggle-wphc-user', function(){

		var toolbar = 'true';
		var user_id = $(this).attr('user-id');
		var el = $(this);

		if( $(this).is(':checked') ){
			toolbar = 'false';
		}

		$.ajax({
			method: 'POST',
			url: ajaxurl,
			data: {
				action: 'wphc_toggle_toolbar',
				user_id: user_id,
				toolbar: toolbar
			}
		}).success(function(res){
			el.next('.wphc-message').text('Saved').show();
			setTimeout(function(){
				el.next('.wphc-message').fadeOut();
			}, 500)
		}).error(function(){
			el.next('.wphc-message').text('There was an error. Check connection. Are you logged in?').show();
		});

	});

	$(document).on('change', '.wphc-settings .toggle-wphc-role', function(){

		var toolbar = false;
		var role_id = $(this).attr('role-id');
		var el = $(this);

		if( $(this).is(':checked') ){
			toolbar = true
		}

		$.ajax({
			method: 'POST',
			url: ajaxurl,
			data: {
				action: 'wphc_toggle_toolbar_by_role',
				role_id: role_id,
				toolbar: toolbar
			}
		}).success(function(res){
			el.next('.wphc-message').text('Saved').show();
			setTimeout(function(){
				el.next('.wphc-message').fadeOut();
			}, 500)
		}).error(function(){
			el.next('.wphc-message').text('There was an error. Check connection. Are you logged in?').show();
		});

	});

	
});