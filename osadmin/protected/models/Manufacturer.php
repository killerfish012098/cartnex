<?php

class Manufacturer extends CActiveRecord
{
    public $name; 
	public $total;
	public function tableName()
	{
		return '{{manufacturer}}';
	}

	public function rules()
        {
            return array(
            array('sort_order, status', 'numerical', 'integerOnly'=>true),
            array('image', 'length', 'max'=>100),
			array('status','default','value'=>1,'setOnEmpty'=>true,'on'=>'insert'),
			array('date_created','default','value'=>new CDbExpression('NOW()'),'setOnEmpty'=>true,'on'=>'insert'),
            array('date_modified','default','value'=>new CDbExpression('NOW()'),'setOnEmpty'=>false,'on'=>'update'),
            array('date_created,date_modified','default','value'=>new CDbExpression('NOW()'),'setOnEmpty'=>false,'on'=>'insert'),
            array('id_manufacturer, sort_order, ,name,status, image', 'safe', 'on'=>'search'),
		
            );
        }
        

	public function relations()
	{
		return array(
                    'manufacturerDescription'=>array(self::BELONGS_TO,'ManufacturerDescription','id_manufacturer'),
		);
	}

	public function attributeLabels()
	{
			return array(
			'sort_order' => Yii::t('manufacturers','entry_sort_order'),
			'status' => Yii::t('manufacturers','entry_status'),
			'image' => Yii::t('manufacturers','entry_image'),
		);
	}

	public function search()
	{
			$criteria=new CDbCriteria;
			$criteria->compare('status',$this->status,true);
			$criteria->compare('sort_order',$this->sort_order,true);
			$criteria->compare('LOWER(md.name)',strtolower($this->name),true, 'AND', 'ILIKE'); 
            $criteria->select='t.*,md.name';
            $criteria->join='JOIN {{manufacturer_description}} md on (t.id_manufacturer=md.id_manufacturer)';
            $criteria->compare('md.id_language',Yii::app()->session['language']);
            //$criteria->order='t.id_manufacturer desc';
 		
			return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
					'pagination'=>array(
                        'pageSize' =>Yii::app()->config->getData('CONFIG_WEBSITE_ITEMS_PER_PAGE_ADMIN'),
					),
					'sort' => array(
					'defaultOrder' => 'id_manufacturer DESC',
					),
			));
	}
        
        

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function bestManufacturers()
    {
        $criteria=Yii::app()->db->createCommand('SELECT count( p.id_product ) AS total, m.name, m.id_manufacturer FROM {{manufacturer_description}} m LEFT JOIN {{product}} p ON m.id_manufacturer = p.id_manufacturer AND m.id_language=1 GROUP BY m.name ORDER BY total DESC  limit 5');
        
		return new CSqlDataProvider($criteria);
    }
	
	

	public function productsByManufacturers()
	{

			$criteria=new CDbCriteria;
			$criteria->select='count( p.id_product ) AS total, md.name, m.id_manufacturer';
			$criteria->alias='m';
			$criteria->join="INNER JOIN {{manufacturer_description}} md ON (md.id_manufacturer=m.id_manufacturer) LEFT JOIN {{product}} p ON (p.id_manufacturer=m.id_manufacturer)";
			$criteria->condition='md.id_language="'.Yii::app()->session['language'].'"';
			$criteria->group='md.name';
			$criteria->order='total DESC,m.status DESC';
				
			return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
                    'pageSize' =>Yii::app()->config->getData('CONFIG_WEBSITE_ITEMS_PER_PAGE_ADMIN'),
            ),
		));
	}
	
	public function getManufacturers()
    {
		$cache=Yii::app()->cache;
        $manufacturers=$cache->get('a_manufacturers_'.Yii::app()->session['language']);
        if($manufacturers===false)
        {
		    $criteria = new CDbCriteria;
			$criteria->select="t.*,md.*";
			$criteria->join="INNER JOIN {{manufacturer_description}} as md ON(md.id_manufacturer=t.id_manufacturer)";
			$criteria->condition='md.id_language="'.Yii::app()->session['language'].'"';
				
            $manufacturers=Manufacturer::model()->findAll($criteria);;
            $cache->set('a_manufacturers_'.Yii::app()->session['language'],$manufacturers , Yii::app()->config->getData('CONFIG_WEBSITE_CACHE_LIFE_TIME'), new CDbCacheDependency('SELECT concat(MAX(date_modified),"-",count(id_manufacturer)) as date_modified FROM {{manufacturer}}'));
        }
        return $manufacturers;
    }
	
	public function getMaxId()
		{
			$record = Yii::app()->db->createCommand("SELECT MAX( id_manufacturer ) FROM `{{manufacturer}}` ")->queryScalar();
			return $record;
		}
}
