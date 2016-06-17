<?php

class OrderProduct extends CActiveRecord
{
	
	public function tableName()
	{
		return '{{order_product}}';
	}
	
	public function rules()
	{
		
		return array(
			array('id_order, id_product, product_name, product_price, final_price, product_tax, product_quantity', 'required'),
			array('id_order, id_product, product_quantity', 'numerical', 'integerOnly'=>true),
			array('product_model', 'length', 'max'=>12),
			array('product_name', 'length', 'max'=>64),
			array('product_price, final_price', 'length', 'max'=>15),
			array('product_tax', 'length', 'max'=>7),
			array('id_order_product, id_order, id_product, product_model, product_name, product_price, final_price, product_tax, product_quantity', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array();
	}

	
	public function attributeLabels()
	{
		return array(
			'id_order_product' => 'Id Order Product',
			'id_order' => 'Id Order',
			'id_product' => 'Id Product',
			'product_model' => 'Product Model',
			'product_name' => 'Product Name',
			'product_price' => 'Product Price',
			'final_price' => 'Final Price',
			'product_tax' => 'Product Tax',
			'product_quantity' => 'Product Quantity',
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id_order_product',$this->id_order_product);
		$criteria->compare('id_order',$this->id_order);
		$criteria->compare('id_product',$this->id_product);
		$criteria->compare('product_model',$this->product_model,true);
		$criteria->compare('product_name',$this->product_name,true);
		$criteria->compare('product_price',$this->product_price,true);
		$criteria->compare('final_price',$this->final_price,true);
		$criteria->compare('product_tax',$this->product_tax,true);
		$criteria->compare('product_quantity',$this->product_quantity);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
                'pageSize' =>Yii::app()->config->getData('CONFIG_WEBSITE_ITEMS_PER_PAGE_ADMIN'),
            ),
			'sort' => array(
					'defaultOrder' => 'id_order_product DESC',
					),
		));
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function bestSellers()
	{


		$criteria=new CDbCriteria;
		$criteria->select='op.id_product,op.name, op.model, COUNT( op.id_order ) AS id_order, SUM( op.quantity ) AS quantity';
		$criteria->alias='op';
		$criteria->join="LEFT JOIN {{order}} o ON o.id_order = op.id_order";
		$criteria->condition='o.id_order_status >0';
	 
		$criteria->group='op.id_product';
			
		return new CActiveDataProvider($this, array( 'criteria'=>$criteria,
				'pagination'=>array('pageSize'=>'10',//Yii::app()->params['config_page_size'],
				),
                    			'sort' => array(
					'defaultOrder' => 'quantity DESC',
					),
		));	
	}
	    
        public function bestCategories()
        {
		
            $record = Yii::app()->db->createCommand()
                    ->select('sum(op.quantity) as quantity,count(op.id_order) as id_order,(select name from {{category_description}} cd,{{product_category}} pc where cd.id_category=pc.id_category and cd.id_language="'.Yii::app()->session['language'].'" and pc.id_product=op.id_product) as name')
                    ->from('{{order_product}} op')
					->leftjoin('{{order}} o','o.id_order=op.id_order')
					->where('o.id_order_status>0')
                    ->group('op.id_product');
                    
					
            $dataReader=$record->query();

            $count=$dataReader->rowCount;		           
             return new CSqlDataProvider($record, 
                     array( 
                    'totalItemCount' => $count,
                    'pagination'=>array(
                     'pageSize' =>'10',
					),
                         'sort' => array(
					'defaultOrder' => 'quantity DESC',
					),
                ));
         }
}
