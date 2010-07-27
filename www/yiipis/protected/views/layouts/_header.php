<?php
/*
 * This file is part of YiiPIS
 *
 * @copyright Copyright &copy; 2010 Pogostick, LLC
 * @link http://www.pogostick.com Pogostick, LLC.
 * @license http://www.pogostick.com/licensing
 */

/**
 * _header main layout view
 *
 * @package 	yiipis
 * @subpackage 	views
 *
 * @author 		Jerry Ablan <jablan@pogostick.com>
 * @version 	SVN $Id$
 * @since 		v1.0.0
 *
 * @filesource
 */

//	Let's get the jQuery UI stuff going...
CPSjqUIWrapper::loadScripts();

$_user = Yii::app()->getUser()->isGuest ? null : Yii::app()->getUser();
$_name = $_user ? $_user->first_name_text : 'Fellow Yii Enthusiast';
$_link = PS::tag( 'li', array(), $_user ? PS::link( 'logout', 'logout' ) : PS::link( 'login', 'login' ) );

/*
$_extraLinks = PS::tag( 'li', array(), PS::link( 'About', 'site/about' ) ) .
	PS::tag( 'li', array(), PS::link( 'Contact', 'site/contact' ) ) .
	PS::tag( 'li', array(), PS::link( 'Download', 'site/download' ) );
*/
?>

<div id="header">

	<div id="header-logo"></div>

	<div id="header-menu" class="ul-menu">
		<ul>
			<li class="welcome-text">Welcome <?php echo $_name; ?></li>
			<?php echo $_link; ?>
			<?php //echo $_extraLinks; ?>
			<li><a href="site/help">faq</a></li>
		</ul>
	</div>

	<span id="header-current-page"><?php echo $this->getCleanTrail(); ?></span>

	<span id="show-hide-icon" class="yiipis-icon-tiny yiipis-icons-site yiipis-icon-hide yiipis-icon-state-active yiipis-icon-autohover"></span>

	<script type="text/javascript">
		//	Show/hide header bar...
		$(function(){
			$('span#show-hide-icon').click(function(e){
				var _header = $('div#header');
				var _logo = $('#header-logo',_header);
				var _menu = $('#header-menu',_header);

				//	Is header bar up? Slide it down then!
				if ( $(this).data('up') ) {
					$('div.curtain.top').hide('slide',{queue:false,direction:'up'});

					_logo.hide('slide',{queue:false,direction:'left',duration:'fast'});
						_menu.animate({marginTop:'2px'},500,function(){
					});

					$('#page').animate({marginTop:'125px'},300);

					_header.animate({marginTop: "0px"},300,function(){
						$('div.curtain.top').css({height:'40px',display:'none'}).fadeIn('normal',function(){
							_logo
								.removeClass('header-logo-short')
								.show('slide',{ direction: 'up', duration: 1500, easing: 'easeOutBounce'},function(){
								});
						});
						$('#header-current-page').animate({right:'25px'},300,function(){
							$('li.welcome-text').fadeIn();
						});
					});

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
					
					_menu.animate({marginTop:'75px'},300);
					$('#page').animate({marginTop:'45px'},300);

					_logo.hide('slide',{queue:false,direction:'up',duration:'fast'});

					_header.animate({marginTop: "-80px"},300,function(){
						$('#header-current-page').animate({right:'140px'},500);
						$('div.curtain.top').css({height:'20px'}).fadeIn();
						_logo
							.addClass('header-logo-short')
							.show('slide',{direction: 'down', duration: 1500, easing: 'easeOutBounce'});
					});

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
	</script>

</div>
