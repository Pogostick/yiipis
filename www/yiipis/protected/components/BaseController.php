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
	/**
	 * @var string the default layout for the controller view. Defaults to 'application.views.layouts.column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='application.views.layouts.column1';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();

	public function init()
	{
		parent::init();
//		$this->m_bAutoMissing = true;
	}

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