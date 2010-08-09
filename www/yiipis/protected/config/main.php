<?php
//	Pogostick Yii Extensions
Yii::setPathOfAlias( 'pogostick', '/usr/local/psYiiExtensions/extensions/pogostick' );

$_sDBHost = 'scoozi.gna.me';
$_sDBName = 'yiipis';
$_sDBUserName = 'yiipis_user';
$_sDBPassword = 'yiipis_user';
$_sLogPath = '/var/log/yii';
$_sLogName = 'yiipis_log';

//	Set proper db
if ( false !== stripos( $_SERVER['SERVER_ADDR'], '192.168.' ) )
	$_sDBHost = 'psdb001.appbarn.com';

//	Our configuration
return array(

	'name' => 'Yii Project Improvement Suite',
	'basePath' => dirname( __FILE__ ) . DIRECTORY_SEPARATOR . '..',
	'runtimePath' => $_sLogPath,
	'defaultController' => 'default',

	'preload' => array( 'log', ( PHP_SAPI != 'cli' ? 'yiipis' : null ) ),

	'import' => array(
		'application.models.*',
		'application.models.forms.*',
		'application.components.*',
		'application.controllers.*',
		'application.zii.*',

		//	pYe
		'pogostick.base.*',
		'pogostick.behaviors.*',
		'pogostick.commands.*',
		'pogostick.components.*',
		'pogostick.controllers.*',
		'pogostick.events.*',
		'pogostick.models.*',
		'pogostick.helpers.*',
		'pogostick.widgets.*',
		'pogostick.widgets.pagers.*',
		'pogostick.widgets.jqui.*',
	),

	// application components
	'components' => array(

		'yiipis' => array(
			'class' => 'CYPSAppImprover',
		),

		'user' => array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
			'loginUrl' => array( 'default/login' ),
		),

		'urlManager' => array(
			'urlFormat' => 'path',
			'showScriptName' => false,
			'rules' => array(
//				'<view:\w+>' => 'site/_static',
			),
		),

		//	caching engine
//		'cache' => array(
//			'class' => 'CApcCache',
//		),

		//	Authentication manager...
		'authManager' => array(
			'class' => 'CDbAuthManager',
			'connectionID' => 'db',
		),

		'errorHandler' => array(
			'errorAction' => '/default/error',
		),

		//	Database (Site)
		'db' => array(
			'class' => 'CDbConnection',
			'autoConnect' => true,
			'connectionString' => 'mysql:host=' . $_sDBHost . ';dbname=' . $_sDBName . ';',
			'username' => $_sDBUserName,
			'password' => $_sDBPassword,
		),

		'log' => array(
			'class'=>'CLogRouter',
			'routes' => array(
				array(
					'class' => 'CFileLogRoute',
					'levels' => 'info, error, warning, trace',
					'maxFileSize' => '102400',
					'logPath' => $_sLogPath,
					'logFile' => $_sLogName,
				),
			),
		),

	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params' => array(
		'siteTheme' => 'eggplant',
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
	),
);