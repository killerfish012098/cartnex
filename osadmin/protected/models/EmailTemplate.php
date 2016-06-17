<?php

class EmailTemplate extends CActiveRecord
{
	public $title;
	public function tableName()
	{
		return '{{email_template}}';
	}

	public function rules()
	{

		return array(
			array('keywords', 'length', 'max'=>255),
			array('html', 'safe'),
			array('date_modified','default','value'=>new CDbExpression('NOW()'),'setOnEmpty'=>false),
			array('title,id_email_template, html, keywords', 'safe', 'on'=>'search'),
		);
	}


	public function relations()
	{
		return array(	);
	}


	public function attributeLabels()
	{
		return array(
			'html' => Yii::t('emailtemplates','entry_html'),
			'keywords' => Yii::t('emailtemplates','entry_keywords'),
		);
	}


	    public function search()
	{
			$criteria=new CDbCriteria;
			$criteria->compare('ed.title',$this->title,true);
            $criteria->select='t.*,ed.title';
            $criteria->join='JOIN {{email_template_description}} ed on (t.id_email_template=ed.id_email_template)';
            $criteria->compare('ed.id_language',Yii::app()->session['language']);
            //$criteria->order='t.id_email_template desc';
			return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
					'pagination'=>array(
                        'pageSize' =>Yii::app()->config->getData('CONFIG_WEBSITE_ITEMS_PER_PAGE_ADMIN'),
					),
					'sort' => array(
					'defaultOrder' => 'id_email_template DESC',
					),
			));
	}
	
    

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getEmailTemplates()
    {
		$cache=Yii::app()->cache;
        $emailtemplates=$cache->get('a_emailtemplates_'.Yii::app()->session['language']);
        if($emailtemplates===false)
        {
			$criteria = new CDbCriteria;
			$criteria->select="t.*,td.*";
			$criteria->join="INNER JOIN {{email_template_description}} as td ON(td.id_email_template=t.id_email_template)";
			$criteria->condition='td.id_language="'.Yii::app()->session['language'].'"';
			$emailtemplates= EmailTemplate::model()->findAll($criteria);
            $cache->set('a_emailtemplates_'.Yii::app()->session['language'], $emailtemplates , Yii::app()->config->getData('CONFIG_WEBSITE_CACHE_LIFE_TIME'), new CDbCacheDependency('SELECT concat(MAX(date_modified),"-",count(id_email_template)) as date_modified FROM {{email_template}}'));
        }
        return $emailtemplates;
    }
}
