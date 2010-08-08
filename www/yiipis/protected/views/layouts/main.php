<?php
/**
 * main site layout
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

//	Determine from whence you've come...
$_userGreeting = PS::_gs( 'userGreeting' );

if ( ! $_userGreeting && $_referrer = PS::_gr()->getUrlReferrer() )
{
	if ( false !== stripos( $_referrer, '.yiiframework.com' ) )
		$_userGreeting = 'Yii Developer';
	else if ( false !== stripos( $_referrer, '.github.com' ) )
		$_userGreeting = 'Github User';
}

if ( ! $_userGreeting )
	$_userGreeting = 'Yii-ster';

PS::_ss( 'userGreeting', $_userGreeting );

//	Helper variables
$_baseUrl = PS::_gbu();
$_user = PS::_gu()->isGuest ? null : PS::_gu();
$_name = $_user ? $_user->first_name_text : $_userGreeting;
$_link = PS::tag( 'li', array(), $_user ? PS::link( 'logout', 'profile/logout' ) : PS::link( 'login', 'profile/login' ) );

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
		'jquery-plugins/cookie/jquery.cookie.js',
		'jquery-plugins/jquery.hoverintent.min.js',
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