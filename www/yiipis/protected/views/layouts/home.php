<?php
/**
 * home page layout
 *
 * This is the same as the main page but has different inner layout
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

//	Helper variables
$_baseUrl = PS::_gbu();
$_user = Yii::app()->getUser()->isGuest ? null : Yii::app()->getUser();
$_name = $_user ? $_user->first_name_text : 'Fellow Yii Enthusiast';
$_link = PS::tag( 'li', array(), $_user ? PS::link( 'logout', 'logout' ) : PS::link( 'login', 'login' ) );

//	Let's get the jQuery UI stuff going...
CPSjqUIWrapper::loadScripts( null, Yii::app()->params['siteTheme'] );

//	Site-level css
PS::_rcf( '/jquery-plugins/rainbows/rainbows.css', null, true );

//	Page-level css. Our one column layout css file.
//	You can change the inner layout of the page by changing these styles
PS::_rcf( '/css/layouts/_oneColumn.css' );

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
	<body class="container home">

		<div id="page">

			<?php require_once Yii::getPathOfAlias( 'application.views.layouts' ) . DIRECTORY_SEPARATOR . '_header.php'; ?>

			<div id="content-wrapper">

				<div id="content-column">
					<?php echo $content; ?>
				</div>
				
			</div>

		</div>

		<?php require_once Yii::getPathOfAlias( 'application.views.layouts' ) . DIRECTORY_SEPARATOR . '_footer.php'; ?>

		<div class="yiipis-tooltip"><h3>I'm a tooltip!</h3></div>

		<script type="text/javascript">
			$(function(){
			});
		</script>

	</body>
</html>