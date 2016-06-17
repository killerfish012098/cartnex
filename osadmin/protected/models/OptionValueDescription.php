<?php

class OptionValueDescription extends CActiveRecord
{
    public function tableName()
	{
		return '{{option_value_description}}';
	}

	public function rules()
	{
		return array(
                        array('name','required'),
			array('id_option, id_language', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>128),
		);
	}

	public function relations()
	{
		return array(
            'optionvalue'=>array(self::BELONGS_TO,'OptionValue','id_option_value'),
        );
	}
        
    public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
    public function scopes(){
        return array(
            'lang'=>array('condition'=>$this->getTableAlias(false, false).'.id_language='.Yii::app()->session['language']),
            );
    }
        
    public function getOptionValues($id)
    {
        return OptionValueDescription::model()->lang()->findAll('id_option='.$id);
    }
}
