<?php

class Library 
{
           
        
    /*public function getBannerLink() {
        //return Yii::app()->params['config']['site_url'].'img/';
        return Yii::app()->params['config']['document_root'] . 'front_end/img/';
    }

    public function getCatalogUploadLink() {
        return Yii::app()->params['config']['site_url'] . 'uploads/catalog/';
    }*/

	public function getCatalogUploadLink()
    {
        return Yii::app()->params['config']['site_url'].Yii::app()->params['config']['upload_path'].'catalog/';
    }

    /*public function getUrlPath() {
        return Yii::app()->params['config']['site_url'] . 'index.php';
    }
    public function defaultTheme() {
        return Yii::app()->params['config']['site_url'] . 'themes/default/';
    }*/

    public function imageRootPath() {
        return Yii::app()->params['config']['document_root'] .Yii::app()->params['config']['upload_path']. 'catalog/';
		//return Yii::app()->params['config']['document_root'] . 'front_end/uploads/catalog/';
    }

    /*public function fileUploadProductdetails() {
        return Yii::app()->params['config']['document_root'] . 'front_end\uploads\misc/';
    }

    public function popupJavascriptPath() {
        return Yii::app()->params['config']['site_url'] . 'themes/default/js/';
    }*/

    public function getMiscUploadLink() {
        //return Yii::app()->params['config']['site_url'] . 'uploads/misc/';
		return Yii::app()->params['config']['site_url'].Yii::app()->params['config']['upload_path'].'misc/';
    }

	public function getMiscUploadPath()
    {
        return Yii::app()->params['config']['document_root'].Yii::app()->params['config']['upload_path'].'misc/';
    }

	public function getCatalogUploadPath()
    {
        return Yii::app()->params['config']['document_root'].Yii::app()->params['config']['upload_path'].'catalog/';
    }

	public function shortString($data)
    {
        if(strlen($data['str'])>$data['len'])
        {
            $return=substr($data['str'],0,$data['len'])."..";
        }else
        {
            $return=$data['str'];
        }
        return $return;
    }

	public function getCountries()
	{
		return Yii::app()->db->createCommand('select * from {{country}} where status=1')->queryAll();
	}

	public function getCountry($id)
	{
		return Yii::app()->db->createCommand('select * from {{country}} where status=1 and id_country="'.$id.'"')->queryRow();
	}

	public function getState($id)
	{
		return Yii::app()->db->createCommand('select * from {{state}} where status=1 and id_state="'.$id.'"')->queryRow();
	}

	public function prepareMailTemplate($data)
	{
		$file=Yii::app()->params['config']['document_root'].Yii::app()->params['config']['upload_path'].'order_'.$data['language_code'].'.tpl';
		/*echo strtotime(date("F d Y H:i:s")).' file time '.filemtime($file)." ".strtotime(date("F d Y H:i:s"));*
		$row=Yii::app()->db->createCommand('select description,date_modified from {{email_template}} et,{{email_template_description}} etd where et.id_email_template=etd.id_email_template and etd.id_language="'.$data['id_language'].'" and et.id_email_template=1')->queryRow();
		echo $row['description'].'<br/>';
		echo strtotime($row['date_modified'])." > ".filemtime($file)."<br/>".date ("F d Y H:i:s.",strtotime($row['date_modified']))." > ".date ("F d Y H:i:s.", filemtime($file));*/
		//exit;
		if(!file_exists($file) || (strtotime($row['date_modified'])>filemtime($file)))
		{
			file_put_contents($file, $row['description']);
		}
	}

	public function setSearchKeyword($key)
	{
		$key=trim($key);
		if($key!="")
		{
			$row=Yii::app()->db->createCommand("select *  from {{search_keyword}} where lower(keyword) like '".strtolower($key)."'")->queryRow();
			if($row)
			{
				Yii::app()->db->createCommand("update {{search_keyword}} set hits=hits+1 where id_search_keyword='".$row['id_search_keyword']."'")->query();
			}else
			{
				Yii::app()->db->createCommand("insert into {{search_keyword}}(keyword,hits) values('".$key."','1')")->query();
			}
		}
	}

	public function getSearchKeys($search_query) {

        $query = Yii::app()->db->createCommand("select keyword from {{search_keyword}} where lower(keyword) like '%".strtolower(trim($search_query))."%' order by keyword asc limit 0,10");
        return $results = $query->queryAll();
    }

	public static function getCurrencies()
	{
		return Yii::app()->db->createCommand("select * from {{currency}} where status=1")->queryAll();
	}

	public function getStates($id_country)
	{
		return Yii::app()->db->createCommand("select * from {{state}} where id_country='".$id_country."' and status=1")->queryAll();
	}

	public function getSlideShow($id_banner) {
		$languages=Yii::app()->config->getData('languages');
        $lang = $languages[Yii::app()->session['language']]['id_language'];
		$banner_data=Yii::app()->db->createCommand("SELECT * FROM {{banner_image}} bi LEFT JOIN {{banner_image_description}} bid ON (bi.id_banner_image = bid.id_banner_image) WHERE bi.id_banner = '" . (int)$id_banner . "' AND bid.id_language = '" . $lang . "'");
		return $banner_data->queryAll();
	}

	public function getMaintenanceData()
	{
		$rows=Yii::app()->db->createCommand("SELECT last_visit_date FROM {{admin}} where status=1 and date(present_visit_date)='".date(Y)."-".date(m)."-".date(d)."'")->queryAll();
		$returnData=array();
		foreach($rows as $row)
		{
			$returnData[]=$row['last_visit_date'];
		}
		//echo "<pre>";print_r($returnData);exit;
		return $returnData;
	}

	 
}