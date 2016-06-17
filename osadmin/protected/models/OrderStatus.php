<?php

class OrderStatus extends CActiveRecord
{

    public function tableName()
	{
		return '{{order_status}}';
	}

	public function rules()
	{
		return array(
			array('name,color','required'),
			array('id_email_template', 'numerical', 'integerOnly'=>true),
			array('name, color', 'length', 'max'=>32),
			array('id_order_status, name, color, id_email_template', 'safe', 'on'=>'search'),
		);
	}


	public function attributeLabels()
	{
		return array(
			'name' => Library::flag().Yii::t('orderstatus','entry_name'),
			'color' => Yii::t('orderstatus','entry_color'),
			'id_email_template' => Yii::t('orderstatus','entry_email_template'),
		);
	}

	public function search()
	{
	
		$criteria=new CDbCriteria;
		$criteria->compare('id_language',Yii::app()->session['language']);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('color',$this->color,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize' =>Yii::app()->config->getData('CONFIG_WEBSITE_ITEMS_PER_PAGE_ADMIN'),
            ),
			'sort' => array(
                'defaultOrder' => 'id_order_status DESC',
			),
		));
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function scopes()
	{
	   return array(
		   'lang'=>array('condition'=>$this->getTableAlias(false, false).'.id_language='.Yii::app()->session['language']),
		   );
	}

	public function getOrderStatuses()
	{
		return OrderStatus::model()->lang()->findAll();
	}
}
