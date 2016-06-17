<?php
class OrderTotal extends CActiveRecord
{
	public function tableName()
	{
		return '{{order_total}}';
	}

	public function rules()
	{
		
		return array(
			array('id_order, title, text, value, class, sort_order', 'required'),
			array('id_order, sort_order', 'numerical', 'integerOnly'=>true),
			array('title, text', 'length', 'max'=>255),
			array('value', 'length', 'max'=>15),
			array('class', 'length', 'max'=>32),
			array('id_order_total, id_order, title, text, value, class, sort_order', 'safe', 'on'=>'search'),
		);
	}


	public function attributeLabels()
	{
		return array(
			'id_order_total' => 'Id Order Total',
			'id_order' => 'Id Order',
			'title' => 'Title',
			'text' => 'Text',
			'value' => 'Value',
			'class' => 'Class',
			'sort_order' => 'Sort Order',
		);
	}

	
	public function search()
	{
		
		$criteria=new CDbCriteria;

		$criteria->compare('id_order_total',$this->id_order_total,true);
		$criteria->compare('id_order',$this->id_order);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('value',$this->value,true);
		$criteria->compare('class',$this->class,true);
		$criteria->compare('sort_order',$this->sort_order);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize' =>Yii::app()->config->getData('CONFIG_WEBSITE_ITEMS_PER_PAGE_ADMIN'),
            ),
		));
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getOrderTotal($condition)
	{
	 	return OrderTotal::model()->findAll($condition);
	}
}
