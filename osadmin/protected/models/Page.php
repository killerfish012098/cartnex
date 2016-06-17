<?php

class Page extends CActiveRecord
{
    public $title; 
	public function tableName()
	{
		return '{{page}}';
	}
	public function rules()
	{
		return array(
			array('status, sort_order', 'numerical', 'integerOnly'=>true),
			array('status','default','value'=>1,'setOnEmpty'=>true,'on'=>'insert'),
			array('date_created','default','value'=>new CDbExpression('NOW()'),'setOnEmpty'=>true,'on'=>'insert'),
            array('date_modified','default','value'=>new CDbExpression('NOW()'),'setOnEmpty'=>false,'on'=>'update'),
            array('date_created,date_modified','default','value'=>new CDbExpression('NOW()'),'setOnEmpty'=>false,'on'=>'insert'),
			array('id_page, title,status, sort_order, date_created, date_modified', 'safe', 'on'=>'search'),
		);
	}
        

    public function relations()
	{
		return array(
            'pageDescription'=>array(self::BELONGS_TO,'PageDescription','id_page'),
		);
	}

        public function attributeLabels()
	{
		return array(
			'sort_order' => Yii::t('pages','entry_sort_order'),
			'status' => Yii::t('pages','entry_status'),
		);
	}
	
	public function search()
	{
			$criteria=new CDbCriteria;
			$criteria->compare('id_page',$this->id_page,true);
			$criteria->compare('status',$this->status,true);
			$criteria->compare('sort_order',$this->sort_order,true);
			$criteria->compare('LOWER(pd.title)',strtolower($this->title),true, 'AND', 'ILIKE'); 
            $criteria->select='t.*,pd.title';
            $criteria->join='JOIN {{page_description}} pd on (t.id_page=pd.id_page)';
            $criteria->compare('pd.id_language',Yii::app()->session['language']);
           
 		
			return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'pagination'=>array(
					'pageSize' =>Yii::app()->config->getData('CONFIG_WEBSITE_ITEMS_PER_PAGE_ADMIN'),
				),
				'sort' => array(
                'defaultOrder' => 'id_page DESC',
				),
			));
	}
	
   

        public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getPages()
	{
		//return Page::model()->findAll(array('condition'=>'status=:x', 'params'=>array(':x'=>1)));
		//return Yii::app()->db->createCommand("select pd.title from {{page}} p and {{page_description}} pd where p.id_page=pd.id_page and p.status=1")->queryAll();

		$criteria = new CDbCriteria;
        $criteria->select = "pd.title,t.id_page";
        $criteria->join = "INNER JOIN {{page_description}} pd ON(pd.id_page=t.id_page)";
        $criteria->condition = 'pd.id_language="' . Yii::app()->session['language'] . '" and t.status=1';
        return Page::model()->findAll($criteria);
	}
}
