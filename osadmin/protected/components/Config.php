<?php
class Config
{
    private $data=array();
    
    public function getData($key)
    {
        return $this->data[$key];
    }
    
    /*public function init()
    {
        foreach(Configuration::getConfigurations() as $config)
     	{
            $this->data[$config->key]=$config->value;	
        }

		$yii=Yii::app();
		$this->data['CONFIG_WEBSITE_ITEMS_PER_PAGE_ADMIN']=$yii->request->getParam('page',$this->data['CONFIG_WEBSITE_ITEMS_PER_PAGE_ADMIN']);
		
		$languages=Language::getLanguages();
		
		foreach($languages as $lang)
		{
			$this->data['languages'][$lang->code]=$lang->getAttributes();
		}
	}*/

	public function init()
    {
        foreach(Configuration::model()->findAll() as $config)
        {
			
			if($config->key=='CONFIG_WEBSITE_ALLOWED_FILE_TYPES')
			{
				$type=array();
				foreach(explode("\n",$config->value) as $mimetype)
				{
					$type[]=trim($mimetype);
				}
				$config->value=$type;
			}

            $this->data[$config->key]=$config->value;	
        }

		

		$yii=Yii::app();
		$this->data['CONFIG_WEBSITE_ITEMS_PER_PAGE_ADMIN']=$yii->request->getParam('page',$this->data['CONFIG_WEBSITE_ITEMS_PER_PAGE_ADMIN']);
		
		$languages=Language::getLanguages();
		
		foreach($languages as $lang)
		{
			$this->data['languages'][$lang->code]=$lang->getAttributes();
		}
		$this->setLanguage();

		foreach(OrderStatus::getOrderStatuses() as $os)
		{
			$this->data['orderStatusDetails'][$os->name]=$os->color;
			$this->data['orderStatusDetails'][$os->id_order_status]=$os->color;
		
		}
		//exit;

		/*echo '<pre>';
		print_r($_SESSION);
		echo '</pre>';*/
	}

	public function setLanguage() {
        if (isset($_GET['lang'])) {
            if (sizeof($this->data['languages']) > 0) {
                Yii::app()->session['language'] = $this->data['languages'][$_GET['lang']]['id_language'];
                Yii::app()->session['languagecode'] = $this->data['languages'][$_GET['lang']]['code'];
                Yii::app()->language = $this->data['languages'][$_GET['lang']]['code'];
            }
        } else {
			if (Yii::app()->session['language'] == '' || Yii::app()->session['languagecode'] == '') {

                Yii::app()->session['language'] = $this->data['languages'][$this->data['CONFIG_STORE_DEFAULT_LANGUAGE']]['id_language'];
                Yii::app()->language = $this->data['CONFIG_STORE_DEFAULT_LANGUAGE'];
                Yii::app()->session['languagecode'] = $this->data['CONFIG_STORE_DEFAULT_LANGUAGE'];
            } else {
                Yii::app()->session['language'] = Yii::app()->session['language'];
                Yii::app()->language = Yii::app()->session['languagecode'];
            }
        }
    }
}