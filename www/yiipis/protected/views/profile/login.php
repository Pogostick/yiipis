<?php
/*
 * This file is part of YiiPIS
 *
 * @copyright Copyright &copy; 2010 Pogostick, LLC
 * @link http://www.pogostick.com Pogostick, LLC.
 * @license http://www.pogostick.com/licensing
 */

/**
 * profile.login view
 *
 * @package 	yiipis
 * @subpackage 	views.profile
 *
 * @author 		Jerry Ablan <jablan@pogostick.com>
 * @version 	SVN $Id$
 * @since 		v1.0.0
 *
 * @filesource
 */

PS::setFormFieldContainerClass( 'row' );
PS::$afterRequiredLabel = null;
PS::setLabelSuffix('');

//	If user tried OpenID and is returning with error, set focus accordingly...
$_extraScript = ( $wasOpenID ? "\$('#LoginForm_openIDUrl').trigger('focus');" : null );

//	Register a script to be placed after our validation widget.
PS::_rs( null,<<<JAVASCRIPT
	//	Register our validation script, after validation form widget created...
	var _u = true, _o = false;

	//	Indicate to the user which fields are important
	$('#LoginForm_userName,#LoginForm_password').focus(function(){
		if ( $('#is-open-id').val('1') ) {
			$('#PIF_LoginForm_userName,#PIF_LoginForm_password,#PIF_LoginForm_rememberMe').animate({opacity:1.0},250);
			$('#PIF_LoginForm_openIDUrl').animate({opacity:0.50},800);
			$('span.openid-login').removeClass('yiipis-icon-star');
			$('span.site-login').addClass('yiipis-icon-star');
			$('#is-open-id').val('0');
		}
	});
	
	$('#LoginForm_openIDUrl').focus(function(){
		if ( $('#is-open-id').val('0') ) {
			$('#PIF_LoginForm_openIDUrl').animate({opacity:1.0},250);
			$('#PIF_LoginForm_userName,#PIF_LoginForm_password,#PIF_LoginForm_rememberMe').animate({opacity:0.50},800);
			$('span.site-login').removeClass('yiipis-icon-star');
			$('span.openid-login').addClass('yiipis-icon-star');
			$('#is-open-id').val('1');
		}
	});

	$('#frmLogin').submit(function(){
		//	Require username if there is no valid OpenID
		$('#LoginForm_userName').rules('remove','required');
		$('#LoginForm_userName')
			.rules('add',{
				required : function( element ) {
					return $('#is-open-id').val() == '0';
				}
			});

		//	Require password if user name is valid
		$('#LoginForm_password').rules('remove','required');
		$('#LoginForm_password')
			.rules('add',{
				required : function( element ) {
					//	Only required if user is required
					return $('#is-open-id').val() == '0';
				}
			});

		//	Require and validate OpenID url if no username/password
		$('#LoginForm_openIDUrl').rules('remove','required');
		$('#LoginForm_openIDUrl')
			.rules('add',{
				required : function( element ) {
					//	Only required if user is not required
					return $('#is-open-id').val() == '1';
				}
			});

		return true;
	});
	
	{$_extraScript}
JAVASCRIPT
, CClientScript::POS_READY );

//	Add a submit handler to the page to adjust validation based on input...
PS::_rc( null,<<<CSS
	div#content-column div.ui-edit-container {
		margin:10px auto 0;
		width:768px;
	}

	#frmLogin .ps-submit-button-bar {
		margin-top:25px !important;
		width:96%;
	}
CSS
);

$_fields = array(
	array( 'html', '<h1 style="margin-bottom:25px;text-align:center;">Login, stay awhile...</h1>' ),

	array( PS::TEXT, 'userName', array( 'class' => 'email required', '_appendHtml' => PS::tag( 'span', array( 'class' => 'yiipis-icon yiipis-icon-after-input yiipis-icon-star yiipis-icon-star-empty site-login', 'value' => $form->userName ), '' ) ) ),
	array( PS::PASSWORD, 'password', array( 'class' => 'ps-short required', 'hint' => '<a href="/profile/resetPassword">Forgot your password?</a>' ) ),
	array( PS::CHECK, 'rememberMe', array( 'style' => 'vertical-align:middle;margin:0 auto;margin-right:5px;', '_appendHtml' => '&nbsp;<span style="font-size:10pt;">Not recommended if you are using a public computer.</span>' ) ),

	array( 'html', '<div><h1 style="margin:15px 0;width:100%;text-align:center;">Or</h1></div>' ),

	array( PS::TEXT, 'openIDUrl',
		array(
			'class' => 'url',
			'hint' => 'Example: http://username.myopenid.com',
			'_appendHtml' => PS::tag( 'span', array( 'class' => 'yiipis-icon yiipis-icon-after-input yiipis-icon-star-empty openid-login' ), '' ),
			'labelOptions' => array(
				'style' => 'font-size:19px;white-space:nowrap;text-align:left;display:block;margin-left:160px;'
		),
		'value' => $form->openIDUrl,
		'label' => 'Sign in with OpenID&nbsp;<span><a target="_blank" class="hint-link" href="http://openid.net/what">What is OpenID?</a></span>')
	),

	array( 'html', PS::hiddenField( 'is-open-id', '0', array( 'id' => 'is-open-id' ) ) ),
	array( 'submit', array( 'label' => 'Login', 'icon' => 'person' ) ),
);

//	Build our form options array...
$_arFormOpts = array(
	//	Info
	'id' => 'frmLogin',
	'style' => 'width:768px;',

	'formHeader' => null,
	'formClass' => 'form',

	//	Our model
	'formModel' => $form,

	//	Gimme jQuery UI styling
	'uiStyle' => PS::UI_JQUERY,

	//	We want error summary...
	'errorSummary' => true,
	
	'errorSummaryOptions' => array(
		'errorIconClass' => 'yiipis-icon-32 yiipis-icon-error-summary yiipis-icon-exclamation',
		'headerTag' => 'h2',
		'header' => false,
		'singleErrorListClass' => 'hide-bg',
	),

	//	Our form fields, below
	'fields' => $_fields,

	//	And validate the form too
	'validate' => true,

	//	Set some validation options
	'validateOptions' => array(
		'onsubmit' => false,
		'ignoreTitle' => true,
		'errorClass' => 'ps-validate-error',
		'messages' => array(
			'LoginForm[openIDUrl]' => 'Invalid OpenID URL',
		)
	),
);

//	Set our fields and create the form.
CPSForm::create( $_arFormOpts );
?>
