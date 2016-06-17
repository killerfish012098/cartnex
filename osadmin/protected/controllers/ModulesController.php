<?php

class ModulesController extends Controller 
{
    public function actionCreate() 
    {
        $file=base64_decode($_GET['str']);
        $code=strtoupper(end(explode("_",$file)));
        CActiveRecord::model('ConfigurationGroup')->deleteAll(array('condition'=>'type="MODULE" and code="'.$code.'"'));
        $model=new ConfigurationGroup;
        $model->type='MODULE';
        $model->code=$code;
        $model->date_created=new CDbExpression('NOW()');
        $model->save(false);
		ConfigurationGroup::model()->updateAll(array('date_modified'=> new CDbExpression('NOW()')),"`type`='MODULE' and `code`='".$code."'");
        Yii::app()->user->setFlash('success',Yii::t('common', 'module_install_success',array('{module}'=>ucfirst(end(explode("_",$file))))));
        $this->redirect(array('modules/index'));
		
    }

    public function actionUpdate()//$id) 
    {
        $str=base64_decode($_GET['str']);
        if (Yii::app()->request->isPostRequest)
        {
            
            /*echo '<pre>';
            print_r(array("data"=>$_POST[data],"module"=>$_POST[module]));
            exit;
            print_r($_POST);
            exit;*/
            serialize($_POST['module']);
            Configuration::model()->deleteAll(array('condition'=>'`code`="'.$_POST[code].'" and `key`="MODULE_'.$_POST[code].'"'));
            ConfigurationGroup::model()->deleteAll(array('condition'=>'`type`="MODULE" and `code`="'.$_POST[code].'"'));
            
            $ConfiGroup=new ConfigurationGroup;
            $ConfiGroup->type="MODULE";
            $ConfiGroup->code=$_POST[code];
            $ConfiGroup->save(false);
            //$ConfiGroup->save(true,array('type'=>'MODULE','code'=>$_POST[code]));
            //exit;
            $Confi=new Configuration;
            $Confi->code=$_POST[code];
            $Confi->key='MODULE_'.$_POST[code];
            $Confi->value=serialize(array("data"=>$_POST[data],"module"=>$_POST[module]));
            $Confi->save(false);
            //print_r(unserialize($Confi->value));
            //exit();
			ConfigurationGroup::model()->updateAll(array('date_modified'=> new CDbExpression('NOW()')),"`type`='MODULE' and `code`='".$code."'");
              Yii::app()->user->setFlash('success',Yii::t('common', 'module_modify_success',array('{module}'=>ucfirst(strtolower($_POST[code])))));
            $this->redirect(array('modules/index'));
            //$Confi->save(false,array('code'=>$_POST[code],'key'=>'MODULE_'.$_POST[code],'value'=>  serialize($_POST[module])));
            //exit;
        }
        //exit($str);
        /*if(1)
        {
            $code=$modelStr::getCode();
            Configuration::model()->deleteAll(array('condition'=>'code="'.$code.'" and `key` like "SHIPPING_'.$code.'_%"'));
            foreach($_POST[$modelStr] as $k=>$v)
            {
                $insert=new Configuration;
                $insert->key=$k;
                $insert->value=$v;
                $insert->code=$code;
                $insert->save();
            }
            Yii::app()->user->setFlash('success',Yii::t('common', 'message_modify_success'));
            $this->redirect(array('shipping/index'));
        }*/
        $code=strtoupper(end(explode("_",$str)));
        $row=Configuration::model()->find(array('condition'=>'`key`="MODULE_'.$code.'" and code="'.$code.'"'));
        /*echo $row->value.'<pre>';
        print_r(unserialize($row->value));
        echo '</pre>';
        exit;*/
        //exit("code : ".$code);
        $this->render('update',array('module'=>$str,'data'=>unserialize($row->value),'code'=>$code));
    }

    public function actionDelete() 
    {
        $file=base64_decode($_GET['str']);
        $code=strtoupper(end(explode("_",$file)));
        CActiveRecord::model('Configuration')->deleteAll(array('condition'=>'code="'.$code.'" and `key` like "MODULE_'.$code.'"'));
        CActiveRecord::model('ConfigurationGroup')->deleteAll(array('condition'=>'type="MODULE" and code="'.$code.'"'));
         Yii::app()->user->setFlash('success',Yii::t('common', 'module_uninstall_success',array('{module}'=>ucfirst(end(explode("_",$file))))));
        $this->redirect($this->createUrl('index'));
    }
    
    public function getInfo()
    {
        $scanModuleDir=scandir(Library::getModulesPath());
        $return=array();
        foreach($scanModuleDir as $file):
            //echo $file." -- ".substr($file,-4,4)."<br/>";
            //if(substr($file,0,-4))
            if(substr($file,-4,4)=='.php')
            {
                $return[]=substr($file,0,-4);
            }
        endforeach;
        
        return $return;
    }
    
    public function actionIndex() 
    {
        $scanModuleDir=$this->getInfo();
        //exit;
        //$scanModuleDir=scandir(Library::getModulesPath());
        //echo '<pre>';
        
        $model=array();
        $payRows=CHtml::listData(ConfigurationGroup::model()->findAll(array('condition'=>'type="MODULE"')),'id_configuration_group' ,'code');
        //print_r($scanModuleDir);
        //print_r($payRows);
        //exit;
        foreach($scanModuleDir as $file)
        {
           $exp=explode("_",$file);
           //echo "end ".end($exp)."<br/>";
           $code=strtoupper(end($exp));            
           //print_r($exp);
           array_pop($exp);
           $title=ucfirst(implode(" ",$exp));
           //echo  "code : ".$code."title: ".$title."<br/>";        
           $installed=in_array($code,$payRows)?'1':'0';
            
           $model[]=array("file"=>$file,"title"=>$title,"installed"=>$installed);
        }
        //exit;
        /*print_r($model);
        exit;*/
        
        $arrayDataProvider=new CArrayDataProvider($model, array(
		'pagination'=>array(
			'pageSize'=>Yii::app()->config->getData('CONFIG_WEBSITE_ITEMS_PER_PAGE_ADMIN'),
		),
	));

        $this->render('index', array('dataProvider'=>$arrayDataProvider));
    }
    
    protected function grid($data,$row,$dataColumn)
    {
        switch ($dataColumn->name)
        {
            case 'file':$return=str_replace("_"," ",$data['file']);
                        break;
                    
            case 'status':
                        $return=$data['status']=='1'?'Enable':'Disable';
                        break;
            
            case 'installed':
                        $return=$data['installed']=='1'?'<a href="'.$this->createUrl('modules/update',array("str"=>base64_encode($data['file']))).'">Configure</a> | <a href="'.$this->createUrl('modules/delete',array("str"=>base64_encode($data['file']))).'" id="uninstall" >Un Install</a>':'<a href="'.$this->createUrl('modules/create',array("str"=>base64_encode($data['file']))).'">Install</a>';
                        break;
        }
        return $return;
    }

}
