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

//	Load our module specific CSS
PS::_rcf( '/css/layouts/_header.css' );
PS::_rsf( '/scripts/site.header.js' );
?>
<!-- some cool curtains if you have a cool browser -->
<div class="reflection curtain" style="top: 4727px; "></div>
<div class="curtain top"></div>

<div id="header">

	<div id="header-logo"></div>

	<div id="header-menu" class="ul-menu">
		<ul>
			<li class="welcome-text">Welcome <?php echo $_name; ?></li>
			<?php echo $_link; ?>
			<?php //echo $_extraLinks; ?>
			<li><a href="/">faq</a></li>
		</ul>
	</div>

	<span id="header-current-page"><?php echo $this->getCleanTrail(); ?></span>

	<span id="show-hide-icon" class="yiipis-icon-tiny yiipis-icons-site yiipis-icon-hide yiipis-icon-state-active yiipis-icon-autohover"></span>

</div>
