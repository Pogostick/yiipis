<?php
/*
 * UserRole.php
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
 * @package 	yiipis
 * @subpackage	models
 *
 * @author 		Jerry Ablan <jablan@pogostick.com>
 * @version 	SVN $Id$
 * @since 		v1.0.0
 *
 * @filesource
 */
class UserRole extends BaseModel
{
	//********************************************************************************
	//* Constants
	//********************************************************************************

	//********************************************************************************
	//* Public Methods
	//********************************************************************************

	/**
	* Returns the static model of the specified AR class.
	* @return CActiveRecord the static model class
	*/
	public static function model( $sClassName = __CLASS__ )
	{
		return parent::model( $sClassName );
	}

	/**
	* @return string the associated database table name
	*/
	public function tableName()
	{
		return self::getTablePrefix() . 'user_role_t';
	}

	/**
	* @return array validation rules for model attributes.
	*/
	public function rules()
	{
		return array(
			array( 'role_name_text', 'length', 'max' => 64 ),
			array( 'role_name_text, create_date, lmod_date', 'required' ),
			array( 'create_user_id, lmod_user_id', 'numerical' ),
		);
	}

	/**
	* @return array relational rules.
	*/
	public function relations()
	{
		return array(
			'users' => array( self::HAS_MANY, 'User', 'UserRoleAssign(role_id,user_id)' ),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Id',
			'role_name_text' => 'Role Name',
			'create_date' => 'Create Date',
			'create_user_id' => 'Create User',
			'lmod_date' => 'Lmod Date',
			'lmod_user_id' => 'Lmod User',
		);
	}
}
