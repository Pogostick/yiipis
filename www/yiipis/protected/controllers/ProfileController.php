<?php
/*
 * ProfileController.php
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
Yii::import( 'application.extensions.auth.openID.*' );

//	Constants
//	Global Settings

/**
 * User Profile Controller
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
class ProfileController extends BaseController
{
	//********************************************************************************
	//* Public Methods
	//********************************************************************************

	/**
	 * Initialize our controller
	 */
	public function init()
	{
		parent::init();

		$this->setModelName( 'User' );
		$this->layout = 'main';

		$this->_cleanTrail = $this->_displayName = ( PS::_gu()->isGuest ? 'Login and Registration' : 'Your Profile' );
	}

	//********************************************************************************
	//* Actions
	//********************************************************************************

	/**
	 * User login action
	 */
	public function actionLogin()
	{
		if ( ! PS::_gu()->isGuest )
			return $this->redirect( PS::_gu()->returnUrl );

		$_loginForm = new LoginForm();
		$_wasOpenID = false;

		if ( $this->isPostRequest && isset( $_POST['LoginForm'] ) )
		{
			$_loginForm->setAttributes( $_POST['LoginForm'], false );

			//	do we need to do an OpenID login?
			if ( $_POST['is-open-id'] == '1' && null !== ( $_openIDUrl = PS::oo( $_POST, 'LoginForm', 'openIDUrl' ) ) )
			{
				$_oid = new OpenIDConsumer( array( 'oidIdentifier' => $_openIDUrl, 'returnUrl' => $this->createAbsoluteUrl( '/profile/openID' ) ) );

				try
				{
					//	Start the OpenID auth process. If it returns data, echo it alone (it's a redirect!)
					if ( $_authData = $_oid->beginAuthentication() )
					{
						$this->layout = null;
						echo $_authData;
						return;
					}
				}
				catch ( CException $_ex )
				{
					//	If we get here, there was a problem...
					$_wasOpenID = true;
					$_loginForm->openIDUrl = $_openIDUrl;
					$_loginForm->addError( '', $_ex->getMessage() );
				}
			}
			else
			{
				//	Validate user input and redirect to previous page if valid
				if ( $_loginForm->validate() )
					return $this->redirect( PS::_gu()->returnUrl );

				$_loginForm->userName = PS::oo( $_POST, 'LoginForm', 'userName' );
			}
		}

		//	Display the login form
		$this->render( 'login', array( 'form' => $_loginForm, 'wasOpenID' => $_wasOpenID ? 1 : 0 ) );
	}

	public function actionOpenID()
	{
		$_oid = new OpenIDConsumer( array( 'returnUrl' => $this->createAbsoluteUrl( '/profile/openID' ) ) );
		if ( $_oid->completeAuthentication() )
		{
			//	Is user in database?
			if ( $_user = User::model()->find( 'email_addr_text = :email_addr_text', array( ':email_addr_text' => $_oid->getAuthId() ) ) )
			{
				$this->redirect('/');
				//echo 'Welcome back ' . $_oid->getAuthId() . ' (' . $_user->email_addr_text . ')';
				return;
			}
			else
			{
				//	Create new identity...
				return $this->actionRegister( true, $_oid, $_REQUEST );
			}
		}

		//	No clue what is going on here. Just head back to login form
		$this->actionLogin();
	}

	/***
	 * Registration action
	 * 
	 * @var boolean True if calling from a completed OpenID authentication
	 * @var OpenIDConsumer The consumer object used in the authentication
	 */
	public function actionRegister( $fromOpenID = false, $consumer = null, $request = null )
	{
		$_model = new User();

		if ( $this->isPostRequest )
		{
			if ( $this->saveModel( $_model, $_POST, '/' ) )
				return;

			$_model->addError( 'form', 'Problemas de Tu!' );
		}

		if ( $fromOpenID )
		{
			$_model->openid_url_text = $_model->openid_claimed_id_text = filter_var( PS::o( $request, 'openid_claimed_id' ), FILTER_SANITIZE_STRING );
			$_model->openid_identity_text = filter_var( PS::o( $request, 'openid_identity' ), FILTER_SANITIZE_STRING );
		}

		$this->render( 'register', array( 'model' => $_model, 'fromOpenID' => $fromOpenID, 'consumer' => $consumer, 'request' => $request ) );
	}

	public function actionGetHostMeta()
	{
		$this->layout = false;
		$this->render( 'hostMeta' );
	}

	public function actionDescribe()
	{
		$this->layout = false;
		if ( $_uri = filter_input( INPUT_GET, 'uri', FILTER_SANITIZE_STRING ) )
			$this->render( 'describe', array( 'uri' => $_uri ) );
	}

	//********************************************************************************
	//* Private Methods
	//********************************************************************************
}
