<?php

class EmailTemplateDescription extends CActiveRecord
{
	public function tableName()
	{
		return '{{email_template_description}}';
	}

	public function rules()
	{
		return array(
			array('title,subject,description','required'),
			array('id_email_template, id_language', 'numerical', 'integerOnly'=>true),
			array('title, subject', 'length', 'max'=>255),
			array('description', 'safe'),
			array('id_email_template, title, subject, description, id_language', 'safe', 'on'=>'search'),
		);
	}


	public function attributeLabels()
	{
		return array(

			'title' => Library::flag().Yii::t('emailtemplates','entry_title'),
			'subject' => Library::flag().Yii::t('emailtemplates','entry_subject'),
			'description' => Library::flag().Yii::t('emailtemplates','entry_description'),
		);
	}


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function scopes()
	{
	   return array(
		   'lang'=>array('condition'=>$this->getTableAlias(false, false).'.id_language='.Yii::app()->session['language']),
		   );
	}
}
