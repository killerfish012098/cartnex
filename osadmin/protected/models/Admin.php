<?php

class Admin extends CActiveRecord
{
	public $admin;
	public $admin_role;
	public $confirm;
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return '{{admin}}';
	}

	public function rules()
	{
		return array(
			array('id_admin_role, first_name, last_name, email', 'required'),
			array('email', 'unique'),
			array('email', 'email'),
			array('password, confirm', 'length', 'min'=>6),
			array('password, confirm', 'required','on'=>'insert'),
			array('confirm', 'compare', 'compareAttribute'=>'password','on'=>'insert'),
			array('confirm', 'compare', 'compareAttribute'=>'password','on'=>'update'),
			array('id_admin_role, status,phone', 'numerical', 'integerOnly'=>true),
			array('status','default','value'=>1,'setOnEmpty'=>true,'on'=>'insert'),
			array('phone', 'length', 'max'=>12),
			array('first_name, last_name, email', 'length', 'max'=>50),
			array('date_created','default','value'=>new CDbExpression('NOW()'),'setOnEmpty'=>true,'on'=>'insert'),
            array('date_modified','default','value'=>new CDbExpression('NOW()'),'setOnEmpty'=>false,'on'=>'update'),
            array('date_created,date_modified','default','value'=>new CDbExpression('NOW()'),'setOnEmpty'=>false,'on'=>'insert'),
			array('admin,admin_role,id_admin, id_admin_role, password, first_name, last_name,admin_role, phone, email, date_created, present_visit_date, last_visit_date, date_modified, status', 'safe', 'on'=>'search'),
		);
	}
	

	public function relations()
	{
		return array(
			'adminrole'=>array(self::BELONGS_TO,'AdminRole','id_admin_role'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id_admin_role' => Yii::t('administrators','entry_id_admin_role'),
			'password' => Yii::t('admin_role','entry_admin_role'),
			'password' => Yii::t('administrators','entry_password'),
			'confirm' => Yii::t('administrators','entry_password_confirm'),
			'first_name' => Yii::t('administrators','entry_first_name'),
			'last_name' => Yii::t('administrators','entry_last_name'),
			'phone' => Yii::t('administrators','entry_phone'),
			'email' => Yii::t('administrators','entry_email'),
			'status' => Yii::t('administrators','entry_status'),
		);
	}

	public function validatePassword($password)
	{
		return CPasswordHelper::verifyPassword($password,$this->password);
	}


	public function hashPassword($password)
	{
		return CPasswordHelper::hashPassword($password);
	}
	
	public function validateEmail($email)
	{
		$email=Yii::app()->db->createCommand("select id_admin from {{admin}} where email='".$email."'")->queryScalar();
		return $email;
	}
	public function randomPassword()
	{	
		$length = 6;
		$chars = array_merge(range(0,9), range('a','z'), range('A','Z'));
		shuffle($chars);
		$password = implode(array_slice($chars, 0, $length));
		return $password;
	}
        
    public function search()
	{
		
		$criteria=new CDbCriteria;
		$criteria->compare('adminrole.role',$this->admin_role,true);
		//$criteria->compare('concat(t.first_name," ",t.last_name)',$this->admin);
		//$criteria->select='CONCAT( t.first_name," ", t.last_name) AS admin ,t.*';
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		//$criteria->compare('phone',$this->phone,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('t.status',$this->status,true);
		$criteria->with=array('adminrole');
		//$criteria->order='id_admin desc';
           

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize' =>Yii::app()->config->getData('CONFIG_WEBSITE_ITEMS_PER_PAGE_ADMIN'),
            ),
			'sort' => array(
                'defaultOrder' => 'id_admin DESC',
			),
		));
	}
        
}
