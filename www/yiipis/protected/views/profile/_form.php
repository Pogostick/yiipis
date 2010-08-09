<?php
/*
 * This file is part of YiiPIS
 *
 * @copyright Copyright &copy; 2010 Pogostick, LLC
 * @link http://www.pogostick.com Pogostick, LLC.
 * @license http://www.pogostick.com/licensing
 */

/**
 * profile._form sub view
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

$this->pageTitle = PS::_a()->name;

//	Load captcha
if ( ! $update )
{
	PS::_rsf( '/scripts/jquery.simpleCaptcha-0.2.min.js' );
	PS::_rc( 'captcha.css', '.captchaImage { margin: 0 2px; } .simpleCaptchaSelected { border: 2px solid #393; }' );

	$model->country_code = 2224; // US

	echo <<<HTML
<h1>Welcome to YiiPIS!</h1>
<div>
	<p>Blurb</p>
</div>
HTML;
	}
	else
	{
		$model->confirmPassword = $model->password_text;
		$model->confirmEmail = $model->email_addr_text;

		echo <<<HTML
<h1>Your Profile</h1>
<div>
	<p>Profile instructions</p>
</div>
HTML;
	}

	//	Some defaults...
	if ( ! $model->mail_country_code ) $model->mail_country_code = 2224;

	$_arFormOpts = array(
		//	Info
		'id' => 'frmRegister',

		//	Our model
		'formModel' => $model,

		//	Gimme jQuery UI styling
		'uiStyle' => PS::UI_JQUERY,

		//	We want error summary...
		'errorSummary' => true,

		//	And validate the form too
		'validate' => true,

		'validateOptions' => array(
			'ignoreTitle' => true,
			'errorClass' => 'ps-validate-error',
			'rules' => array(
				'User[mail_postal_code_text]' => array(
					'required' => true,
				),
/*
 * Removed 2010-06-03 GHA
  				'User[user_name_text]' => array(
					'alphanumeric' => true,
					'required' => $update ? true : false,
					'remote' => array(
						'url' => '/ajax/isUnique/user/' . PS::nvl( Yii::app()->user->getId(), 0 ),
						'type' => 'post',
					),
				),
 */
				'User[password_text]' => array(
					'required' => $update ? true : false,
				),
				'User[confirmPassword]' => array(
					'required' => $update ? true : false,
					'equalTo' => '#User_password_text',
				),
				'User[email_addr_text]' => array(
					'required' => $update ? true : false,
					'email' => true,
					//
					//	Unique emails are required to integrate with WHMCS...
					//
					'remote' => array(
						'url' => '/ajax/isUnique/email/' . PS::nvl( Yii::app()->user->getId(), 0 ),
						'type' => 'post',
					),
				),
				'User[confirmEmail]' => array(
					'required' => $update ? true : false,
					'email' => true,
					'equalTo' => '#User_email_addr_text',
				),
				'User[terms_agree_ind]' => array(
					'required' => '#User_terms_agree_ind',
				),
			),
			'messages' => array(
/*
				'User[user_name_text]' => array(
					'required' => 'You must select a user name.',
				),
				'User[user_name_text]' => array(
					'remote' => 'The user name you\'ve entered is not available.',
				),
 */
				'User[email_addr_text]' => array(
					'remote' => 'The email address you\'ve entered is already registered.',
				),
				'User[confirmEmail]' => array(
					'equalTo' => 'The two email addresses do not match.',
				),
				'User[confirmPassword]' => array(
					'equalTo' => 'The two passwords do not match.',
				),
				'User[terms_agree_ind]' => array(
					'required' => 'You must agree to the Terms and Conditions.',
				),
			),
		),
	);

	//	Our form fields
	$_arFormOpts['fields'] = array(
		array( 'beginFieldset', 'Account Information' ),
			array( $update ? PS::CODE_DISPLAY : PS::DD_CODE_TABLE, 'user_type_code', array( 'codeType' => 'user_type_code', 'condition' => ! $update ) ),
			array( PS::TEXT, 'email_addr_text', array( 'class' => 'email', 'value' => $update ? $model->email_addr_text : null ) ),
			array( PS::TEXT, 'confirmEmail', array( 'class' => 'email', 'value' => $update ? $model->email_addr_text : null ) ),
//			array( PS::TEXT, 'user_name_text', array( 'label' => $model->isNewRecord ? 'Desired User Name' : 'User Name', 'style' => 'width:150px' ) ),
			array( PS::PASSWORD, 'password_text', array( 'autocomplete' => 'off', 'value' => $update ? $model->password_text : null ) ),
			array( PS::PASSWORD, 'confirmPassword', array( 'autocomplete' => 'off', 'value' => $update ? $model->password_text : null ) ),
		array( 'endFieldset' ),

		array( 'beginFieldset', 'The Basics' ),
			array( PS::TEXT, 'first_name_text' ),
			array( PS::TEXT, 'last_name_text' ),
			array( PS::TEXT, 'comp_name_text' ),
			array( PS::TEXT, 'company_url_text', array( 'class' => 'required url', 'hint' => 'Must include http:// or https://' ) ),
			array( PS::TEXT, 'phone_nbr_text', array( 'class' => 'required' ) ),
			array( PS::TEXT, 'alt_phone_nbr_text' ),
		array( 'endFieldset' ),

		array( 'beginFieldset', 'Your Website<span class="help"></span>', array( 'id' => 'publisher-site-info', 'style' => 'display:none;' ) ),
			array( 'html',
				CITMHelp::createInstructional( 'Please enter the name and URL for the website upon which you want InTopic ads to appear. You will be able to enter multiple websites once your account is approved. The website name is for your own reference only.' ),
			),
			array( PS::TEXT, 'site_name_text', array( 'class' => 'required', 'hint' => 'How you would like it to appear in your reports' ) ),
			array( PS::TEXT, 'site_url_text', array( 'class' => 'required url', 'hint' => 'Must include http:// or https://' ) ),
		array( 'endFieldset' ),

		array( 'beginFieldset', 'Mailing Address' ),
			array( PS::TEXT, 'mail_address_1_text' ),
			array( PS::TEXT, 'mail_address_2_text', array( 'labelOptions' => array( 'noSuffix' => true ) ) ),
			array( PS::TEXT, 'mail_city_text' ),
			array( PS::DD_CODE_TABLE, 'mail_country_code', array( 'class' => 'required', 'codeType' => 'country' ) ),
			array( PS::DD_CODE_TABLE, 'mail_state_code', array( 'codeType' => 'state' ) ),
			array( PS::TEXT, 'mail_prov_text' ),
			array( PS::TEXT, 'mail_postal_code_text', array( 'size' => 20 ) ),
		array( 'endFieldset' ),
	);

	if ( ! $update )
	{
		$_arFormOpts['fields'][] = array( 'beginFieldset', 'Miscellaneous' );
		$_arFormOpts['fields'][] = array( 'html', '<div id="captcha" class="simple" style="margin:5px auto;text-align:center;font-size:13px !important; font-weight:bold !important"></div><br />' );
		$_arFormOpts['fields'][] = array( 'html', '<div class="agreement"><input type="checkbox" class="required" name="User[terms_agree_ind]" id="User_terms_agree_ind" /><label for="User_terms_agree_ind">By checking this box, I agree to the <a target="_blank" href="http://www.' . Yii::app()->params['systemName'] . 'media.com/site/terms/">' . Yii::app()->params['fullSiteName'] . ' Terms &amp; Conditions</a></label><br /></div><br />' );
		$_arFormOpts['fields'][] = array( 'endFieldset' );
	}

	$_arFormOpts['fields'][] = array( 'submit', array( 'label' => $update ? 'Save' : 'Register', 'icon' => 'person', 'noBorder' => true ) );

	CPSForm::create( $_arFormOpts );
?>
<script type="text/javascript">
<!--
	var _toggleStateProvince = function() {
		if ( $('#User_mail_country_code').val() == 2224 ) {
			$('#User_mail_state_code').addClass('required');
			$('#User_mail_prov_text').removeClass('required');
			$('#PIF_User_mail_state_code').show();
			$('#PIF_User_mail_prov_text').hide();
		} else {
			$('#User_mail_prov_text').addClass('required');
			$('#User_mail_state_code').removeClass('required');
			$('#PIF_User_mail_state_code').hide();
			$('#PIF_User_mail_prov_text').show();
		}
	};

	/**
	 * Turns off company url requirement on publishers
	 */
	var _setRequiredFields = function() {
		if ( $("#User_user_type_code").val() == '<?php echo User::PUBLISHER; ?>' ) {
			$('#PIF_User_company_url_text').hide();
			
			if ( $('#User_company_url_text').hasClass('required') ) {
				$('label[for=User_company_url_text]').removeClass('required');
				$('label[for=User_company_url_text] span.required').remove();
				$('#User_company_url_text').removeClass('required');
				$('label[for=User_site_url_text]').addClass('required').append('<?php echo PS::$afterRequiredLabel; ?>');
			}

			$('#publisher-site-info').show();
			$('#User_site_url_text').addClass('required');
			$('label[for=User_site_name_text]').addClass('required').append('<?php echo PS::$afterRequiredLabel; ?>');
			$('#User_site_name_text').addClass('required');
		} else {
			$('#PIF_User_company_url_text').show();
			if ( ! $('#User_company_url_text').hasClass('required') ) {
				$('label[for=User_company_url_text]').addClass('required').append('<?php echo PS::$afterRequiredLabel; ?>');
				$('#User_company_url_text').addClass('required');
			}

			$('label[for=User_site_url_text]').removeClass('required');
			$('label[for=User_site_url_text] span.required').remove();
			$('#User_site_url_text').removeClass('required');
			$('label[for=User_site_url_text]').removeClass('required');
			$('label[for=User_site_name_text] span.required').remove();
			$('#User_site_name_text').removeClass('required');
			$('#publisher-site-info').hide();
		}
	}

	$(function(){
		$('#User_terms_agree_ind').click(function(e){
			$('#User_terms_agree_ind').valid();
		});

		$('#captcha').simpleCaptcha({numImages:5,scriptPath:'/scripts/simpleCaptcha.php'});

		$('#User_mail_country_code').change(function(){
			_toggleStateProvince();
		});

		$('#User_user_type_code').change(function(){
			_setRequiredFields();
		});

		//	First run...
		_toggleStateProvince();
		_setRequiredFields();
	});
//-->
</script>
