<?php

class BrandClass {
    private $id_language;
	private $db;
	public function init()
	{
		$languages=Yii::app()->config->getData('languages');
		$this->id_language=$languages[Yii::app()->session['language']]['id_language'];
		$this->db = Yii::app()->db;
	}

	public function getBrand($id)
	{
		$brand=$this->db->createCommand('select md.id_manufacturer,m.image,md.name,md.meta_title,md.meta_keywords,md.meta_description from {{manufacturer}} m inner join {{manufacturer_description}} md on md.id_manufacturer=m.id_manufacturer where m.id_manufacturer="'.(int)$id.'" and status="1"')->queryRow();
		return $brand;
	}
}
