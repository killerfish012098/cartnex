<?php

class ProfileForm extends CFormModel
{
	public $firstname;
	public $lastname;
	public $telephone;
	public $password;
	public $confirm;
	public $gender;
	public $newsletter;
	public $email;

	public function rules()
	{
		return array(
			// name, email, subject and body are required
			array('telephone,firstname,lastname,newsletter,gender,email', 'required'),
			array('password, confirm', 'length', 'min'=>6),
			array('confirm', 'compare', 'compareAttribute'=>'password'),
			array('telephone', 'numerical', 'integerOnly'=>true),
			array('telephone', 'length', 'max'=>12),
			array('email', 'email'),
		);
	}

	public function attributeLabels()
	{
		return array(
		);
	}
}