<?php

class ProductOption extends CActiveRecord
{
	public function tableName()
	{
		return '{{product_option}}';
	}

	public function rules()
	{
		return array(
			array('id_product, id_option', 'required'),
			array('id_product_option,id_product, id_option, required', 'numerical', 'integerOnly'=>true),
                        array('option_value','safe'),
		);
	}



	public function attributeLabels()
	{
		return array(
			'id_product_option' => 'Id Product Option',
			'id_product' => 'Id Product',
			'id_option' => 'Id Option',
			'option_value' => 'Option Value',
			'required' => 'Required',
		);
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function getProductOptionMultipleData($id)
        {
            //exit("value of ".$id);
            $criteria=new CDbCriteria;
            $criteria->select='t.*';
            $criteria->join='JOIN {{option}} o on (t.id_option=o.id_option)';
            $criteria->condition='t.id_product='.$id;
            
            $rows=ProductOption::model()->findAll($criteria);
            $productOption=array();
            foreach($rows as $row)
            {
                $productOption[$row->id_option]=array('id_product_option'=>$row->id_product_option,'option_value'=>$row->option_value,'required'=>$row->required,);
                foreach(ProductOptionValue::model()->findAll('id_product_option='.$row->id_product_option) as $valueRows)
                {
                    $productOption[$row->id_option]['productOptionValue'][]=array('id_product_option_value'=>$valueRows->id_product_option_value,
                        'id_option_value'=>$valueRows->id_option_value,'quantity'=>$valueRows->quantity,'subtract'=>$valueRows->subtract,'price'=>$valueRows->price,'price_prefix'=>$valueRows->price_prefix,
                        'weight'=>$valueRows->weight,'weight_prefix'=>$valueRows->weight_prefix,);
                }
            }

            return $productOption;
        }
}
