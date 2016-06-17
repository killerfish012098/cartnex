<?php

class CustomerGroup extends CActiveRecord
{
	public $name;
	public function tableName()
	{
		return '{{customer_group}}';
	}

	public function rules()
	{
		return array(
			array('status,id_customer_group', 'safe'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'status' => Yii::t('customergroups','entry_status'),
		);
	}

	public function search()
	{

                $criteria=new CDbCriteria;
				$criteria->compare('LOWER(cd.name)',strtolower($this->name),true, 'AND', 'ILIKE'); 
                $criteria->select='cd.name,t.*';
                $criteria->join='JOIN {{customer_group_description}} cd on (t.id_customer_group=cd.id_customer_group)';
                $criteria->compare('cd.id_language',Yii::app()->session['language']);
                //$criteria->order='t.id_customer_group desc';
				
				return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
      			'pagination'=>array(
                        'pageSize' =>Yii::app()->config->getData('CONFIG_WEBSITE_ITEMS_PER_PAGE_ADMIN'),
					),
					'sort' => array(
					'defaultOrder' => 'id_customer_group DESC',
					),
                ));
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function getCustomerGroups()
	{
		return CustomerGroupDescription::model()->lang()->findAll();
	}
}