<?php
/*
 * BaseModel.php
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
 * BaseModel
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
class BaseModel extends CPSModel
{
	//********************************************************************************
	//* Public Methods
	//********************************************************************************

	/***
	* Sets our default behaviors
	*/
	public function behaviors()
	{
		return array_merge(
			parent::behaviors(),
			array(
				//	Timestamper
				'psTimeStamp' => array(
					'class' => 'pogostick.behaviors.CPSTimeStampBehavior',
					'createdColumn' => 'create_date',
					'createdByColumn' => 'create_user_id',
					'lmodColumn' => 'lmod_date',
					'lmodByColumn' => 'lmod_user_id',
				),

				//	Soft Deleting
				'psSoftDelete' => array(
					'class' => 'pogostick.behaviors.CPSSoftDeleteBehavior',
					'softDeleteColumn' => 'delete_ind',
				),

				//	Delta Change
				'psDeltaChange' => array(
					'class' => 'pogostick.behaviors.CPSDeltaChangeBehavior',
				),
			)
		);
	}

	//********************************************************************************
	//* Event Handlers
	//********************************************************************************

	/**
	* Before we validate, fill in some global values
	*
	* @param CEvent $oScenario
	*/
	public function beforeValidate( $oScenario = null )
	{
		if ( $this->isNewRecord && $this->hasAttribute( 'user_id' ) ) $this->user_id = Yii::app()->user->id;
		return parent::beforeValidate( $oScenario );
	}

	/**
	* Fill in the ownership fields before we find...
	*/
	public function beforeFind()
	{
		if ( $this->hasAttribute( 'user_id' ) ) $this->user_id = Yii::app()->user->id;
		return parent::beforeFind();
	}

	/**
	* Before save, clean up
	*/
	public function beforeSave()
	{
		if ( parent::beforeSave() )
		{
			//	Strips off all bogus characters from numbers
			foreach ( $this->getAttributes() as $_sKey => $_oValue )
			{
				if ( $this->tableSchema->columns[ $_sKey ]->type != 'string' && null !== $_oValue && $_oValue != '' )
				{
					$_sTestVal = trim( $_oValue, '+-.,0123456789' );

					if ( ! empty( $_sTestVal ) )
					{
						$this->{$_sKey} = floatval( preg_replace('/[\+\-\,]/', '', $_oValue ) );
					}
				}
			}

			return true;
		}

		return false;
	}

	//********************************************************************************
	//* Scopes
	//********************************************************************************

	/**
	* The scopes for this model...
	*
	*/
	public function scopes()
	{
		$_arScopes = parent::scopes();

		if ( $this->hasAttribute( 'user_id' ) && ! Yii::app()->user->isGuest )
		{
			$_arScopes['mine'] = array(
				'condition' => 'user_id = :user_id',
				'params' => array( ':user_id' => Yii::app()->user->id ),
			);
		}

		//	Active scopes...
		if ( $this->hasAttribute( 'active_ind' ) )
		{
			$_arScopes['active'] = array(
				'condition' => 'active_ind = 1 and delete_ind = 0',
			);

			$_arScopes['inactive'] = array(
				'condition' => 'active_ind = 0 and delete_ind = 0',
			);
		}

		//	Active scopes...
		if ( $this->hasAttribute( 'delete_ind' ) )
		{
			$_arScopes['deleted'] = array(
				'condition' => 'delete_ind = 1',
			);
		}

		return $_arScopes;
	}
}