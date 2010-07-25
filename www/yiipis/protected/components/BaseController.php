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
	protected $m_arMenu = array();
	public function getMenu() { return $this->m_arMenu; }
	public function setMenu( $arValue ) { $this->m_sMenu = $arValue; }

	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	protected $m_arBreadcrumbs = array();
	public function getBreadcrumbs() { return $this->m_arBreadcrumbs; }
	public function setBreadcrumbs( $arValue ) { $this->m_arBreadcrumbs = $arValue; }

	//********************************************************************************
	//* Public Funnctions
	//********************************************************************************

	public function init()
	{
		parent::init();

		//	We want a single column here...
//		$this->_contentLayout = '_oneColumn';
	}

	/**
	 * Default error handling
	 */
	public function actionError()
	{
		if ( ! $_arError = Yii::app()->errorHandler->error )
		{
			if ( $this->isAjaxRequest )
				echo $_arError['message'];
			else
				throw new CHttpException( 404, 'Page not found.' );
		}

		$this->render( 'error', $_arError );
	}

}