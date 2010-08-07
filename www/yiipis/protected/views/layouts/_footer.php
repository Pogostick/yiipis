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

//	Load our module specific CSS
PS::_rcf( '/css/layouts/_footer.css' );
PS::_rsf( '/scripts/site.footer-menu.js' );
?>

<div id="footer">
	<span id="footer-menu-container">
		<ul class="footer-menu-top-menu">
			<li>
				<a href="#">Servers</a>
				<ul id="fm-servers" class="footer-menu-sub-menu">
					<li>
						<h3>Available Servers</h3>
						<a href="#">mo.yiipis.com</a>
					</li>
					<li>
						<a href="#">larry.yiipis.com</a>
					</li>
					<li>
						<a href="#">curly.yiipis.com</a>
					</li>
					<li>
						<h3>Options</h3>
						<a href="#">Add a Server...</a>
					</li>
					<li>
						<a href="#">Manage Servers...</a>
					</li>
				</ul>
			</li>
			<li>
				<a href="#">Databases</a>
				<ul id="fm-databases" class="footer-menu-sub-menu">
					<li>
						<h3>Available Databases</h3>
						<a href="#">mysql.yiipis.com</a>
					</li>
					<li>
						<a href="#">oracle.yiipis.com</a>
					</li>
					<li>
						<a href="#">postgres.yiipis.com</a>
					</li>
					<li>
						<h3>Options</h3>
						<a href="#">Add a Database...</a>
					</li>
					<li>
						<a href="#">Manage Databases...</a>
					</li>
				</ul>
			</li>

			<li>
				<a href="#">Configs</a>
				<ul id="fm-configs" class="footer-menu-sub-menu">
					<li>
						<h3>Available Configurations</h3>
						<a href="#">Config #1</a>
					</li>
					<li>
						<a href="#">Config #2</a>
					</li>
					<li>
						<a href="#">Config #3</a>
					</li>
					<li>
						<h3>Options</h3>
						<a href="#">Add a Config...</a>
					</li>
					<li>
						<a href="#">Manage Configs...</a>
					</li>
				</ul>
			</li>

			<li>
				<a href="#">Apps</a>
				<ul id="fm-apps" class="footer-menu-sub-menu">
					<li>
						<h3>Available Apps</h3>
						<a href="#">App #1</a>
					</li>
					<li>
						<a href="#">App #2</a>
					</li>
					<li>
						<a href="#">App #3</a>
					</li>
					<li>
						<h3>Options</h3>
						<a href="#">Add an App...</a>
					</li>
					<li>
						<a href="#">Manage Apps...</a>
					</li>
				</ul>
			</li>

		</ul>
	</span>

	<span class="faux-spacer"></span>

	<span id="footer-copyright" class="footer-block">
		<span style="color:#e6592d">YiiPIS</span> is <a target="_blank" href="http://github.com/lucifurious/yiipis" target="_blank">100% open source</a> and proudly brought to you by<span style="position:relative;display:inline-block;"><a target="_blank" href="http://www.pogostick.com/"><span class="ps-icon"></span></a></span>
		<span style="color:#888;">&nbsp;&nbsp;&nbsp;&bull;&nbsp;&nbsp;&nbsp;</span>
		Powered by <span class="yii-icon"></span><a target="_blank" href="http://www.yiiframework.com/" valign="middle">Yii</a>
	</span>
	
</div>

<div id="footer-menu-config">
</div>

<script type="text/javascript">
	$(function(){
		$('span#apps-toggle').hover(
			function() {
				var _pOffset = $(this).parent().offset();
				var _pPos = $(this).parent().position();
				$('#apps-su-menu').css({left:_pOffset.left,bottom:'10px'}).show();
			},
			function() {
				$('#apps-su-menu').slideDown();
			}
		);

		$('div.slideup-menu .slideup-show-hide').click(function(){
			$('div.slideup-menu').slideDown('fast');
			return false;
		});
	})
</script>