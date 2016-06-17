<?php

class CustomUrl extends CActiveRecord
{
	public function tableName()
	{
		return '{{custom_url}}';
	}
	
	public function attributeLabels()
	{
		return array(
			'string' => Yii::t('products','entry_string'),
		);
	}

 	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getCustomUrl($input)
	{
		$CustomUrl=new CustomUrl();
		$model=$CustomUrl->find(array('condition'=>'type="'.$input['type'].'" and id="'.$input['id'].'"'));
		if(empty($model->string))
		{
			$return=$CustomUrl;
		}else
		{
			$return=$model;
		}
        return $return;
    }

	public function deleteCustomUrl($input)
	{
		$criteria = new CDbCriteria;
		$criteria->addCondition('type="'.$input['type'].'"','and');
        $criteria->addInCondition('id', $input['id']);
		CustomUrl::model()->deleteAll($criteria);
	}
	
	public function setCustomUrl($input)
	{
		$return=0; 
		if($input['string']!=="" || $input['alt']!="")
		{
                    $text=$input['string']!==""?$input['string']:$input['alt'];
                    $fltStr=preg_replace('/[^a-zA-Z0-9&-]/', '-', strtolower(trim($text)));

                    $model=new CustomUrl();
                    $model->deleteAll(array('condition'=>'type="'.$input['type'].'" and id="'.$input['id'].'"'));
                    $count=$model->count(array('condition'=>'lower(string)="'.$fltStr.'"'));

                    $string=$count==0?$fltStr:$fltStr."_".$input['type']."_".$input['id'];	
                    //echo "value of ".$string;
                    //exit;
                    $model->type=$input['type'];
                    $model->string=strtolower($string);
                    $model->id=$input['id'];
                    $model->save(true);
                    $return=1;
		
		}
		return $return;
		
	}
}
