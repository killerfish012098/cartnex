<?php

class ForgotpasswordForm extends CFormModel
{
	public $email;

	public function rules()
	{
		return array(
			// name, email, subject and body are required
			array('email', 'required'),
			// email has to be a valid email address
			array('email', 'email'),
			// verifyCode needs to be entered correctly
		);
	}

	public function attributeLabels()
	{
		return array(
			'verifyCode'=>'Verification Code',
		);
	}
}