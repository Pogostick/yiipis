<?php
/*
 * Setting.php
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
class Settings extends BaseModel
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
		return self::getTablePrefix() . 'yiipis_setting_t';
	}

	/**
	* @return array validation rules for model attributes.
	*/
	public function rules()
	{
		return array(
			array( 'name_text', 'length', 'max' => 60 ),
			array( 'name_text, create_date, lmod_date', 'required' ),
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
			'name_text' => 'Name Text',
			'value_text' => 'Value Text',
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

	/**
	 * Cleans up the key before saving
	 * @return boolean
	 */
	public function beforeSave()
	{
		if ( $_bResult = parent::beforeSave() )
		{
			$this->name_text = trim( str_replace( ' ', '_', $this->name_text ) );
			$this->value_text = $this->value_text;
		}

		return $_bResult;
	}

	/**
	 * Returns a setting from the database
	 * @param string $sName The setting to return
	 * @param mixed $oDefault The default value to return
	 * @returns mixed
	 */
	public static function getSetting( $sName, $oDefault = null, $bReturnRow = false )
	{
		$_arParams = array(
			'condition' => 'name_text = :name_text',
			'params' => array(
				':name_text' => trim( strtolower( $sName ) ),
			),
		);

		if ( $_oModel = self::model()->find( $_arParams ) )
		{
			if ( $bReturnRow )
				return $_oModel;

			return $_oModel->value_text;
		}

		//	Not found, return default value...
		return $bReturnRow ? false : $oDefault;
	}

	/**
	 * Sets a setting in the database
	 * @param string $sName The setting name
	 * @param mixed $ovalue The value of the setting
	 * @returns boolean
	 */
	public static function setSetting( $sName, $oValue )
	{
		if ( ! $_oModel = self::getSetting( $sName, null, true ) )
			$_oModel = new Settings();

		$_oModel->name_text = $sName;
		$_oModel->value_text = $oValue;

		return $_oModel->save();
	}

	/**
	 * Deletes a setting in the database
	 * @param string $sName The setting name
	 * @returns boolean
	 */
	public static function removeSetting( $sName )
	{
		if ( $_oModel = self::getSetting( $sName, null, true ) )
		{
			if ( $_oModel->system_ind == 0 )
				return $_oModel->delete();
		}

		return false;
	}

}
