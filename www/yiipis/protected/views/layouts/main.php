<?php
$_sBaseUrl = Yii::app()->request->baseUrl;

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
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<link rel="stylesheet" type="text/css" href="<?php echo $_sBaseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo $_sBaseUrl; ?>/css/form.css" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body class="container generic">

	<div id="page">

		<?php require_once Yii::getPathOfAlias( 'application.views.layouts' ) . DIRECTORY_SEPARATOR . '_header.php'; ?>

		<div id="content-wrapper">
			<div id="content-column">
				<?php echo $content; ?>
			</div>
		</div>

		<div id="footer">
			<span id="footer-menu" class="footer-block"?
				<div class="ul-menu">
					<ul>
						<?php echo $_link; ?>
						<li><a href="/help/">Help</a></li>
					</ul>
				</div>
			</span>
			
			<span class="faux-spacer"></span>

			<span id="footer-copyright" class="footer-block">
				The Yii <span style="color:#e6592d">Project Improvement Suite</span> is 100% open source and proudly brought to you by <a href="http://www.pogostick.com/"><span class="ps-icon"></span></a>
			</span>

			<span class="faux-spacer"></span>

			<span id="footer-credits" class="footer-block">
				<span id="yii-powered">
					Powered by the <a href="http://www.yiiframework.com/">Yii Framework</a>
					<span class="yii-icon"></span>
				</span>
			</span>
		</div><!-- footer -->

	</div>

	<!-- some cool curtains -->
	<div class="reflection curtain" style="top: 4727px; "></div>
	<div class="curtain top"></div>
</body>
</html>