                                                                                           <?php

class Region extends CActiveRecord
{
        
	public function tableName()
	{
		return '{{region}}';
	}

	public function rules()
	{
		return array(
			array('name,description', 'required'),
			array('name', 'length', 'max'=>32),
			array('description', 'length', 'max'=>255),
			array('date_created','default','value'=>new CDbExpression('NOW()'),'setOnEmpty'=>true,'on'=>'insert'),
            array('date_modified','default','value'=>new CDbExpression('NOW()'),'setOnEmpty'=>false,'on'=>'update'),
            array('date_created,date_modified','default','value'=>new CDbExpression('NOW()'),'setOnEmpty'=>false,'on'=>'insert'),
			array('id_region, name, description, date_created, date_modified', 'safe', 'on'=>'search'),
		);
	}
        
        
    public function search()
	{
		$criteria=new CDbCriteria;
		$criteria->compare('name',$this->name,true);
		$criteria->compare('description',$this->description,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
                'pageSize' =>Yii::app()->config->getData('CONFIG_WEBSITE_ITEMS_PER_PAGE_ADMIN'),
            ),
			'sort' => array(
                'defaultOrder' => 'id_region DESC',
			),
		));
	}
        
	public function attributeLabels()
	{
		return array(
			'name' => Yii::t('regions','entry_name'),
			'description' => Yii::t('regions','entry_description'),
		);
	}
        

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
    public function getRegions()
    {
         $cache=Yii::app()->cache;
            $regions=$cache->get('a_regions');
            if($regions===false)
            {
                    $regions=Region::model()->findAll();
                    $cache->set('a_regions',$regions , Yii::app()->config->getData('CONFIG_WEBSITE_CACHE_LIFE_TIME'), new CDbCacheDependency('SELECT concat(MAX(date_modified),"-",count(id_region)) as date_modified FROM {{region}}'));
            }
        return $regions;
    }
        
}
