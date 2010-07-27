<?php
/**
 * The common HTML headers for all layouts
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
?>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<link rel="stylesheet" type="text/css" href="<?php echo $_baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo $_baseUrl; ?>/css/form.css" />
	<link rel="shortcut icon" href="http://www.yiipis.com/favicon.ico" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>
