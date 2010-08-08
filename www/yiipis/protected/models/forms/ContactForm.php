<?php

/**
 * ContactForm class.
 * ContactForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
class ContactForm extends CFormModel
{
	public $first_name_text;
	public $last_name_text;
	public $comp_name_text;
	public $comp_url_text;
	public $comments_text;
	public $email_addr_text;
	public $subj_text;
	public $body_text;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			// name, email, subject and body are required
			array('first_name_text, last_name_text, email_addr_text, comments_text', 'required'),
			// email has to be a valid email address
			array('email_addr_text', 'email'),
		);
	}

	/**
	 * Declares customized attribute labels.
	 * If not declared here, an attribute would have a label that is
	 * the same as its name with the first letter in upper case.
	 */
	public function attributeLabels()
	{
		return array(
			'first_name_text' => 'First Name',
			'last_name_text' => 'Last Name',
			'comp_name_text' => 'Company Name',
			'comments_text' => 'Additional Comments',
			'email_addr_text' => 'Your Email Address',
			'subj_text' => 'How can we help?',
			'body_text' => 'Please elaborate',
			'verifyCode' => 'Verification Code',
		);
	}
}