<?php

class Product extends CActiveRecord {

    public $name;
    public $meta_keywords;
    public $meta_description;
    public $description;
    public $download_label;
    public $stock_status;
    public $sold;
    public $percent;

    public function tableName() {
        return '{{product}}';
    }

    public function rules() {
        return array(
            array('quantity,model,price,date_product_available', 'required'),
            array('id_manufacturer,id_stock_status,id_tax_class,sort_order,minimum_quantity,subtract_stock,shipping_required,quantity,status,download_status,download_allowed_count,'
                . 'download_allowed_days', 'numerical', 'integerOnly' => true),
            array('price', 'numerical'),
            array('sku', 'unique', 'message' => 'sku should be unique!!'),
            array('image', 'length', 'max' => 100),
            array('shipping_required', 'default', 'value' => '1', 'setOnEmpty' => true),
            array('minimum_quantity', 'default', 'value' => '1', 'setOnEmpty' => true),
            array('date_product_available', 'default',
                'value' => new CDbExpression('NOW()'),
                'setOnEmpty' => true, 'on' => 'insert'),
            array('date_modified', 'default',
                'value' => new CDbExpression('NOW()'),
                'setOnEmpty' => false, 'on' => 'update'),
            array('date_created,date_modified', 'default',
                'value' => new CDbExpression('NOW()'),
                'setOnEmpty' => false, 'on' => 'insert'),
            array('quantity, status, model,price', 'safe', 'on' => 'search'),
            array('viewed,name,percent', 'safe', 'on' => 'productViewsReport'),
			array('weight,download_filename,download_mask,width,height,length,upc', 'safe')
        );
    }

    public function relations() {
        return array(
            'categories' => array(self::MANY_MANY, 'ProductCategory', '{{product_category}}(id_product,id_category)'),
        );
    }

    public function attributeLabels() {
        return array(
            'quantity' => Yii::t('products', 'entry_quantity'),
            'model' => Yii::t('products', 'entry_model'),
            'image' => Yii::t('products', 'entry_image'),
            'price' => Yii::t('products', 'entry_price'),
            'date_created' => Yii::t('products', 'entry_date_created'),
            'date_modified' => Yii::t('products', 'entry_date_modified'),
            'date_product_available' => Yii::t('products',
                    'entry_date_product_available'),
            'status' => Yii::t('products', 'entry_status'),
            'id_tax_class' => Yii::t('products', 'entry_id_tax_class'),
            'id_stock_status' => Yii::t('products', 'entry_id_stock_status'),
            'id_manufacturer' => Yii::t('products', 'entry_id_manufacturer'),
            'minimum_quantity' => Yii::t('products', 'entry_minimum_quantity'),
            'subtract_stock' => Yii::t('products', 'entry_subtract_stock'),
            'sku' => Yii::t('products', 'entry_sku'),
            'shipping_required' => Yii::t('products', 'entry_shipping_required'),
            'length' => Yii::t('products', 'entry_length'),
            'width' => Yii::t('products', 'entry_width'),
            'height' => Yii::t('products', 'entry_height'),
            'upc' => Yii::t('products', 'entry_upc'),
            'has_download' => Yii::t('products', 'entry_has_download'),
            'download_filename' => Yii::t('products', 'entry_download_filename'),
            'download_allowed_count' => Yii::t('products',
                    'entry_download_allowed_count'),
            'sort_order' => Yii::t('products', 'entry_sort_order'),
            'viewed' => Yii::t('products', 'entry_viewed'),
            'trash' => Yii::t('products', 'entry_trash'),
        );
    }

    public function search() {
        $criteria = new CDbCriteria;
        $criteria->compare('model', $this->model, true);
        //$criteria->compare('quantity', $this->quantity,false,'<');
        $symbol="";    
        $symbol=in_array(substr(trim($this->quantity),'0','1'),array("=",">","<"))?'':'=';
        //echo "value of ".$symbol;
        $this->quantity!=""?$criteria->addCondition('quantity'.$symbol.$this->quantity):'';
        $criteria->compare('price', $this->price, true);
        $criteria->compare('status', $this->status);
        $criteria->select = 't.*,pd.name';
        $criteria->join = 'JOIN {{product_description}} pd on (t.id_product=pd.id_product)';
       
        $criteria->compare('pd.id_language', Yii::app()->session['language']);

        return new CActiveDataProvider($this,
                array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->config->getData('CONFIG_WEBSITE_ITEMS_PER_PAGE_ADMIN'),
            ),
            'sort' => array(
                'defaultOrder' => 'id_product DESC',
            ),
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getProducts() {
        $criteria = new CDbCriteria;
        $criteria->select = "pd.name,pd.meta_keywords,pd.meta_description,pd.description,pd.download_label,t.*";
        $criteria->join = "INNER JOIN {{product_description}} as pd ON(pd.id_product=t.id_product)";
        $criteria->condition = 'pd.id_language="' . Yii::app()->session['language'] . '" and  t.status=1';
        $model = Product::model()->findAll($criteria);
        return $model;
    }

    public function getProductReports() {
        $criteria = new CDbCriteria;
        $criteria->select = "pd.name,t.*";
        $criteria->join = "INNER JOIN {{product_description}} as pd ON(pd.id_product=t.id_product)";
        $criteria->condition = 'pd.id_language="' . Yii::app()->session['language'] . '" and  t.status=1';
        $model = Product::model()->findAll($criteria);
        return $model;
    }

    public function productViewsReport() {
        $row = Yii::app()->db->createCommand('SELECT sum( viewed ) AS views FROM {{product}}')->queryRow();

        //exit;
        $criteria = new CDbCriteria;
        $criteria->select = 'pd.name,round((t.viewed/' . $row['views'] . ')*100,2) as percent,t.*,(select sum(quantity) from {{order_product}} rp where rp.id_product=t.id_product) '
                . 'as sold';
        $criteria->join = 'JOIN {{product_description}} pd on (t.id_product=pd.id_product)';
        $criteria->condition = 't.viewed!=0';

        $criteria->compare('pd.id_language', Yii::app()->session['language']);
        $criteria->addSearchCondition('pd.name', '%' . $this->name . '%', false);
        return new CActiveDataProvider($this,
                array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->config->getData('CONFIG_WEBSITE_ITEMS_PER_PAGE_ADMIN'),
            ),
			'sort' => array(
					'defaultOrder' => 'viewed DESC',
					),
        ));
    }

    public function bestSellingProducts() {
        $criteria = Yii::app()->db->createCommand('SELECT op.id_product, p.model, pd.name, sum(op.quantity) AS total FROM {{order_product}} op LEFT JOIN {{r_order}} o'
                . ' ON ( op.id_order = o.id_order ) LEFT JOIN {{product}} p ON ( op.id_product = p.id_product ) LEFT JOIN {{product_description}} pd ON '
                . '( op.id_product = pd.id_product ) WHERE pd.id_language = 1 AND o.id_order_status > 0 AND p.status = 1   AND p.date_product_available'
                . ' <=' . $date . '  GROUP BY op.id_product ORDER BY total DESC LIMIT 5');

        return new CSqlDataProvider($criteria);
    }

    public function getProductInfo($input) {
        $criteria = new CDbCriteria;

        switch ($input['data']) {
            case 'TotalProducts':
                $criteria->select = "count('*') as id_product";
                $criteria->alias = 'p';
                $criteria->join = 'INNER JOIN {{product_description}} pd ON (pd.id_product=p.id_product)';
                $criteria->condition = 'pd.id_language="' . Yii::app()->session['language'] . '"';
                $model = Product::model()->find($criteria);
                $return = $model->id_product;
                break;

            case 'InStock':
                $criteria->select = "count('*') as id_product";
                $criteria->alias = 'p';
                $criteria->join = 'INNER JOIN {{product_description}} pd ON (pd.id_product=p.id_product)';
                $criteria->condition = 'pd.id_language="' . Yii::app()->session['language'] . '" and p.quantity>0';
                $model = Product::model()->find($criteria);
                $return = $model->id_product;
                break;

            case 'OutOfStock':
                $criteria->select = "count('*') as id_product";
                $criteria->alias = 'p';
                $criteria->join = 'INNER JOIN {{product_description}} pd ON (pd.id_product=p.id_product)';
                $criteria->condition = 'pd.id_language="' . Yii::app()->session['language'] . '" and p.quantity<=0';
                $model = Product::model()->find($criteria);
                $return = $model->id_product;
                break;

            case 'ActiveProducts':
                $criteria->select = "count('*') as id_product";
                $criteria->alias = 'p';
                $criteria->join = 'INNER JOIN {{product_description}} pd ON (pd.id_product=p.id_product)';
                $criteria->condition = 'pd.id_language="' . Yii::app()->session['language'] . '" and p.status=1';
                $model = Product::model()->find($criteria);
                $return = $model->id_product;
                break;

            case 'InActiveProducts':
                $criteria->select = "count('*') as id_product";
                $criteria->alias = 'p';
                $criteria->join = 'INNER JOIN {{product_description}} pd ON (pd.id_product=p.id_product)';
                $criteria->condition = 'pd.id_language="' . Yii::app()->session['language'] . '" and p.status=0';
                $model = Product::model()->find($criteria);
                $return = $model->id_product;
                break;

            case 'StockOfProduct':
                $criteria->select = "p.quantity";
                $criteria->alias = 'p';
                $criteria->join = 'INNER JOIN {{product_description}} pd ON (pd.id_product=p.id_product)';
                $criteria->condition = 'pd.id_language="' . Yii::app()->session['language'] . '" and'
                        . ' p.id_product="' . $input['input']['id_product'] . '"';
                $model = Product::model()->find($criteria);
                $return = $model->quantity;
                break;
        }

        return $return;
    }

}
