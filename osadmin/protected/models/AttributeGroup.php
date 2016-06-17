<?php

class AttributeGroup extends CActiveRecord
{       
    public $name;
	public function tableName()
	{
		return '{{attribute_group}}';
	}

	public function rules()
	{
		return array(
			array('sort_order,filter', 'numerical', 'integerOnly'=>true),
			array('id_attribute_group, ,name,sort_order', 'safe', 'on'=>'search'),
		);
	}
	public function relations()
	{
		return array(
                    'attributegroupdescription'=>array(self::HAS_ONE,'AttributeGroupDescription','id_attribute_group'),
                    'attribute'=>array(self::HAS_MANY,'Attribute','id_attribute_group'),
                    'attributedescription'=>array(self::HAS_MANY,'AttributeDescription','id_attribute_group'),
		);
	}

	public function attributeLabels()
	{
		return array(
		     'sort_order' => Yii::t('attributes','entry_sort_order'),
		);
	}

        public function search()
	{
		$criteria=new CDbCriteria;
				$criteria->compare('name',$this->name,true);
                $criteria->select='od.name,t.*';
                $criteria->join='JOIN {{attribute_group_description}} od on (t.id_attribute_group=od.id_attribute_group)';
                $criteria->compare('od.id_language',Yii::app()->session['language']);
                
                return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
      		'pagination'=>array(
                'pageSize' =>Yii::app()->config->getData('CONFIG_WEBSITE_ITEMS_PER_PAGE_ADMIN'),
                ),
                'sort'=>array(
                        'defaultOrder'=>'id_attribute_group DESC',
                    ),

                    ));
	}
	
	public function getFilterAttributes()
        {
            $criteria = new CDbCriteria;
            $criteria->select="t.*,ad.*";
            $criteria->join="INNER JOIN {{attribute_group_description}} as ad ON(ad.id_attribute_group=t.id_attribute_group)";
            $criteria->condition='ad.id_language="'.Yii::app()->session['language'].'" and t.filter=1';
            $model=  AttributeGroup::model()->findAll($criteria);
            return $model;
        }

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}