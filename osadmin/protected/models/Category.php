<?php

class Category extends CActiveRecord
{
        public $name;
        public $meta_title;
        public $meta_keyword;
        public $meta_description;
        public $description;
		public $products_by_categories_total;
	public function tableName()
	{
		return '{{category}}';
	}

    public function rules()
	{
		return array(
            array('id_parent, sort_order,top, status,column', 'numerical', 'integerOnly'=>true),
			array('image', 'length', 'max'=>64),
			array('filter', 'length', 'max'=>255),
			array('date_created, date_modified', 'safe'),
			array('status','default','value'=>1,'setOnEmpty'=>true,'on'=>'insert'),
			array('date_created','default','value'=>new CDbExpression('NOW()'),'setOnEmpty'=>true,'on'=>'insert'),
            array('date_modified','default','value'=>new CDbExpression('NOW()'),'setOnEmpty'=>false,'on'=>'update'),
            array('date_created,date_modified','default','value'=>new CDbExpression('NOW()'),'setOnEmpty'=>false,'on'=>'insert'),
			array('id_category, name, image, id_parent, top, column, sort_order, date_created, date_modified, filter, status, del', 'safe', 'on'=>'search'),
		);
	}


	public function attributeLabels()
	{
		return array(
			'status' => Yii::t('categories','entry_status'),
			'category_image' => Yii::t('categories','entry_image'),
			'id_parent' => Yii::t('categories','entry_parent'),
			'top' => Yii::t('categories','entry_top'),
			'column' => Yii::t('categories','entry_column'),
			'sort_order' => Yii::t('categories','entry_sort_order'),
			'filter' => Yii::t('categories','entry_filter'),
		);
	}

    public function search()
	{
	

		$criteria=new CDbCriteria;

				$criteria->compare('id_category',$this->id_category);
				$criteria->compare('id_parent',$this->id_parent);
				$criteria->compare('status',$this->status,true);
				$criteria->compare('name',$this->name,true);
                $criteria->select='t.*,md.name';
                $criteria->join='JOIN {{category_description}} md on (t.id_category=md.id_category)';
                $criteria->compare('md.id_language',Yii::app()->session['language']);
                $criteria->order='t.id_category desc';
 		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
      			'pagination'=>array(
                        'pageSize' =>Yii::app()->config->getData('CONFIG_WEBSITE_ITEMS_PER_PAGE_ADMIN'),
                ),
				'sort' => array(
                'defaultOrder' => 'id_category DESC',
				),

		));
	}
        
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        /*public function getCategoryTree($id_parent = '0', $spacing = '', $category_tree_array = '') 
		{
			$cache=Yii::app()->cache;
			$categorytree=$cache->get('a_categorytree_'.Yii::app()->language);
			if($categorytree===false)
			{
				$criteria = new CDbCriteria();
				$criteria->select = 't.id_parent,t.id_category,cd.name';
				$criteria->join='JOIN {{category_description}} cd on (t.id_category=cd.id_category)';
				$criteria->condition = 'id_language="'.Yii::app()->session['language'].'" and id_parent="'.$id_parent.'"';
				$criteria->order = 't.sort_order, cd.name';
				$categories = Category::model()->findAll($criteria);
				foreach($categories as $v)
				{
					$category_tree_array[$v['id_category']]=$spacing . $v['name'];
					$category_tree_array = $this->getCategoryTree($v['id_category'], $spacing . '&nbsp;&nbsp;&nbsp;', $category_tree_array);
				}
					   
				$cache->set('a_categorytree_'.Yii::app()->language,$category_tree_array , Yii::app()->config->getData('CONFIG_WEBSITE_CACHE_LIFE_TIME'), new CDbCacheDependency('SELECT concat(MAX(date_modified),"-",count(id_category)) as date_modified FROM {{category}}'));
			}
			return $category_tree_array;
		}*/

		public function getCategoryTree($id_parent = '0', $spacing = '', $category_tree_array = '') 
        {
            $criteria = new CDbCriteria();
            $criteria->select = 't.id_parent,t.id_category,cd.name';
            $criteria->join='JOIN {{category_description}} cd on (t.id_category=cd.id_category)';
            $criteria->condition = 'id_language="'.Yii::app()->session['language'].'" and id_parent="'.$id_parent.'"';
            $criteria->order = 't.sort_order, cd.name';
            $categories = Category::model()->findAll($criteria);
            foreach($categories as $v)
            {
                    $category_tree_array[$v['id_category']]=$spacing . $v['name'];
                    $category_tree_array = $this->getCategoryTree($v['id_category'], $spacing . '&nbsp;&nbsp;&nbsp;', $category_tree_array);
            }
            return $category_tree_array;
        }
        
        public function getCategories()
        {
			$cache=Yii::app()->cache;
            $categories=$cache->get('a_categories_'.Yii::app()->session['language']);
            if($categories===false)
            {
				    $criteria = new CDbCriteria;
					$criteria->select="t.*,cd.*";
					$criteria->join="INNER JOIN {{category_description}} as cd ON(cd.id_category=t.id_category)";
					$criteria->condition='cd.id_language="'.Yii::app()->session['language'].'"';
					
                    $categories=Category::model()->findAll($criteria);;
                    $cache->set('a_categories_'.Yii::app()->session['language'],$categories , Yii::app()->config->getData('CONFIG_WEBSITE_CACHE_LIFE_TIME'), new CDbCacheDependency('SELECT concat(MAX(date_modified),"-",count(id_category)) as date_modified FROM {{category}}'));
            }
        return $categories;
        }
		


		public function productsByCategories()
		{
			/*return Yii::app()->db->createCommand('SELECT count( p.id_product ) AS total, md.name, m.id_manufacturer FROM {{manufacturer}} m inner join {{manufacturer_description}} md on m.id_manufacturer=md.id_manufacturer and md.id_language="1" LEFT JOIN {{product}} p ON m.id_manufacturer = p.id_manufacturer GROUP BY md.name ORDER BY total DESC,m.status desc  limit 5');*/

				$criteria=new CDbCriteria;
				$criteria->select='count(pc.id_product) AS products_by_categories_total, cd.name, c.id_category';
				$criteria->alias='c';
				$criteria->join="INNER JOIN {{category_description}} cd ON (cd.id_category=c.id_category) LEFT JOIN {{product_category}} pc ON (pc.id_category=c.id_category)";
				//$criteria->join="LEFT JOIN {{product}} p ON (p.id_manufacturer=m.id_manufacturer)";
				$criteria->condition='cd.id_language="'.Yii::app()->session['language'].'"';
				$criteria->group='cd.name';
				$criteria->order='products_by_categories_total DESC,c.status DESC';
					
				return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'pagination'=>array(
				'pageSize'=>'10',//Yii::app()->params['config_page_size'],
				),
			));
		}

		public function getCategoryNames()
        {
            foreach($this->getCategories() as $category):
                $general[$category->id_category]=$category->name;
                $parent[$category->id_category]=$category->id_parent;
            endforeach;
            
            foreach($general as $gKey=>$gValue)
            {
                $data[$gKey]=substr($this->formatCategory($gKey,$general,$parent),2);
            }
            
            return $data;
        }
        
        public function formatCategory($gk,$general,$parent)
        {
            if ($gk==0 ) 
            { 
                return $general[$gk]; 
            } 
            else 
            {
				return ($this->formatCategory($parent[$gk],$general,$parent)."->".$general[$gk]); 
            }
        }
		public function getMaxId()
		{
			$record = Yii::app()->db->createCommand("SELECT MAX( id_Category ) FROM `{{category}}` ")->queryScalar();
			return $record;
		}
}