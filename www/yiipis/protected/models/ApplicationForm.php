<?php
/*
 * ApplicationForm.php
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
 * Form model for Application
 *
 * @package 	yiipis
 * @subpackage 	models
 *
 * @author 		Jerry Ablan <jablan@pogostick.com>
 * @version 	SVN $Id$
 * @since 		v1.0.0
 *
 * @filesource
 */
class ApplicationForm extends CPSFormModel
{
	//********************************************************************************
	//* Member Variables
	//********************************************************************************

	/**
	 * @var string The path where to generate the application
	 */
	protected $m_sSitePath = null;
	public function getSitePath() { return $this->m_sSitePath; }
	public function setSitePath($oValue) { $this->m_sSitePath = $oValue; }

	//********************************************************************************
	//* Public Methods
	//********************************************************************************

	public function attributeLabels()
	{
		return array(
			'sitePath' => 'Path To Site',
		);
	}

	//********************************************************************************
	//* Private Methods
	//********************************************************************************
}
