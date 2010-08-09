<?php
/*
 * This file is part of YiiPIS
 *
 * @copyright Copyright &copy; 2010 Pogostick, LLC
 * @link http://www.pogostick.com Pogostick, LLC.
 * @license http://www.pogostick.com/licensing
 */

/**
 * profile.index view
 *
 * @package 	yiipis
 * @subpackage 	views.profile
 *
 * @author 		Jerry Ablan <jablan@pogostick.com>
 * @version 	SVN $Id$
 * @since 		v1.0.0
 *
 * @filesource
 */

	$this->pageTitle = Yii::app()->name;
	$_sSupport = Yii::app()->params['supportHost'] . '/supporttickets.php';
	$_sSystemName = Yii::app()->params['shortSiteName'];
	$_data = array_merge( is_array( $_data_ ) ? $_data_ : array(), array( '_sSystemName' => $_sSystemName, '_sSupport' => $_sSupport ) );

	CPSjqUIWrapper::create( 'loading', array( 'locateScript' => true, 'target' => '#welcome-copy', 'onAjax' => true, 'text' => 'Loading...', 'align' => 'center' ) );

	if ( Yii::app()->user->isGuest )
		$this->renderPartial( '_guestCopy', $_data );
	else
	{
		if ( Yii::app()->user->getState('isApproved' ) )
			$this->renderPartial( '_dailySnapshot', $_data );

		$this->renderPartial( '_accountStatus', $_data );

		if ( Yii::app()->user->userType == User::PUBLISHER )
			$this->renderPartial( '_publisherCopy', $_data );

		if ( Yii::app()->user->userType == User::ADVERTISER )
			$this->renderPartial( '_advertiserCopy', $_data );
	}