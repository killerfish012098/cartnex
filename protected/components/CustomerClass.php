<?php

class CustomerClass {

    public function init() {
        
    }

	public function addAddress($data)
	{
		Yii::app()->db->createCommand()->insert('{{customer_address}}',$data);
	}

	public function addCustomer($data)
	{
		Yii::app()->db->createCommand()->insert('{{customer}}',$data);
	}

	public function getAddresses(){
		$customer_details=Yii::app()->db->createCommand("select *,s.name as state,co.name as country from {{customer_address}} c left join {{state}} s on s.id_state=c.id_state left join {{country}} co on co.id_country=c.id_country where id_customer='".Yii::app()->session['user_id']."'");
		return $customer_details->queryAll();
	}

	public function getAddress($id){
		$customer_details=Yii::app()->db->createCommand("select  firstname,lastname,telephone,company,address_1,address_2,city,id_state,id_country,postcode from {{customer_address}} where id_customer_address='".$id."'");
		return $customer_details->queryRow();
	}

	public function getCustomerGroup($id)
	{
		$languages=Yii::app()->config->getData('languages');
		$id_language=$languages[Yii::app()->session['language']]['id_language'];
		$customer_group_details=Yii::app()->db->createCommand("select * from {{customer_group_description}} where id_language='".$id_language."' and id_customer_group='".(int)$id."'");
		return $customer_group_details->queryRow();
	}

	public function getCustomer($id)
	{	
		return Yii::app()->db->createCommand("select * from {{customer}} where id_customer='".(int)$id."'")->queryRow();
	}

	public function updateCustomer($input)
	{
		return Yii::app()->db->createCommand()->update('{{customer}}',$input['data'],'id_customer=:id',array(':id'=>$input['id_customer']));
	}

	public function deleteAddress($id)
	{
		Yii::app()->db->createCommand()->delete('{{customer_address}}', 'id_customer_address=:id', array(':id'=>$id));
		return 1;
	}

	public function randomPassword()
	{	
		$length = 6;
		$chars = array_merge(range(0,9), range('a','z'), range('A','Z'));
		shuffle($chars);
		$password = implode(array_slice($chars, 0, $length));
		return $password;
	}

	public function hashPassword($password)
	{
		return CPasswordHelper::hashPassword($password);
	}

	public function getDefaultAddress(){
		$connection = Yii::app()->db;
		/*$command = $connection->createCommand('select c.newsletter,c.firstname,c.lastname,c.telephone,c.email,ca.address_1,ca.city,s.name as sname,co.name as cname from {{customer}} c join {{customer_address}} ca on ca.id_customer=c.id_customer join r_state s on s.id_state=ca.id_state join r_country co on co.id_country=ca.id_country where c.id_customer='.Yii::app()->session['user_id']);*/
		$command=$connection->createCommand('select c.*,ca.firstname as address_firstname,ca.lastname as address_lastname,ca.telephone as address_telephone,ca.company as address_company,ca.address_1,ca.address_2,ca.postcode as address_postcode,ca.city as address_city,s.name as state ,co.name as country from {{customer}} c inner join {{customer_address}} ca on c.id_customer_address_default=ca.id_customer_address left join {{state}} s on ca.id_state=s.id_state left join {{country}} co on co.id_country=ca.id_country where c.id_customer="'.$_SESSION['user_id'].'"');
		
		return $command->queryRow();
	}
 
}