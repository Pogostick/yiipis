<?php
/*
 * BaseUserIdentity.php
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
 * BaseUserIdentity
 *
 * This is the base for all UserIdentity classes in our project. Implements email validation.
 *
 * @package 	yiipis
 * @subpackage 	components
 *
 * @author 		Jerry Ablan <jablan@pogostick.com>
 * @version 	SVN $Id$
 * @since 		v1.0.0
 *
 * @filesource
 */
class BaseUserIdentity extends CPSUserIdentity
{
	//********************************************************************************
	//* Constants
	//********************************************************************************

	const ERROR_UNVERIFIED_EMAIL = 1000;

	//********************************************************************************
	//* Public Methods
	//********************************************************************************

	/**
	 * Construct and set our column names...
	 *
	 * @param string $userName
	 * @param string $password
	 * @param mixed $userType
	 * @return BaseUserIdentity
	 */
	public function __construct( $userName, $password, $userType = null )
	{
		parent::__construct( $userName, $password, $userType );

		//	We will accept a user name or email address...
		$this->m_arAuthAttributes = array(
			'username' => 'user_name_text',
			'password' => 'password_text',
			'email' => 'email_addr_text',
		);

		//	Allow users to login with their email address
		$this->m_bAllowEmailLogins = true;
	}

	/**
	 * Successful login event handler
	 *
	 * @param CPSAuthenticationForm $event
	 */
	public function loginSuccess( $event )
	{
		if ( $_user = $event->getUser() )
		{
			PS::_ss( 'firstName', $_user->first_name_text );
			
			if ( null === $_user->validation_date )
			{
				PS::_ss( 'unverifiedUserId', $_user->id );
				$this->errorCode = self::ERROR_UNVERIFIED_EMAIL;
				PS::redirect( '/client/dashboard/verify' );
			}
			else
			{
				PS::_ss( 'unverifiedUserId', null );
				PS::_ss( 'unverifiedLastAttempt', null );
				PS::_ss( 'userType', $_user->user_type_code );

				$this->username = $_user->user_name_text;

				if ( in_array( 'roles', array_keys( $_user->relations() ) ) )
				{
					PS::_ss( 'roles', $_user->roles );

					//	Set primary role
					foreach ( $_user->roles as $_oRole )
					{
						if ( $_oRole->primary_ind )
						{
							Yii::app()->user->setState( 'userPrimaryRole', $_oRole->role->role_name_text );
							break;
						}
					}
				}

				//	Touch our user if we can
				if ( $_user instanceof CPSModel ) $_user->touch();
			}
		}
	}

	/**
	 * Login failed
	 *
	 * @param CPSAuthenticationEvent $event
	 */
	public function loginFailure( $event )
	{
		//	Don't care...
	}

}