<?php

class CategoryComponentClass {

    private $id_language;
	private $db;
	public function init()
	{
		$languages=Yii::app()->config->getData('languages');
		$this->id_language=$languages[Yii::app()->session['language']]['id_language'];
		$this->db = Yii::app()->db;
	}
	
	public function getCategory($data)
	{
		$command = $this->db->createCommand("SELECT c.id_category,c.image,cd.name,cd.meta_title,cd.meta_keyword,cd.meta_description,cd.description FROM {{category_description}} cd, {{category}} c WHERE cd.id_category=c.id_category and c.id_category='".$data['id_category']."' and c.status='1' and cd.id_language='".$this->id_language."'");
		return $command->queryRow();
	}

	public function getChildCategories($parentId=0)
	{
		
		$command = $this->db->createCommand("SELECT c.id_category,cd.name,cd.description,c.image FROM {{category_description}} cd , {{category}} c WHERE c.id_category=cd.id_category and cd.id_language='".$this->id_language."' and c.id_parent='".$parentId."' and c.status=1 order by c.sort_order,lower(cd.name)");
		return $command->queryAll();
	}

	public function getCategoryByProduct($productId)
	{
		$category=$this->db->createCommand("select id_category from {{product_category}} where id_product='".$productId."'")->queryRow();
		return $category['id_category'];
	}


	public function getCategoryTree($id_parent = '0', $category_tree_array = '') 
	{
		$category=$this->db->createCommand("select c.id_parent,c.id_category,cd.name from {{category_description}} cd,{{category}} c where c.id_category=cd.id_category and cd.id_language='".$this->id_language."' and c.id_category='".$id_parent."' order by c.sort_order,cd.name")->queryRow();
		if($category)
		{
				$category_tree_array[$category['id_category']]=$spacing . $category['name'];
				$category_tree_array = $this->getCategoryTree($category['id_parent'],$category_tree_array);
		}
		return $category_tree_array;
	}
}