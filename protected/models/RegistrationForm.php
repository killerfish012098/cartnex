<?php

class RegistrationForm extends CFormModel
{
	public $firstname;
	public $lastname;
	public $telephone;
	public $password;
	public $confirm;
	public $gender;
	public $newsletter;
	public $email;
	public $acknowledgement;

	public function rules()
	{
		$required='telephone,firstname,lastname,newsletter,gender,email,password,confirm';
		if(Yii::app()->config->getData('CONFIG_STORE_ACCOUNT_TERMS'))
		{
			$required.=',acknowledgement';
		}

		return array(
			// name, email, subject and body are required
			array($required, 'required'),
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