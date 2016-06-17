<?php

class TaxClass extends CActiveRecord {

    public function tableName() {
        return '{{tax_class}}';
    }

    public function rules() {

        return array(
            array('name', 'length', 'max' => 32),
            array('status', 'numerical'),
            array('description', 'length', 'max' => 100),
			array('date_modified','default','value'=>new CDbExpression('NOW()'),'setOnEmpty'=>false),
			array('status','default','value'=>1,'setOnEmpty'=>true,'on'=>'insert'),
            array('id_tax_class, name, description', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'taxclassrule' => array(self::BELONGS_TO, 'TaxClassRule', 'id_tax_class'),
            'taxclassruledescription' => array(self::BELONGS_TO, 'TaxClassRuleDescription','id_tax_class'),
        );
    }

    public function attributeLabels() {
        return array(
            'name' => Yii::t('taxclasses', 'entry_name'),
            'description' => Yii::t('taxclasses', 'entry_description'),
        );
    }

    public function search() {
        $criteria = new CDbCriteria;
        $criteria->compare('name', $this->name, true);
        $criteria->compare('description', $this->description, true);
        $criteria->select = 't.id_tax_class,t.name,t.description';
        //$criteria->order = 't.id_tax_class desc';
        return new CActiveDataProvider($this,array(
            'criteria' => $criteria,
            'pagination'=>array(
                'pageSize' =>Yii::app()->config->getData('CONFIG_WEBSITE_ITEMS_PER_PAGE_ADMIN'),
            ),
			'sort' => array(
                'defaultOrder' => 'id_tax_class DESC',
			),
        ));
    }

    public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getTaxClasses($criteria)
    {
		$taxclasses=TaxClass::model()->findAll($criteria);;
        return $taxclasses;
    }
	

}
