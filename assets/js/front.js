(function(window, document) {

	"is strict";
	
	var corners = document.querySelectorAll('.wphc'),
		wphc_items = document.querySelectorAll('.wphc-items');

	// This prevents the buttons from animating out on load
	setTimeout(function(){
		for( var i=0; i < wphc_items.length; i++) {
			removeClass( wphc_items[i], 'wphc-hide' );
		}
	}, 600);

	for (var i = 0; i < corners.length; i++) {

		corners[i].addEventListener('mouseenter', function(){
			var _ = this;
			setTimeout(function(){
				addClass( _, 'wphc--visible');
			}, 200)
		});

		corners[i].addEventListener('mouseleave', function(){
			removeClass( this, 'wphc--visible');
		});

	}

	function addClass( el, name ){
		if( !el.className.match(name) ) {
			el.className = el.className + ' ' + name;
		}
	}

	function removeClass( el, name ){
		if( el.className.match(name) ) {
			el.className = el.className.replace(name, '');
		}
	}


})(window, document);