<?php

class Banner extends CActiveRecord
{
	public function tableName()
	{
		return '{{banner}}';
	}

	public function rules()
	{
		return array(
			array('name', 'required'),
			array('status','default','value'=>1,'setOnEmpty'=>true,'on'=>'insert'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>64),
			array('id_banner, name, status', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
                'bannerimage'=>array(self::HAS_MANY,'BannerImage','id_banner'),
                'bannerimagedescription'=>array(self::HAS_MANY,'BannerImageDescription','id_banner'),
		);
	}


	public function attributeLabels()
	{
		return array(
			'name' => Yii::t('banners','entry_name'),
			'status' =>Yii::t('banners','entry_status')
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;
		$criteria->compare('name',$this->name,true);
		$criteria->compare('status',$this->status);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
                'pageSize' =>Yii::app()->config->getData('CONFIG_WEBSITE_ITEMS_PER_PAGE_ADMIN'),
            ),
			'sort' => array(
                'defaultOrder' => 'id_banner DESC',
			),
		));
	}
	
	public function getBanners()
    {
        return Banner::model()->findAll();
    }

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
