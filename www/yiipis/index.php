<?php
//	Intialize Yii
$yii = '/usr/local/yii/1.1.2/framework/yii.php';
$config = dirname( __FILE__ ) . '/protected/config/main.php';

//	Set for debug... Comment out when in production
defined( 'YII_DEBUG' ) or define( 'YII_DEBUG', true );
defined( 'YII_TRACE_LEVEL' ) or define( 'YII_TRACE_LEVEL', 3 );

require_once( $yii );
Yii::createWebApplication( $config )->run();
