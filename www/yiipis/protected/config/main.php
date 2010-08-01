<?php
//	Pogostick Yii Extensions
Yii::setPathOfAlias( 'pogostick', '/usr/local/psYiiExtensions/extensions/pogostick' );

$_sDBHost = 'localhost';
$_sDBName = 'yiipis';
$_sDBUserName = 'yiipis_user';
$_sDBPassword = 'yiipis_user';
$_sLogPath = '/var/log/yii';
$_sLogName = 'yiipis_log';

//	Our configuration
return array(

	'name' => 'Yii Project Improvement Suite',
	'basePath' => dirname( __FILE__ ) . DIRECTORY_SEPARATOR . '..',
	'runtimePath' => $_sLogPath,

	'preload' => array( 'log', 'yiipis' ),

	'import' => array(
		'application.models.*',
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
			'errorAction' => '/site/error',
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
		'siteTheme' => 'pepper-grinder',
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
	),
);