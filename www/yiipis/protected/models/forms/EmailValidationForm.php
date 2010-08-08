<?php

/**
 * EmailValidationForm class.
 */
class EmailValidationForm extends CFormModel
{
	//********************************************************************************
	//* Member Variables
	//********************************************************************************
	
	/**
	* The validation hash code
	* 
	* @var string
	*/
	protected $m_sValidationHash;
	public function getValidationHash() { return $this->m_sValidationHash; }
	public function setValidationHash( $sValue ) { $this->m_sValidationHash = $sValue; }

	/**
	 * The type of user
	 * 	
	 * @var int
	 */
	protected $m_iUserTypeCode;
	public function getUserTypeCode() { return $this->m_iUserTypeCode; }
	
	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			array( 'validationHash', 'required' ),
			array( 'validationHash', 'authenticate' ),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'validationHash' => 'Email Verification Code',
		);
	}

	/**
	 * Authenticates the hash.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	public function authenticate()
	{
		// Only authenticate when no input errors
		if ( ! $this->hasErrors() )
		{
			if ( null !== ( $_oUser = User::model()->find( 'valid_ind = 0 and valid_email_hash_text = :valid_email_hash_text', array( ':valid_email_hash_text' => $this->m_sValidationHash ) ) ) )
			{
				$_oUser->valid_ind = 1;
				$_oUser->verify_date = date( 'Y-m-d H:i:s' );
				$this->m_iUserTypeCode = $_oUser->user_type_code;
				return $_oUser->update( array( 'valid_ind', 'verify_date' ) );
			}
				
			$this->addError( 'valid_email_hash_text', 'Invalid email verification code' );
		}
		
		return false;
	}
}
