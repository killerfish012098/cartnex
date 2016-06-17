<?php

class Attribute extends CActiveRecord
{
	public $name;
	public $sort_order;

        
	public function tableName()
	{
		return '{{attribute}}';
	}

	public function rules()
	{
		return array(
			array('id_attribute_group, sort_order', 'numerical', 'integerOnly'=>true),
			array('date_modified','default','value'=>new CDbExpression('NOW()'),'setOnEmpty'=>false),
			array('id_attribute_group,sort_order', 'safe'),
		);
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
	public function getAttributeValues()
	{
		$cache=Yii::app()->cache;
        $attributevalues=$cache->get('a_attributevalues_'.Yii::app()->session['language']);
        if($attributevalues===false)
        {
           $attributevalues=array();
			$criteria = new CDbCriteria;
			//foreach(AttributeGroupDescription::model()->lang()->findAll() as $group):
			foreach(AttributeGroupDescription::model()->lang()->findAll(array('select'=>'t.id_attribute_group,t.name,ag.filter','join'=>'inner join {{attribute_group}} ag on  ag.id_attribute_group=t.id_attribute_group')) as $group):
			$criteria->join="INNER JOIN {{attribute}} as at ON(t.id_attribute=at.id_attribute)";
			$criteria->condition='at.id_attribute_group='.$group['id_attribute_group'];
			$str="";
			if($group->filter==1)
			{
				$str=" (filter)";
			}
			foreach (AttributeDescription::model()->lang()->findAll($criteria) as $attribute):
				$attributevalues[$group['name'].$str][$attribute['id_attribute']]=$attribute['name'];
			endforeach;
		endforeach;
			
            $cache->set('a_attributevalues_'.Yii::app()->session['language'],$attributevalues , Yii::app()->config->getData('CONFIG_WEBSITE_CACHE_LIFE_TIME'), new CDbCacheDependency('SELECT concat(MAX(date_modified),"-",count(id_attribute)) as date_modified FROM {{attribute}}'));
        }
        return $attributevalues;
		/*
		$return=array();
		$criteria = new CDbCriteria;
		//foreach(AttributeGroupDescription::model()->lang()->findAll() as $group):
		foreach(AttributeGroupDescription::model()->lang()->findAll(array('select'=>'t.id_attribute_group,t.name,ag.filter','join'=>'inner join {{attribute_group}} ag on  ag.id_attribute_group=t.id_attribute_group')) as $group):
			$criteria->join="INNER JOIN {{attribute}} as at ON(t.id_attribute=at.id_attribute)";
			$criteria->condition='at.id_attribute_group='.$group['id_attribute_group'];
			$str="";
			if($group->filter==1)
			{
				$str=" (filter)";
			}
			foreach (AttributeDescription::model()->lang()->findAll($criteria) as $attribute):
				$return[$group['name'].$str][$attribute['id_attribute']]=$attribute['name'];
			endforeach;
		endforeach;
		return $return;*/
	}
        
}
