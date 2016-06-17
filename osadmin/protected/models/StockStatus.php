<?php
class StockStatus extends CActiveRecord
{
        public $name;
        public function tableName()
	{
		return '{{stock_status}}';
	}

	public function rules()
	{
		return array(
            array('name','required'),
			array('id_language', 'numerical', 'integerOnly'=>true),
			array('date_modified','default','value'=>new CDbExpression('NOW()'),'setOnEmpty'=>false),
			array('name', 'length', 'max'=>32),
			array('id_stock_status, id_language, name', 'safe', 'on'=>'search'),
		);
	}


	public function attributeLabels()
	{
		return array(
			'name' => Library::flag().Yii::t('stockstatus','entry_name'),
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;
		$criteria->compare('id_language',Yii::app()->session['language']);
		$criteria->compare('LOWER(name)',strtolower($this->name),true, 'AND', 'ILIKE'); 
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize' =>Yii::app()->config->getData('CONFIG_WEBSITE_ITEMS_PER_PAGE_ADMIN'),
            ),
			'sort' => array(
                'defaultOrder' => 'id_stock_status DESC',
			),
		));
	}
 
    public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getStockStatus()
    {
        /*$criteria = new CDbCriteria;
        $criteria->condition='t.id_language="'.Yii::app()->session['language'].'"';
        $model= StockStatus::model()->findAll($criteria);
        return $model;
		*/
		$cache=Yii::app()->cache;
        $stockstatuses=$cache->get('a_stockstatuses_'.Yii::app()->session['language']);
        if($stockstatuses===false)
        {
			$criteria = new CDbCriteria;
			$criteria->condition='t.id_language="'.Yii::app()->session['language'].'"';
            $stockstatuses=StockStatus::model()->findAll($criteria);
            $cache->set('a_stockstatuses_'.Yii::app()->session['language'],$stockstatuses , Yii::app()->config->getData('CONFIG_WEBSITE_CACHE_LIFE_TIME'), new CDbCacheDependency('SELECT concat(MAX(date_modified),"-",count(id_stock_status)) as date_modified FROM {{stock_status}}'));
        }
        return $stockstatuses;	
    }

	public function scopes(){
        return array(
        'lang'=>array('condition'=>'t.id_language='.Yii::app()->session['language']),
		);
    }
}
