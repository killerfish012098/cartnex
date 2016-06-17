<?php

class Language extends CActiveRecord
{
	public function tableName()
	{
		return '{{language}}';
	}

	public function rules()
	{
		return array(
            array('name,code,status','required'),
			array('date_modified','default','value'=>new CDbExpression('NOW()'),'setOnEmpty'=>false),
			array('sort_order, status', 'numerical', 'integerOnly'=>true),
       );
	}

  
	public function search()
	{
		$criteria=new CDbCriteria;
        $criteria->compare('id_manufacturer',$this->id_manufacturer);
		$criteria->compare('sort_order',$this->sort_order);
		$criteria->compare('status',$this->status);
		$criteria->compare('image',$this->image,true);
                $criteria->select='t.*,md.name';
                $criteria->join='JOIN {{manufacturer_description}} md on (t.id_manufacturer=md.id_manufacturer)';
                $criteria->condition='md.id_language=1';
                
 		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
      			'pagination'=>array(
                        'pageSize' =>Yii::app()->config->getData('CONFIG_WEBSITE_ITEMS_PER_PAGE_ADMIN'),
                ),
				'sort' => array(
					'defaultOrder' => 'id_language DESC',
					),

		));
	}
        
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
    public static function getLanguages(){
		//Yii::app()->config->getData('CONFIG_WEBSITE_CACHE_LIFE_TIME');
		//exit;
		$cache=Yii::app()->cache;
        $languages=$cache->get('a_languages');
        if($languages===false)
        {
            $languages=Language::model()->findAll();
            $cache->set('a_languages',$languages ,0, new CDbCacheDependency('SELECT concat(MAX(date_modified),"-",count(id_language)) as date_modified FROM {{language}}'));
        }
        return $languages;
    }
}
