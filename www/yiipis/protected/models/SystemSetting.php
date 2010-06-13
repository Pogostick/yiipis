<?php
/*
 * SystemSetting.php
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
 * Codes
 *
 * @package 	yiipis
 * @subpackage	models
 *
 * @author 		Jerry Ablan <jablan@pogostick.com>
 * @version 	SVN $Id$
 * @since 		v1.0.0
 *
 * @filesource
 */
class SystemSetting extends BaseModel
{
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
		return self::getTablePrefix() . 'sys_setting_t';
	}

	/**
	* @return array validation rules for model attributes.
	*/
	public function rules()
	{
		return array(
			array( 'name_text', 'length', 'max' => 255 ),
			array( 'name_text, value_text', 'required' ),
		);
	}

	/**
	* @return array relational rules.
	*/
	public function relations()
	{
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Id',
			'name_text' => 'Name',
			'value_text' => 'Value',
			'create_date' => 'Create Date',
			'lmod_date' => 'Lmod Date',
		);
	}

	/**
	 * Retrieves a value from the given key 
	 * @param string $sName
	 * @returns mixed
	 */
	public static function lookup( $sName )
	{
		$_oModel = self::model();
		
		return $_oModel->getDbConnection()->createCommand( 
			'select value_text from ' . $_oModel->tableName() . ' where name_text = :name_text' 
			)->queryScalar( 
				array( ':name_text' => $sName ) 
		);
	}

	public function afterFind()
	{
		$this->value_text = unserialize( $this->value_text );
			
		return parent::afterFind();
	}
		
	
	public function beforeSave()
	{
		if ( $_bResult = parent::beforeSave() )
		{
			$this->name_text = strtoupper( str_replace( ' ', '_', $this->name_text ) );
			$this->value_text = serialize( $this->value_text );
		}
			
		return $_bResult;
	}
		
}
