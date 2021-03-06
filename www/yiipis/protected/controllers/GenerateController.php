<?php
/*
 * GenerateController.php
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
 * GenerateController
 *
 * @package 	YiiPIS
 * @subpackage 	controllers
 *
 * @author 		Jerry Ablan <jablan@pogostick.com>
 * @version 	SVN $Id$
 * @since 		v1.0.0
 *
 * @filesource
 */
class GenerateController extends BaseController
{
	//********************************************************************************
	//* Member Variables
	//********************************************************************************

	//********************************************************************************
	//* Actions
	//********************************************************************************

	public function actionIndex()
	{
		$this->render( 'index' );
	}

	public function actionApplication()
	{
		$_oModel = new ApplicationForm();

		if ( $this->isPostRequest )
		{
			//	Build application
			$_oModel = $_POST['ApplicationForm'];
		}

		$this->render( 'application', array( 'model' => $_oModel ) );
	}

	public function actionModule()
	{

	}

	public function actionModel()
	{

	}

	public function actionView()
	{

	}

	public function actionController()
	{

	}

	public function actionForm()
	{

	}

	public function actionCRUDForm()
	{

	}

	public function actionConfigFile()
	{

	}

	//********************************************************************************
	//* Public Methods
	//********************************************************************************

	//********************************************************************************
	//* Private Methods
	//********************************************************************************
}
