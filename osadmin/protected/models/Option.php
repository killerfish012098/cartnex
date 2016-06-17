<?php
class Option extends CActiveRecord
{
        public $name;
        public function tableName()
	{
		return '{{option}}';
	}

	public function rules()
	{
		return array(
            array('type','required'),
			array('sort_order', 'numerical', 'integerOnly'=>true),
			array('date_modified','default','value'=>new CDbExpression('NOW()'),'setOnEmpty'=>false),
			array('name', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
                    'optiondescription'=>array(self::HAS_ONE,'OptionDescription','id_option'),
                    'optionvalue'=>array(self::HAS_MANY,'OptionValue','id_option'),
                    'optionvaluedescription'=>array(self::HAS_MANY,'OptionValueDescription','id_option'),
                );
	}

	public function attributeLabels()
	{
		return array(
			'type' => Yii::t('options','entry_type'),
			'sort_order' => Yii::t('options','entry_sort_order'),
			'status' => Yii::t('options','entry_status'),
			'image' => Yii::t('options','entry_image'),
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;
				$criteria->compare('name',$this->name);
                $criteria->select='od.name,t.*';
                $criteria->join='JOIN {{option_description}} od on (t.id_option=od.id_option)';
                $criteria->compare('od.id_language',Yii::app()->session['language']);
                //$criteria->order='t.id_option desc';
 		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
      			'pagination'=>array(
                        'pageSize' =>Yii::app()->config->getData('CONFIG_WEBSITE_ITEMS_PER_PAGE_ADMIN'),
                ),
				'sort' => array(
					'defaultOrder' => 'id_option DESC',
					),

                    ));
	}
 
    public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	

	public function getFilterOptions()
    {
		$cache=Yii::app()->cache;
        $filteroptions=$cache->get('a_filteroptions_'.Yii::app()->session['language']);
        if($filteroptions===false)
        {
		    $criteria = new CDbCriteria;
			$criteria->select="t.*,od.*";
			$criteria->join="INNER JOIN {{option_description}} as od ON(od.id_option=t.id_option)";
			$criteria->condition='t.type in ("select","radio","checkbox") and  od.id_language="'.Yii::app()->session['language'].'"';
				
            $filteroptions=Option::model()->findAll($criteria);;
            $cache->set('a_filteroptions_'.Yii::app()->session['language'],$filteroptions , Yii::app()->config->getData('CONFIG_WEBSITE_CACHE_LIFE_TIME'), new CDbCacheDependency('SELECT concat(MAX(date_modified),"-",count(id_option)) as date_modified FROM {{option}}'));
        }
        return $filteroptions;
    }
	
}
