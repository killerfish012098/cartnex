<?php
class Config
{
    private $data=array();
 
    public function getData($key)
    {
        return $this->data[$key];
    }
    
    public function init(){
        $cache=Yii::app()->cache;
        $this->data=$cache->get('config');
        if($this->data===false)
        {
                $connection = Yii::app()->db;
				//$sql="SELECT `key`,`value` FROM {{configuration}} where code like 'CONFIG'";
				$sql="SELECT `key`,`value` FROM {{configuration}}";
                foreach ($connection->createCommand($sql)->queryAll() as         $config) {
						if($config['key']=='CONFIG_WEBSITE_ALLOWED_FILE_TYPES')
						{
							$type=array();
							foreach(explode("\n",$config['value']) as $mimetype)
							{
								$type[]=trim($mimetype);
							}
							$config['value']=$type;
						}
                        $this->data[$config['key']] = $config['value'];
                }
				//echo '<pre>';print_r($this->data['CONFIG_WEBSITE_ALLOWED_FILE_TYPES']);
				//exit;

                $languages = $connection->createCommand("SELECT * FROM {{language}} where status=1")->queryAll();
                //echo '<pre>';
                foreach ($languages as $language) {
                        $this->data['languages'][$language['code']] = $language;
                }

                $currencies = $connection->createCommand("SELECT * FROM {{currency}} where status=1")->queryAll();
                foreach ($currencies as $currency) {
                        $this->data['currencies'][$currency['code']] = $currency;
                }
                $dependency="SELECT concat(MAX(date_modified),'-',(select max(date_modified) from {{language}}),'-',(select max(date_modified) from {{currency}})) as date_modified FROM {{configuration_group}}";
                        
                $cache->set('config',$this->data , 0, new CDbCacheDependency($dependency));
        }

		//echo '<pre>';print_r($this->data);//exit;
    }
	
	/*public function init()
    {
        foreach(Configuration::model()->findAll() as $config)
        {
            $this->data[$config->key]=$config->value;	
        }

		$connection = Yii::app()->db;
		$languages=$connection->createCommand("SELECT * FROM {{language}} where status=1")->queryAll();
		//echo '<pre>';
		foreach($languages as $language)
		{
			$this->data['languages'][$language['code']]=$language;
		}

		$currencies=$connection->createCommand("SELECT * FROM {{currency}} where status=1")->queryAll();
		foreach($currencies as $currency)
		{
			$this->data['currencies'][$currency['code']]=$currency;
		}
    }*/
}