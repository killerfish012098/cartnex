<?php

class AddressForm extends CFormModel
{
	public $firstname;
	public $lastname;
	public $telephone;
	public $address_1;
	public $address_2;
	public $city;
	public $company;
	public $id_country;
	public $id_state;
	public $postcode;
	public $id_customer;

	public function rules()
	{
		return array(
			// name, email, subject and body are required
			array('id_customer,postcode,id_state,id_country,city,address_1,telephone,firstname,lastname', 'required'),
			array('id_customer, id_state, id_country', 'numerical', 'integerOnly'=>true),
			array('firstname, lastname, city', 'length', 'max'=>150),
			array('telephone, postcode', 'length', 'max'=>30),
			array('company', 'length', 'max'=>100),
			array('address_1, address_2', 'length', 'max'=>255),
		);
	}

	public function attributeLabels()
	{
		return array('id_state'=>Yii::t('account','entry_state'),
					'id_country'=>Yii::t('account','entry_country'),
		);
	}
}