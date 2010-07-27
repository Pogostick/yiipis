/*
 * This file is part of YiiPIS
 *
 * @copyright Copyright &copy; 2010 Pogostick, LLC
 * @link http://www.pogostick.com Pogostick, LLC.
 * @license http://www.pogostick.com/licensing
 */

/**
 * site.jquery.js site-level javascript functions
 *
 * @package 	yiipis
 * @subpackage 	scripts
 *
 * @author 		Jerry Ablan <jablan@pogostick.com>
 * @version 	SVN $Id$
 * @since 		v1.0.0
 *
 * @filesource
 */

$(function() {
	$('.yiipis-icon-autohover').live('mouseover mouseout',function(e) {
		if (e.type == 'mouseover') {
			$(this).removeClass('yiipis-icon-state-active').addClass('yiipis-icon-state-hover');
		} else {
			$(this).removeClass('yiipis-icon-state-hover').addClass('yiipis-icon-state-active');
		}
	});

	/**
	 * A generic catch-all hover icon doohickey.
	 * Basically define a block and set the "rel" attribute to the name of the hover class.
	 */
	$('div.hoverable,span.hoverable').live('mouseover mouseout',function(e) {
		var _hoverClass = $(this).attr('rel');

		if ( _hoverClass ) {
			if (e.type == 'mouseover') {
				$(this).addClass(_hoverClass);
			} else {
				$(this).removeClass(_hoverClass);
			}
		}
	});

	$('#header-logo').click(function(e){
		e.preventDefault();
		window.location.href = '/';
		return false;
	})
});

