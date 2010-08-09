<?php
/*
 * OpenIDConsumer.php
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
$_oidBase = Yii::getPathOfAlias( 'application.extensions.auth.openID.Auth.OpenID' ) . DIRECTORY_SEPARATOR;
require_once $_oidBase . 'Consumer.php';
require_once $_oidBase . 'FileStore.php';
require_once $_oidBase . 'SReg.php';
require_once $_oidBase . 'PAPE.php';

//	Make sure we have a session...
session_start();

/**
 * Wrapper class for the JanRain OpenID PHP library
 *
 * The authenticate method is modeled after the JanRain consumer example
 *
 * @package 	yiipis
 * @subpackage 	extensions.auth.openID
 *
 * @author 		Jerry Ablan <jablan@pogostick.com>
 * @author		JanRain, Inc. <openid@janrain.com>
 * @version 	SVN $Id$
 * @since 		v1.0.0
 *
 * @filesource
 *
 * @property $openIDUrl The url to authenticate
 * @property $returnUrl The url to which authentication responses will be sent
 * @property-read $openIDConsumer The OpenID consumer
 * @property-read $authResult The result of the current authentication request
 * @property-read $authMessage The message accompanying the current authentication request
 */
class OpenIDConsumer extends CPSComponent
{
	//********************************************************************************
	//* Member Variables
	//********************************************************************************

	/**
	 * @var string The return url for auth request responses
	 */
	protected $_returnUrl;
	public function getReturnUrl() { return $this->_returnUrl; }
	public function setReturnUrl( $value ) { $this->_returnUrl = $value; }

	/**
	 * @var string The OpenID URL to authenticate
	 */
	protected $_openIDUrl;
	public function getUrl() { return $this->_openIDUrl; }
	public function setUrl( $value ) { $this->_openIDUrl = $value; }

	/***
	 * @var string The OpenID Consumer
	 */
	protected $_openIDConsumer;
	public function getConsumer() { return $this->_openIDConsumer; }

	protected $_policyList;
	
	/**
	 * @var string The message accompanying the auth result upon completion
	 */
	protected $_authMessage;
	public function getAuthMessage() { return $this->_authMessage; }

	/**
	 * @var mixed The auth result upon completion
	 */
	protected $_authResult;
	public function getAuthResult() { return $this->_authResult; }

	/**
	 * @var string The authenticated OpenID URL
	 */
	protected $_authId;
	public function getAuthId() { return $this->_authId; }

	protected $_papePolicyList = array(
		PAPE_AUTH_MULTI_FACTOR_PHYSICAL,
		PAPE_AUTH_MULTI_FACTOR,
		PAPE_AUTH_PHISHING_RESISTANT
	);

	//********************************************************************************
	//* Public Methods
	//********************************************************************************

	/**
	 * Build a consumer object
	 *
	 * Any properties can be set via options array.
	 *
	 * @param array $options
	 */
	public function __construct( $options = array() )
	{
		parent::__construct( $options );

		$this->_openIDUrl = PS::nvl( PS::o( $options, 'oidIdentifier' ), PS::o( $_REQUEST, 'openid_identifier' ) );
		$this->_policyList = PS::o( $_REQUEST, 'policies', array() );
		$this->_openIDConsumer = $this->_getConsumer();
	}

	/**
	 * Begins an authentication request
	 * Redirects to OpenID provider and thus does not return
	 * @throws CException
	 */
	public function beginAuthentication()
	{
		//	Ew!
		global $Auth_OpenID_sreg_data_fields;

		//	Begin the OpenID authentication process.
		//	No auth request means we can't begin OpenID.
		if ( ! $_authRequest = $this->_openIDConsumer->begin( $this->_openIDUrl ) )
			throw new CException( 'Authentication error: not a valid OpenID' );

		//	Start up a new auth session
		$this->_authId = null;
		$this->_authResult = null;
		$this->_authMessage = null;
		
		$_sregRequest = Auth_OpenID_SRegRequest::build(
			array( 'email', 'nickname' ),
			array_keys( $Auth_OpenID_sreg_data_fields )
		);
		
		if ( $_sregRequest )
			$_authRequest->addExtension( $_sregRequest );

		if ( $_papeRequest = new Auth_OpenID_PAPE_Request( $this->_policyList ) )
			$_authRequest->addExtension( $_papeRequest );

		//	Redirect the user to the OpenID server for authentication.
		//	Store the token for this authentication so we can verify the
		//	response.
		
		//	For OpenID 1, send a redirect.  For OpenID 2, use a Javascript
		//	form to send a POST request to the server.
		if ( $_authRequest->shouldSendRedirect() )
		{
	        $_redirectUrl = $_authRequest->redirectURL( $this->_getTrustRoot(), $this->_returnUrl );

			// If the redirect URL can't be built, display an error message.
			if ( Auth_OpenID::isFailure( $_redirectUrl ) )
				throw new CException( 'Could not redirect to server: ' . $_redirectUrl->message );

			//	Send redirect.
            header( 'Location: ' . $_redirectUrl );
		}
		else
		{
	        //	Generate form markup and render it.
			$_formId = 'openid_message';
			$_formHtml = $_authRequest->htmlMarkup( $this->_getTrustRoot(), $this->_returnUrl, false, array( 'id' => $_formId ) );
			
			//	Display an error if the form markup couldn't be generated;
			//	otherwise, render the HTML.
			if ( Auth_OpenID::isFailure( $_formHtml ) )
				throw new CException( 'Could not redirect to server: ' . $_formHtml->message );
			
			return $_formHtml;
        }
	}

	/**
	 * Completes an authentication request
	 * @return boolean
	 */
	public function completeAuthentication()
	{
		$this->_authResult = false;
		
		//	Complete the authentication process using the server's response.
		$_response = $this->_openIDConsumer->complete( $this->_returnUrl );

		//	Check the response status.
		switch ( $_response->status )
		{
			case Auth_OpenID_CANCEL:		//	This means the authentication was cancelled.
				$_authMessage = 'Verification cancelled.';
				break;
			
			case Auth_OpenID_FAILURE:		//	Authentication failed; display the error message.
				$_authMessage = 'OpenID authentication failed: ' . $_response->message;
				break;
			
			case Auth_OpenID_SUCCESS:		//	This means the authentication succeeded
				$this->_authResult = true;
				
		        $_openID = $_response->getDisplayIdentifier();
				$this->_authId = $_cleanIdentity = htmlentities( $_openID );
				$_authMessage = "You have successfully verified <a href=\"{$_cleanIdentity}\">{$_cleanIdentity}</a> as your identity.";
				
				if ( $_response->endpoint->canonicalID )
				{
					$_cleanCanonicalIdentity = htmlentities( $_response->endpoint->canonicalID );
					$_authMessage .= '  (XRI CanonicalID: ' . $_cleanCanonicalIdentity . ') ';
				}
				
				$_sregResponse = Auth_OpenID_SRegResponse::fromSuccessResponse( $_response );
		        $_sreg = $_sregResponse->contents();

				if ( $_sregEmail = PS::o( $_sreg, 'email' ) ) $_authMessage .= "  You also returned '" . htmlentities( $_sregEmail ) . "' as your email.";
				if ( $_sregNick = PS::o( $_sreg, 'nickname' ) ) $_authMessage .= "  Your nickname is '" . htmlentities( $_sregNick ) . "'.";
				if ( $_sregName = PS::o( $_sreg, 'fullname' ) ) $_authMessage .= "  Your full name is '" . htmlentities( $_sregName ) . "'.";

				if ( $_papeResponse = Auth_OpenID_PAPE_Response::fromSuccessResponse( $_response ) )
				{
					if ( $_papeResponse->auth_policies )
					{
		                $_authMessage .= '<p>The following PAPE policies affected the authentication:</p><ul>';

		                foreach ( $_papeResponse->auth_policies as $_uri )
						{
		                    $_uri = htmlentities( $_uri );
							$_authMessage .= "<li><tt>{$_uri}</tt></li>";
						}
						
						$_authMessage .= '</ul>';
					}
					else
					{
		                $_authMessage .= '<p>No PAPE policies affected the authentication.</p>';
					}

					if ( $_papeResponse->auth_age )
						$_authMessage .= '<p>The authentication age returned by the server is: <tt>' . htmlentities( $_papeResponse->auth_age ) . '</tt></p>';

					if ( $_papeResponse->nist_auth_level )
						$_authMessage .= '<p>The NIST auth level returned by the server is: <tt>' . htmlentities( $_papeResponse->nist_auth_level ) . '</tt></p>';
				}
				else
		            $_authMessage .= "<p>No PAPE response was sent by the provider.</p>";
				break;
		}

		//	Store the auth message
		$this->_authMessage = $_authMessage;

		//	Return the result
		return $this->_authResult;
	}

	//********************************************************************************
	//* Private Methods
	//********************************************************************************

	protected function &_getStore()
	{
		/**
		 * This is where the example will store its OpenID information.
		 * You should change this path if you want the example store to be
		 * created elsewhere.  After you're done playing with the example
		 * script, you'll have to remove this directory manually.
		 */
		$_storePath = "/tmp/_php_consumer_test";

		if ( ! file_exists( $_storePath ) && ! mkdir( $_storePath ) )
			throw new CException( 'Could not create the FileStore directory: ' . $_storePath );

		return new Auth_OpenID_FileStore( $_storePath );
	}
	
	protected function &_getConsumer()
	{
		//	Create a consumer object using the store object created earlier.
		$_store = $this->_getStore();
		$_consumer =& new Auth_OpenID_Consumer( $_store );
		return $_consumer;
	}

	protected function _getTrustRoot()
	{
		return ( 'on' == PS::o( $_SERVER, 'HTTPS' ) ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . ':' . $_SERVER['SERVER_PORT'] . DIRECTORY_SEPARATOR;
	}
}