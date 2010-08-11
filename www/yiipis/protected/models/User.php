<?php
/*
 * User.php
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
class User extends BaseModel
{
	//********************************************************************************
	//* Private Variables
	//********************************************************************************

	/**
	* Password confirmation field
	*
	* @var string
	*/
	protected $m_sConfirmPassword;
	public function getConfirmPassword() { return $this->m_sConfirmPassword; }
	public function setConfirmPassword( $sValue ) { $this->m_sConfirmPassword = $sValue; }

	/**
	* Email confirmation field
	*
	* @var string
	*/
	protected $m_sConfirmEmail;
	public function getConfirmEmail() { return $this->m_sConfirmEmail; }
	public function setConfirmEmail( $sValue ) { $this->m_sConfirmEmail = $sValue; }

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
		return self::getTablePrefix() . 'user_t';
	}

	/**
	* @return array validation rules for model attributes.
	*/
	public function rules()
	{
		return array(
			array( 'user_name_text', 'length', 'max' => 30 ),
			array( 'password_text', 'length', 'max' => 30 ),
			array( 'first_name_text', 'length', 'max' => 128 ),
			array( 'last_name_text', 'length', 'max' => 128 ),
			array( 'email_addr_text', 'length', 'max' => 255 ),
			array( 'password_text', 'required' ),
		);
	}

	/**
	* @return array relational rules.
	*/
	public function relations()
	{
		return array(
			'roles' => array( self::HAS_MANY, 'UserRoleAssign', 'user_id' ),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Id',
			'user_type_code' => 'Account Type',
			'user_name_text' => 'Nickname',
			'openid_url_text' => 'OpenID URL',
			'password_text' => 'Password',
			'confirmPassword' => 'Password (again)',
			'first_name_text' => 'First Name',
			'last_name_text' => 'Last Name',
			'mail_address_1_text' => 'Address',
			'mail_address_2_text' => ' ',
			'mail_city_text' => 'City',
			'mail_state_code' => 'State',
			'mail_prov_text' => 'State/Province',
			'mail_country_code' => 'Country',
			'mail_postal_code_text' => 'Postal Code',
			'comp_name_text' => 'Company Name',
			'email_addr_text' => 'Email Address',
			'confirmEmail' => 'Email Address (again)',
			'alt_email_addr_text' => 'Alternate Email Address',
			'phone_nbr_text' => 'Phone Number',
			'alt_phone_nbr_text' => 'Alternate Phone',
			'company_url_text' => 'Company Web Site',
			'active_ind' => 'Active',
			'approve_ind' => 'Approved',
			'valid_ind' => 'Valid',
			'terms_agree_ind' => 'Terms Agreement',
			'time_zone_code' => 'Time Zone',
			'api_key_text' => 'API Key',
			'api_secret_key_text' => 'API Secret Key',
			'create_date' => 'Create Date',
			'lmod_date' => 'Modified Date',
		);
	}

	//********************************************************************************
	//* Event Handlers
	//********************************************************************************

	/**
	* Populate some default values before we validate
	*
	* @param CEvent $oScenario
	*/
	public function beforeValidate( $oScenario = null )
	{
		if ( $this->isNewRecord )
		{
			if ( null === $this->email_addr_text )
				$this->email_addr_text = $this->openid_url_text;
		}

		return parent::beforeValidate( $oScenario );
	}

	/**
	* After a save...
	*
	*/
	public function afterSave()
	{
		//	If this was a new user, send a welcome email...
		if ( $this->isNewRecord )
		{
			PS::_ss( 'unverifiedUserId', $this->id );
//			JobQueue::queue( JobQueue::SYS_WELCOME_EMAIL, 'sendWelcomeEmail', array( 'userId' => $this->id ) );
		}

		return parent::afterSave();
	}

	/**
	 * Returns a displayable company name, or full name if not available.
	 * @returns string
	 */
	public function getDisplayName()
	{
		if ( $this->comp_name_text )
			return $this->comp_name_text;

		return $this->getFullName();
	}

	/**
	 * Returns the full name of the user
	 * @returns string
	 */
	public function getFullName()
	{
		return $this->first_name_text . ' ' . $this->last_name_text;
	}

	//********************************************************************************
	//* Scopes
	//********************************************************************************

	/**
	* Returns records for a particular user type
	*
	* @param integer $iType
	*/
	public function userType( $iType )
	{
		$this->getDbCriteria()->mergeWith(
			array(
				'condition' => 'user_type_code = :user_type_code',
				'params' => array( ':user_type_code' => $iType ),
			)
		);

		return $this;
	}

}