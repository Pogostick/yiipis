<?php
$_sBaseUrl = Yii::app()->request->baseUrl;
PS::_rsf( '/jquery-plugins/jsTree/_lib/jquery.cookie.js', CClientScript::POS_HEAD, true );
PS::_rsf( '/jquery-plugins/jsTree/jquery.jstree.js', CClientScript::POS_HEAD, true );
PS::_rcf( '/jquery-plugins/rainbows/rainbows.css', null, true );
PS::_rsf( '/jquery-plugins/rainbows/rainbows.js', CClientScript::POS_HEAD, true );
PS::_rs( null, "rainbows.init({selector:'#header-logo h2',shadow:true,from:'#666666',to:'#aaaaaa'});", CClientScript::POS_READY );
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

<xbody class="container generic">
<body id="rain_demo" class=" rain demo">

	<div id="page">

		<div id="header">
			
			<div class="inset silver sample" id="header-logo">
				<img src="/images/logo.png" alt="" border="0" valign="middle"/>
			</div>

			<div id="header-menu" class="ul-menu">
				<ul>
					<li>Welcome</li>
					<li><a href="/login/">Login</a></li>
					<li><a href="/logout/">Logout</a></li>
					<li><a href="/help/">Help</a></li>
				</ul>
			</div>
		</div>

		<div id="main-menu" class="ul-menu">
			<ul>
				<li><a href="/configure/">Configure</a></li>
				<li><a href="/build/">Build</a></li>
				<li><a href="/maintain/">Maintain</a></li>
			</ul>
		</div>

		<div id="content-wrapper">
			<?php echo $content; ?>
		</div>

		<div id="footer">
			Copyright &copy; <?php echo date('Y'); ?> by Pogostick, LLC. All Rights Reserved<br />
			<?php echo Yii::powered(); ?>
		</div><!-- footer -->
</div><!-- page -->
<div class="reflection curtain" style="top: 4727px; "></div>
<div class="curtain top"></div>

</body>
</html>