<?php

class OptionDescription extends CActiveRecord
{
        public $type;
        public $sort_order;
        public function tableName()
	{
		return '{{option_description}}';
	}

	public function rules()
	{
		return array(
			array('name', 'required'),
			array('id_option, id_language', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>128),
		);
	}

	public function relations()
	{
		return array(
            'option'=>array(self::HAS_ONE,'Option','id_option'),
		);
	}

	public function attributeLabels()
	{
		return array(	
		'name' => Library::flag().Yii::t('options','entry_name'),
		);
	}

    public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        
        public function scopes(){
           return array(
               'lang'=>array('condition'=>'t.id_language='.Yii::app()->session['language']),
                );
        }
        
        public function getOptions()
        {
            $rows=OptionDescription::model()->with(array(
                                                                    'option' => array(
                                                                    'joinType' => 'INNER JOIN',
                                                                                      ),
                                                                        )
                                                                )->lang()->findAll();
            $option=array();
            foreach($rows as $row)
            {
                $option[$row->id_option]=array('name'=>$row->name,'type'=>$row->option->type,'sort_order'=>$row->option->sort_order,);
            }
            return $option;
        }
}
