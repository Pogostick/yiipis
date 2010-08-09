$(function(){
	var _popClose = function( element ) {
		$(element).removeClass('opened');
		$(element).parent().find('ul.footer-menu-sub-menu').css({zIndex:999,bottom:'35px'}).slideUp({duration:500,easing:'easeInExpo'});
	}

	var _popOpen = function( element, clicked ) {
		if ( ! $(element).hasClass( 'opened' ) ) {
			if ( clicked ) {
				$('ul.footer-menu-top-menu li ul.footer-menu-sub-menu').css({zIndex:999}).slideUp('fast');
				$('ul.footer-menu-top-menu span.footer-menu-nav-button').removeClass('opened');
			}
			$(element).addClass('opened');
			$(element).parent().find('ul.footer-menu-sub-menu').css({zIndex:1000,bottom:'35px'}).slideDown({duration:500,easing:'easeOutExpo'});
		}
	}

	$('ul.footer-menu-top-menu li').append('<span class="footer-menu-nav-button"></span>');

	$('ul.footer-menu-top-menu span.footer-menu-nav-button')
		.click(function(e) {
			e.preventDefault();

			//	If it's open? Close it.
			if ( $(this).parent().find('ul.footer-menu-sub-menu').is(':visible') ) {
				_popClose( this, true );
			} else {
				_popOpen( this, true );
			}
			
			return false;
		});
});
