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
});

