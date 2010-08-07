//	Show/hide header bar...
$(function(){
	if ( $.browser.webkit ) {
		$('div#page').css({marginBottom:'-62px'});
		$('div#content-wrapper').css({paddingBottom:'62px'});
	} else {
		$('div#page').css({marginBottom:'-36px'});
		$('div#content-wrapper').css({paddingBottom:'36px'});
	}

	$('div#footer').fadeIn('slow');

	$('span#show-hide-icon').click(function(e){
		var _header = $('div#header');
		var _footer = $('div#footer').hide();
		var _logo = $('#header-logo',_header);
		var _menu = $('#header-menu',_header);

		//	Is header bar up? Slide it down then!
		if ( $(this).data('up') ) {
			$('div.curtain.top').hide();
			$('li.welcome-text').fadeOut();

			_logo.hide('drop',{queue:false,direction:'up',duration:'fast'});
				_menu.animate({marginTop:'2px'},500,function(){
			});

			_footer.fadeOut('fast',function(){
				_header.animate({marginTop: "-125px"},300,function(){
					_logo
						.removeClass('header-logo-short')
						.show('slide',{ direction: 'up', duration: 1500, easing: 'easeOutBounce'},function(){
						});

					$('#header-current-page').animate({right:'25px'},300);
					$('div.curtain.top').css({height:'40px'}).fadeIn();
					$('li.welcome-text').fadeIn();

				});
			}).animate({marginTop:'0px'},300).fadeIn();

			if ( $.browser.webkit ) {
				$('div#page').css({marginBottom:'-62px'});
				$('div#content-wrapper').css({paddingBottom:'62px'});
			}

			$(this).fadeOut('fast',function(){
				$(this)
					.removeClass('yiipis-icon-show')
					.addClass('yiipis-icon-hide')
					.fadeIn();
					$('li.welcome-text').fadeIn();
			});

			$(this).data('up',false);
		} else {
			//	Header bar is down. Let's slide it up real nice!
			$('div.curtain.top').hide('slide',{queue:false,direction:'up'});
			$('li.welcome-text').fadeOut();
			$('div#page').css({marginBottom:'-36px'});

			//	Slide up the header...
			_menu.hide().css({marginTop:'73px'});

			_logo.hide('slide',{queue:false,direction:'up',duration:'fast'});

			_footer.fadeOut('fast',function(){
				_header.animate({marginTop: "-200px"},200,function(){
					$('#header-current-page').animate({right:'140px'},500,function(){
						_menu.fadeIn();
					});

					$('div.curtain.top').css({height:'20px'}).fadeIn();
				});

				_logo
					.addClass('header-logo-short')
					.show('slide',{direction: 'up', duration: 1500, easing: 'easeOutBounce'});
			}).animate({marginTop:'75px'},300).fadeIn();

			$(this).fadeOut('fast',function(){
				$(this)
					.removeClass('yiipis-icon-hide')
					.addClass('yiipis-icon-show')
					.fadeIn();
			});

			$(this).data('up',true);
		}
	});
});
