<?php

class Module
{
        public $moduleData;       
	public function init()
	{

	}
        
        public function prepare($findLayout,$moduleData=null){
            $position=Yii::app()->cache->get('module_'.$findLayout);
            if($position===false)
            {
				$dbrows=Yii::app()->db->createCommand("select * from {{configuration}} where `key` like 'MODULE_%'")->queryAll();
                //$dbrows=Configuration::model()->findAll("`key` like 'MODULE_%'");
                $modules=array();

                foreach($dbrows as $row)
                {
                    $unser=unserialize($row['value']);
                    foreach($unser['module'] as $ind)
                    {
                        $modules[]=array_merge(array("code"=>strtolower($row['code']),'data'=>$unser['data']),$ind);
                    }
                }

                $position=array();
                $sort=array();
                foreach($modules as $module)
                {
                    if($findLayout==$module['layout'] && $module['status']=='1')
                    {
                        $position[$module['position']][]=$module;	
                    }
                }

                $dependency="SELECT max(date_modified) FROM {{configuration_group}} where type='MODULE'";
                Yii::app()->cache->set('module_'.$findLayout,$position , 0, new CDbCacheDependency($dependency));
            }
            
            return $position;
        }
        
	/*public function prepare($findLayout,$moduleData=null)
	{
                $this->moduleData=$moduleData;
		$dbrows=Configuration::model()->findAll("`key` like 'MODULE_%'");
		$modules=array();

		foreach($dbrows as $row)
		{
			$unser=unserialize($row->value);
			foreach($unser['module'] as $ind)
			{
				$modules[]=array_merge(array("code"=>strtolower($row->code),'data'=>$unser['data']),$ind);
			}
		}

		
		$position=array();
		$sort=array();
		foreach($modules as $module)
		{
			if($findLayout==$module['layout'] && $module['status']=='1')
			{
				$position[$module['position']][]=$module;	
			}
		}
		return $position;
	}*/

	public function load($modules)
	{
		//echo '<pre>';print_r($modules);echo '</pre>';
                $sort=array();
		foreach($modules as $module)
		{
                    $sort[]=$module['sort_order'];
		}

		array_multisort($sort, SORT_ASC, $modules);
                //exit;
		foreach($modules as $module)
		{
			/*echo '<pre>';
			print_r($module);
			exit($module);*/
			$class=ucfirst($module['code']).'Class';
			 
			Yii::import('application.models.modules.'.$class);				
			//$Obj=new $module['code']($module);
			$Obj=new $class($module,$this->moduleData);
			//echo '<pre>';print_r($Obj);echo '</pre>';	
			Yii::app()->controller->renderPartial('application.models.modules.views.'.$module['code'],array('data'=>$Obj->data));
		}
	}
}