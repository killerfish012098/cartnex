<?php


class Customer extends CActiveRecord
{
	public $confirm;
	public function tableName()
	{
		return '{{customer}}';
	}

	public function rules()
	{
		return array(
            array('firstname,lastname,email','required'),
            array('email', 'email'),
			array('email','unique'),
			array('password, confirm', 'length', 'min'=>6),
			array('password, confirm', 'required','on'=>'insert'),
			array('confirm', 'compare', 'compareAttribute'=>'password'),
			array('telephone', 'numerical', 'integerOnly'=>true),
			array('telephone', 'length', 'max'=>12),
			array('id_customer_address_default, id_customer_group, status, approved', 'numerical', 'integerOnly'=>true),
			array('gender, newsletter', 'length', 'max'=>1),
			array('status,approved','default','value'=>1,'setOnEmpty'=>true,'on'=>'insert'),
			array('date_created,date_modified','default','value'=>new CDbExpression('NOW()'),'setOnEmpty'=>false,'on'=>'insert'),
			array('id_customer, gender, firstname, lastname, email, id_customer_address_default, id_customer_group, ip, telephone, cart, wishlist, fax, password, newsletter, status, approved', 'safe'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'gender' => Yii::t('customers','entry_gender'),
			'firstname' => Yii::t('customers','entry_firstname'),
			'lastname' => Yii::t('customers','entry_lastname'),
			'fax' => Yii::t('customers','entry_fax'),
			'email' => Yii::t('customers','entry_email'),
			'password' => Yii::t('customers','entry_password'),
			'confirm' => Yii::t('customers','entry_confirm_password'),
			'newsletter' => Yii::t('customers','entry_newsletter'),
			'status' => Yii::t('customers','entry_status'),
			'approved' => Yii::t('customers','entry_approved'),
			'id_customer_group' => Yii::t('customers','entry_customer_group'),
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;
	
		$criteria->compare('firstname',$this->firstname,true);
		$criteria->compare('lastname',$this->lastname,true);
		$criteria->compare('email',$this->email,true);
		//$criteria->compare('id_customer_group',$this->id_customer_group);
		$criteria->compare('status',$this->status);
		$criteria->compare('approved',$this->approved);
		$criteria->compare('date_created',$this->date_created,true);
		//$criteria->order='id_customer desc';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                'pagination'=>array(
                        'pageSize' =>Yii::app()->config->getData('CONFIG_WEBSITE_ITEMS_PER_PAGE_ADMIN'),
                ),
				'sort' => array(
					'defaultOrder' => 'id_customer DESC',
					),
		));
	}
    
 	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getCustomerInfo($input)
    {
        $criteria=new CDbCriteria;
        
        switch ($input['data'])
        {
            case 'PendingApproval':
								if(Yii::app()->config->getData('CONFIG_STORE_APPROVE_NEW_CUSTOMER')){
									$criteria->select="count(approved) as approved";
									$criteria->condition='approved=0';
									$model=Customer::model()->find($criteria);
									$return=$model->approved;
								}
                            break;
                        
            case 'TotalCustomers':
                                $criteria->select="count(id_customer) as id_customer";
                                //$criteria->condition='approved=0';
                                $model=Customer::model()->find($criteria);
                                $return=$model->id_customer;
                            break;
                        
            case 'RegisteredToday':
                                $criteria->select="count(id_customer) as id_customer";
                                $criteria->condition='date(date_created)="'.date(Y)."-".date(m)."-".date(d).'"';
                                $model=Customer::model()->find($criteria);
                                $return=$model->id_customer;
                            break;
        }
        return $return;
    }
	
	public function validatePassword($password)
	{
		return CPasswordHelper::verifyPassword($password,$this->password);
	}


	public function hashPassword($password)
	{
		return CPasswordHelper::hashPassword($password);
	}
	
	public function getCustomerName($id)
	{
		$name=Yii::app()->db->createCommand("select concat(firstname,' ',lastname) as customer from {{customer}} where id_customer=".$id)->queryScalar();
		return $name;
	}
}
