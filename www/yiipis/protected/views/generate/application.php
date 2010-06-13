<?php
/*
 * application.php
 * 
 * Copyright (c) 2010 Jerry Ablan <jablan@pogostick.com>.
 * @link http://www.pogostick.com Pogostick, LLC.
 * @license http://www.pogostick.com/licensing
 * 
 * This file is part of YiiPIS.
 * 
 * We share the same open source ideals as does the jQuery team, and
 * we love them so much we like to quote their license statement:
 * 
 * You may use our open source libraries under the terms of either the MIT
 * License or the Gnu General Public License (GPL) Version 2.
 * 
 * The MIT License is recommended for most projects. It is simple and easy to
 * understand, and it places almost no restrictions on what you can do with
 * our code.
 * 
 * If the GPL suits your project better, you are also free to use our code
 * under that license.
 * 
 * You don’t have to do anything special to choose one license or the other,
 * and you don’t have to notify anyone which license you are using.
 */

//	Include Files
//	Constants
//	Global Settings

/**
 * The view for generateApplication
 *
 * @package 	yiipis
 * @subpackage 	views.generate
 *
 * @author 		Jerry Ablan <jablan@pogostick.com>
 * @version 	SVN $Id$
 * @since 		v1.0.0
 *
 * @filesource
 */
	PS::_rcf( '/css/form.css' );
	PS::$errorCss = 'ps-validate-error';

	//	Build our form options array...
	$_arFormOpts = array(
		//	Gimme jQuery UI styling
		'uiStyle' => PS::UI_JQUERY,

		//	Our model
		'formModel' => $model,

		//	We want error summary...
		'errorSummary' => true,

		//	And validate the form too
		'validate' => true,

		'scriptFiles' => array(
			'/scripts/jquery.numberformatter.min.js',
		),

		//	Set some validation options
		'validateOptions' => array(
			'ignoreTitle' => true,
			'rules' => array(
			),
			'messages' => array(
			),
		),
	);

	$_arFields = array();

	$_arFields[] = array( 'beginFieldset', 'Location' );
		$_arFields[] = array( PS::TEXT, 'sitePath', array( 'size' => 60, 'maxlength' => 255 ) );
	$_arFields[] = array( 'endFieldset' );

	//	Set our fields and create the form.
	$_arFormOpts['fields'] = $_arFields;

	CPSForm::create( $_arFormOpts );
?>
<script type="text/javascript">
<!--
	$(function(){
		$('#ps-edit-form').submit(function(){
			return true;
		});

		$('.number-format-integer').blur(function(){
			$(this).format({format:'#,###'});
		}).format({format:'#,###'});
	});
//-->
</script>

