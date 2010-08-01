<?php
/**
 * main page layout
 *
 * @package 	yiipis
 * @subpackage 	views.layouts
 *
 * @author 		Jerry Ablan <jablan@pogostick.com>
 * @version 	SVN $Id$
 * @since 		v1.0.0
 *
 * @filesource
 */

//	Our one column layout css file. You can change the inner layout of the page by changing these styles
PS::_rcf( '/css/layouts/_oneColumn.css' );

$_baseUrl = PS::_gbu();

//	Site-level css
PS::_rcf( '/jquery-plugins/rainbows/rainbows.css', null, true );

//	Site-level self-contained scripts
PS::_rsf(
	array(
		'jquery-plugins/jsTree/_lib/jquery.cookie.js',
		'jquery-plugins/jsTree/jquery.jstree.js',
		'jquery-plugins/rainbows/rainbows.js',
		'/scripts/site.jquery.js',
	),
	CClientScript::POS_HEAD,
	true
);

//	Site-level inline scripts
PS::_rs( null, "rainbows.init();", CClientScript::POS_READY );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<?php require_once Yii::getPathOfAlias( 'application.views.layouts' ) . DIRECTORY_SEPARATOR . '_htmlHeader.php'; ?>
	<body class="container generic">

		<div id="page">

			<?php require_once Yii::getPathOfAlias( 'application.views.layouts' ) . DIRECTORY_SEPARATOR . '_header.php'; ?>

			<div id="content-wrapper">
				<div id="content-navigation"></div>

				<div id="column-one" class="content-one-column">
					<?php echo $content; ?>
				</div>

				<div class="push"></div>
			</div>

			<?php require_once Yii::getPathOfAlias( 'application.views.layouts' ) . DIRECTORY_SEPARATOR . '_footer.php'; ?>

		</div>

		<!-- some cool curtains if you have a cool browser -->
		<div class="reflection curtain" style="top: 4727px; "></div>
		<div class="curtain top"></div>
	</body>
</html>