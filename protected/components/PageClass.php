<?php

class PageClass 
{

	private $id_language;
	private $db;
	
	public function init()
	{
		$languages=Yii::app()->config->getData('languages');
		$this->id_language=$languages[Yii::app()->session['language']]['id_language'];
		$this->db = Yii::app()->db;
	}

	public function getContent($page_id)
	{
	    
		$query = $this->db->createCommand("select pd.* from {{page}} p inner join {{page_description}} pd on pd.id_page=p.id_page where pd.id_language='".$this->id_language."' and p.id_page='".(int)$page_id."' and p.status=1");
		return $results=$query->queryRow();
	}

}
