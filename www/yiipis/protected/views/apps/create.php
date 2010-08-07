<?php
/*
 * create.php
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
 * The view for apps/add
 *
 * @package 	yiipis
 * @subpackage 	views.apps
 * @author 		Jerry Ablan <jablan@pogostick.com>
 * @since 		v1.0.0
 * @filesource
 */

$this->pageTitle = Yii::app()->name;
PS::setFormFieldContainerClass('row');

$_formOptions = array(
	//	Info
	'id' => 'formAppsAdd',

	//	Our model
	'formModel' => $model,
	'formClass' => 'form',

	//	Gimme jQuery UI styling
	'uiStyle' => PS::UI_JQUERY,

	'cssFiles' => array(
		'/css/form.css',
	),

	//	We want error summary...
	'errorSummary' => true,

	//	And validate the form too
	'validate' => true,

	'validateOptions' => array(
		'ignoreTitle' => true,
		'errorClass' => 'ps-validate-error',
		'rules' => array(
			//	Custom rules go here
		),
		'messages' => array(
			//	Custom messages for said rules go here
		),
	),
);

//	Build out our form fields
$_formOptions['fields'] = array(
	array( 'beginFieldset', 'Identification' ),
		array( PS::TEXT, 'app_name_text', array( 'hint' => 'A name by which to reference this application.' ) ),
	array( 'endFieldset' ),

	array( 'beginFieldset', 'Location' ),
		array( PS::TEXT, 'app_url_text', array( 'hint' => 'The URL to your Yii site.' )  ),
		array( PS::TEXT, 'dev_app_url_text', array( 'hint' => 'The URL to your development site, if applicable.' ) ),
		array( PS::DROPDOWN, 'server_id', array( 'data' => array(0=>'a')) ),
		array( PS::DROPDOWN, 'dev_server_id', array( 'data' => array(0=>'a')) ),
	array( 'endFieldset' ),
);
?>

<h1>Add an App</h1>

<div>
	<p>One of the key benefits of YiiPIS is the application management features. To utilize these features, however, you must tell YiiPIS all about your app. This page allows you to do so.</p>
</div>

<?php CPSForm::create( $_formOptions ); ?>

<script type="text/javascript">
<!--
	$(function(){
	});
//-->
</script>
