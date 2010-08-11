<?php
/*
 * This file is part of the Yii Productivity Improvement System.
 *
 * @copyright Copyright &copy; 2010 Pogostick, LLC
 * @link http://www.pogostick.com Pogostick, LLC.
 * @license http://www.pogostick.com/licensing
 */

//	Include Files
//	Constants
//	Global Settings

/**
 * Our base controller
 *
 * @package 	yiipis
 * @subpackage 	controllers
 *
 * @author 		Jerry Ablan <jablan@pogostick.com>
 * @version 	SVN $Id$
 * @since 		v1.0.0
 *
 * @filesource
 */
class BaseController extends CPSController
{
	//********************************************************************************
	//* Member Variables
	//********************************************************************************

	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	protected $_menu = array();
	public function getMenu() { return $this->_menu; }
	public function setMenu( $value ) { $this->_menu = $value; }

	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	protected $_breadcrumbs = array();
	public function getBreadcrumbs() { return $this->_breadcrumbs; }
	public function setBreadcrumbs( $value ) { $this->_breadcrumbs = $value; }

	protected $_displayName;
	protected function setDisplayName( $value ) { $this->_displayName = $value; }
	protected function getDisplayName() { return $this->_displayName; }

	protected $_cleanTrail;
	protected function setCleanTrail( $value ) { $this->_cleanTrail = $value; }
	protected function getCleanTrail() { return $this->_cleanTrail; }

	//********************************************************************************
	//* Public Funnctions
	//********************************************************************************

	/**
	 * Initialize
	 */
	public function init()
	{
		parent::init();
		$this->_cleanTrail = $this->_displayName;
		$this->defaultAction = 'index';
	}

	/**
	 * How about a default action that displays static pages? Huh? Huh?
	 * @return array
	 */
	public function actions()
	{
		return array_merge(
			array(
				'_static' => array(
					'class' => 'CViewAction',
					'basePath' => '_static',
				),
			),
			parent::actions()
		);
	}

	/**
	 * Default error handling
	 */
	public function actionError()
	{
		if ( ! $_error = Yii::app()->getErrorHandler()->getError() )
		{
			if ( ! $this->isAjaxRequest )
				throw new CHttpException( 404, 'Page not found.' );

			echo $_error['message'];
		}

		$this->render( 'error', $_error );
	}

}