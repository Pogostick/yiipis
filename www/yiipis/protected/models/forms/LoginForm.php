<?php
/*
 * This file is part of YiiPIS
 *
 * @copyright Copyright &copy; 2010 Pogostick, LLC
 * @link http://www.pogostick.com Pogostick, LLC.
 * @license http://www.pogostick.com/licensing
 */

/**
 * LoginForm form model
 *
 * @package 	yiipis
 * @subpackage 	models.forms
 *
 * @author 		Jerry Ablan <jablan@pogostick.com>
 * @version 	SVN $Id$
 * @since 		v1.0.0
 *
 * @filesource
 */

class LoginForm extends CPSFormModel
{
	//********************************************************************************
	//* Member Variables
	//********************************************************************************
	
	/**
	* OpenID URL
	*
	* @var string
	*/
	protected $_openIDUrl;
	public function getOpenIDUrl() { return $this->_openIDUrl; }
	public function setOpenIDUrl( $value ) { $this->_openIDUrl = $value; }

	/**
	* User name
	* 
	* @var string
	*/
	protected $_userName;
	public function getUserName() { return $this->_userName; }
	public function setUserName( $value ) { $this->_userName = $value; }

	/**
	* Password
	* 
	* @var string
	*/
	public $_password;
	public function getPassword() { return $this->_password; }
	public function setPassword( $value ) { $this->_password = $value; }

	/**
	* Remember me
	* 
	* @var boolean
	*/
	public $rememberMe;
	public function getRememberMe() { return $this->_rememberMe; }
	public function setRememberMe( $value ) { $this->_rememberMe = $value; }

	//********************************************************************************
	//* Public Methods
	//********************************************************************************

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			// password needs to be authenticated
			array( 'password', 'authenticatePassword' ),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'openIDUrl' => 'OpenID',
			'userName' => 'Email Address',
			'password' => 'Password',
			'rememberMe' => 'Keep me signed in',
		);
	}

	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	public function authenticatePassword( $sAttribute = null, $arParams = array() )
	{
		//	Only authenticate when no input errors
		if ( ! $this->hasErrors() )
		{
			$_arOut = array(
				'formModel' => $this,
				'authModel' => User::model(),
				'userName' => $this->_userName,
				'password' => $this->_password,
			);
			
			BaseUserIdentity::authenticatePassword( $_arOut, 'BaseUserIdentity' );
		}
	}
}