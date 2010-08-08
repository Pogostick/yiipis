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
 * Base controller for manager portions of the system
 *
 * @package 	yiipis
 * @subpackage 	components
 * @author 		Jerry Ablan <jablan@pogostick.com>
 * @since 		v1.0.0
 * @filesource
 */
class BaseManagerController extends BaseController
{
	//********************************************************************************
	//* Member Variables
	//********************************************************************************

	/**
	 * @var CBaseObjectManager The manager for this controller, if any
	 */
	protected $_manager;
	public function getManager() { return $this->_manager; }
	public function setManager( $value ) { $this->_manager = $value; }

	//********************************************************************************
	//* Public Funnctions
	//********************************************************************************

	public function actionIndex()
	{
		$this->_cleanTrail .= ' &diams; Home';
		$this->render( 'index' );
	}

	public function actionAdmin()
	{
		$this->render( 'admin' );
	}

	/**
	 * Create a new object
	 * @return
	 */
	public function actionAdd()
	{
		$_model = new $this->_modelName;
		$this->render( 'create', array( 'model' => $_model ) );
	}

}