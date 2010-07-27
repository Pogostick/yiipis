<?php
/*
 * This file is part of YiiPIS
 *
 * @copyright Copyright &copy; 2010 Pogostick, LLC
 * @link http://www.pogostick.com Pogostick, LLC.
 * @license http://www.pogostick.com/licensing
 */

/**
 * _footer main layout view
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

//	How about a nice tooltip for our logo?
//CPSjqToolsWrapper::create( 'tooltip', array( 'target' => '#footer-copyright', 'effect' => 'bouncy', 'tip' => '.yiipis-tooltip' ) );
//PS::_rsf( '/scripts/site.tooltip.js' );
?>

<div id="footer">
	<span id="footer-menu" class="footer-block">
		<div class="ul-menu">
			<ul>
				<li><a href="apps">Apps<span id="apps-toggle" style="top:1px;margin-left:5px;" class="yiipis-icon-tiny yiipis-icons-site yiipis-icon-hide yiipis-icon-state-active yiipis-icon-autohover"></span></a></li>
				<li><a href="configs">Configs<span id="configs-toggle" style="top:1px;margin-left:5px;" class="yiipis-icon-tiny yiipis-icons-site yiipis-icon-hide yiipis-icon-state-active yiipis-icon-autohover"></span></a></li>
				<li><a href="extensions">Extensions<span id="extensions-toggle" style="top:1px;margin-left:5px;" class="yiipis-icon-tiny yiipis-icons-site yiipis-icon-hide yiipis-icon-state-active yiipis-icon-autohover"></span></a></li>
				<li><a href="community">Community<span id="community-toggle" style="top:1px;margin-left:5px;" class="yiipis-icon-tiny yiipis-icons-site yiipis-icon-hide yiipis-icon-state-active yiipis-icon-autohover"></span></a></li>
			</ul>
		</div>
	</span>

	<span class="faux-spacer"></span>

	<span id="footer-copyright" class="footer-block">
		<span style="color:#e6592d">YiiPIS</span> is <span id="yii-powered">powered by the <a target="_blank" href="http://www.yiiframework.com/">Yii Framework</a><span class="yii-icon"></span>
			&nbsp;&nbsp;&nbsp;&bull;&nbsp;&nbsp;&nbsp; It is <a href="http://github.com/lucifurious/yiipis" target="_blank">%100 open source</a> and proudly brought to you by</span>
		<span style="position:relative;display:inline-block;"><a target="_blank" href="http://www.pogostick.com/"><span class="ps-icon"></span></a></span>
	</span>
	
</div>

<div class="yiipis-tooltip"><h3>I'm a tooltip!</h3></div>

<script type="text/javascript">
	$(function(){
	});
</script>
