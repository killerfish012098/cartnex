<?php
class Currency extends CActiveRecord
{
	public function tableName()
	{
		return '{{currency}}';
	}

	public function rules()
	{
		return array(
            array('name,value,code','required'),
			array('decimals, status', 'numerical', 'integerOnly'=>true),
			array('name, value,position', 'length', 'max'=>32),
			array('code, symbol,thousand_separator, decimal_separator', 'length', 'max'=>3),
 			array('status','default','value'=>1,'setOnEmpty'=>true,'on'=>'insert'),
			array('date_modified','default','value'=>new CDbExpression('NOW()'),'setOnEmpty'=>false,'on'=>'update'),
			array('date_modified','default','value'=>new CDbExpression('NOW()'),'setOnEmpty'=>false,'on'=>'insert'),
			array('id_currency, name, value, code, symbol,position, decimal_separator,thousand_separator,, decimals, date_modified, status', 'safe', 'on'=>'search'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'name' => Yii::t('currencies','entry_name'),
			'value' => Yii::t('currencies','entry_value'),
			'code' => Yii::t('currencies','entry_code'),
			'symbol' => Yii::t('currencies','entry_symbol'),
			'position' => Yii::t('currencies','entry_position'),
			'decimal_separator' => Yii::t('currencies','entry_decimal_separator'),
			'thousand_separator' => Yii::t('currencies','entry_thousand_separator'),
			'decimals' => Yii::t('currencies','entry_decimal_place'),
			'status' => Yii::t('currencies','entry_status'),
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;
		$criteria->compare('id_currency',$this->id_currency);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('value',$this->value,true);
		$criteria->compare('code',$this->code,true);
		$criteria->compare('decimals',$this->decimals);
		$criteria->compare('date_modified',$this->date_modified,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
                        'pageSize' =>Yii::app()->config->getData('CONFIG_WEBSITE_ITEMS_PER_PAGE_ADMIN'),
                ),
				'sort' => array(
					'defaultOrder' => 'id_currency DESC',
					),
		));
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
