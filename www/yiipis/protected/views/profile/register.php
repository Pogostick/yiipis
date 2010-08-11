<?php
/**
 * register.php
 * Advertiser registration
 * 
 * @version SVN: $Revision: 7 $
 * @modifiedby $LastChangedBy: jablan $
 * @lastmodified  $Date: 2010-02-22 12:30:20 -0500 (Mon, 22 Feb 2010) $
 */

	$this->pageTitle = PS::_a()->name;
	PS::setFormFieldContainerClass( 'row' );
	PS::$afterRequiredLabel = null;
	PS::setLabelSuffix('');

	//	Change the form based on login type
	if ( $fromOpenID )
	{
		$_fieldList = array(
			array( 'html', '<h1 style="margin-bottom:25px;text-align:center;">Come on in, the water\'s fine!</h1>' ),

			array( PS::TEXT_DISPLAY, 'openid_url_text' ),
			array( 'html', PS::hiddenField( 'User[openid_claimed_id_text]', $mode->openid_claimed_id_text ) ),
			array( 'html', PS::hiddenField( 'User[openid_identity_text]', $mode->openid_identity_text ) ),

			array( 'html', '<hr class="gold" />' ),

			array( PS::TEXT, 'user_name_text', array( 'class' => 'ps-short' ) ),
			array( PS::PASSWORD, 'password_text', array( 'autocomplete' => 'off', 'value' => $update ? $model->password_text : null ) ),
			array( PS::PASSWORD, 'confirmPassword', array( 'autocomplete' => 'off', 'value' => $update ? $model->password_text : null ) ),
		);

		$this->renderPartial( '_registerFormOpenIDCopy' );
	}
	else
	{
		$_fieldList = array(
			array( 'html', '<h1 style="margin-bottom:25px;text-align:center;">Come on in, the water\'s fine!</h1>' ),

			array( PS::TEXT, 'email_addr_text', array( 'class' => 'email' ) ),
			array( PS::PASSWORD, 'password_text', array( 'autocomplete' => 'off', 'value' => $update ? $model->password_text : null ) ),
			array( PS::PASSWORD, 'confirmPassword', array( 'autocomplete' => 'off', 'value' => $update ? $model->password_text : null ) ),

			array( 'html', '<hr class="gold" />' ),

			array( PS::TEXT, 'user_name_text', array( 'class' => 'ps-short' ) ),
		);

		$this->renderPartial( '_registerFormCopy' );
	}

	$_fieldList[] = array( 'html', '<div class="agreement"><input type="checkbox" class="required" name="User[terms_agree_ind]" id="User_terms_agree_ind" /><label for="User_terms_agree_ind">By checking this box, I agree to the <a target="_blank" href="/terms/">YiiPIS Terms &amp; Conditions</a></label><br /></div>' );
	$_fieldList[] = array( 'submit', array( 'label' => $update ? 'Save' : 'Complete Registration', 'icon' => 'check', 'noBorder' => true ) );

	$_arFormOpts = array(
		//	Info
		'id' => 'frmRegister',
		'action' => 'register',
		'method' => 'POST',

		//	Our model
		'formModel' => $model,
		'formClass' => 'form yiipis-form',
		'formContainerClass' => PS::STD_JQUI_FORM_CONTAINER_CLASS . ' form-short',

		//	Gimme jQuery UI styling
		'uiStyle' => PS::UI_JQUERY,

		//	We want error summary...
		'errorSummary' => true,

		'fields' => $_fieldList,

		//	And validate the form too
		'validate' => true,

		'validateOptions' => array(
			'ignoreTitle' => true,
			'errorClass' => 'ps-validate-error',
			'rules' => array(
				'User[password_text]' => array(
					'required' => $update ? true : false,
				),
				'User[confirmPassword]' => array(
					'required' => $update ? true : false,
					'equalTo' => '#User_password_text',
				),
			),
			'messages' => array(
				'User[terms_agree_ind]' => array(
					'required' => 'You must agree to the Terms and Conditions.',
				),
				'User[confirmPassword]' => array(
					'equalTo' => 'The two passwords do not match.',
				),
				'User[password_text]' => array(
					'equalTo' => 'The two passwords do not match.',
				),
			),
		),
	);

	CPSForm::create( $_arFormOpts );

	echo $this->renderPartial( '_registerForm',
		array(
			'model' => $model,
			'update' => false,
		)
	);
