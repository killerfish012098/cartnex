<?php

class ProductGroup extends CActiveRecord
{
	public $lable;
	public function tableName()
	{
		return '{{product_group}}';
	}
	
	public function rules()
	{
		return array(
			array('id_product_group', 'numerical', 'integerOnly'=>true),
			array('display_in_listing,date_created, date_modified', 'safe'),
			array('set_title', 'length', 'max'=>100),
			array('id_product_group,lable,date_created, date_modified', 'safe', 'on'=>'search'),
			array('date_created','default','value'=>new CDbExpression('NOW()'),'setOnEmpty'=>true,'on'=>'insert'),
            array('date_modified','default','value'=>new CDbExpression('NOW()'),'setOnEmpty'=>false,'on'=>'update'),
            array('date_created,date_modified','default','value'=>new CDbExpression('NOW()'),'setOnEmpty'=>false,'on'=>'insert'),
		);
	}


	public function attributeLabels()
	{
		return array(
		    'set_title' => yii::t('productgroups','entry_set_title'),
			'display_in_listing'=> 'Display in listing'
		);
	}

        public function search()
	{
            
		$criteria=new CDbCriteria;


				$criteria->compare('LOWER(md.lable)',strtolower($this->lable),true, 'AND', 'ILIKE'); 
                $criteria->select='t.*,md.lable,md.id_product_group';
                $criteria->join='JOIN {{product_group_description}} md on (t.id_product_group=md.id_product_group)';
                $criteria->compare('md.id_language',Yii::app()->session['language']);
                //$criteria->order='t.id_product_group desc';
                
				return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'pagination'=>array(
					'pageSize' =>Yii::app()->config->getData('CONFIG_WEBSITE_ITEMS_PER_PAGE_ADMIN'),
				),
				'sort' => array(
					'defaultOrder' => 't.id_product_group DESC',
				),
				));
               
	}
        
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
