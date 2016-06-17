<?php

class CartrulesController extends Controller 
{
    public function install($code)
    {
        CActiveRecord::model('ConfigurationGroup')->deleteAll(array('condition'=>'type="CARTRULE" and code="'.$code.'"'));
        $model=new ConfigurationGroup;
        $model->type='CARTRULE';
        $model->code=$code;
        $model->date_created=new CDbExpression('NOW()');
        $model->save(false);
    }
    
    public function actionCreate() {
            
        $str=base64_decode($_GET['str']);
            
        if(file_exists(Library::getCartRulesPath().'/'.$str."_Model.php"))
        {
            $modelStr=$str."_Model";
            $code=$modelStr::getCode();
            $this->install($code);
           	ConfigurationGroup::model()->updateAll(array('date_modified'=> new CDbExpression('NOW()')),"`type`='CARTRULE' and `code`='".$code."'"); 
           Yii::app()->user->setFlash('success',Yii::t('common', 'message_create_success'));
        }else
        {
            Yii::app()->user->setFlash('alert','Invalid Cart Rule!!');//Yii::t('common', 'message_checkboxValidation_alert'));
            Yii::app()->user->setFlash('error',Yii::t('common', 'message_create_fail'));
        }
        $this->redirect($this->createUrl('index'));
    }
    
    public function insertFile($input)
    {
        $insert=new Configuration;
        $insert->key=$input['key'];
        $insert->value=$input['value'];
        $insert->code=$input['code'];
        $insert->save();
    }

    public function actionUpdate()//$id) 
    {
        $str=base64_decode($_GET['str']);
        $modelStr=$str."_Model";
        $formStr=$str."_Form";
        
        $form = new CForm('application.models.cartrules.'.$formStr, $this->loadModel($modelStr));
        if($form->submitted($modelStr) && $form->validate())
        {
            //exit($str);
            $code=$modelStr::getCode();
            Configuration::model()->deleteAll(array('condition'=>'code="'.$code.'" and `key` like "CARTRULE_'.$code.'_%"'));
            $this->insertFile(array('code'=>$code,'value'=>$str,'key'=>'CARTRULE_'.$code.'_FILE'));
            foreach($_POST[$modelStr] as $k=>$v)
            {
                $insert=new Configuration;
                $insert->key=$k;
                $insert->value=$v;
                $insert->code=$code;
                $insert->save();
            }
			ConfigurationGroup::model()->updateAll(array('date_modified'=> new CDbExpression('NOW()')),"`type`='CARTRULE' and `code`='".$code."'");
            Yii::app()->user->setFlash('success',Yii::t('common', 'message_modify_success'));
            $this->redirect(array('cartrules/index'));
        }
        $this->render('update', array('form'=>$form));
    }

    public function actionDelete() {
        
        $file=base64_decode($_GET['str'])."_Model";
        
        if(file_exists(Library::getCartRulesPath().'/'.$file.".php"))
        {
            $model=new $file;
            $code=$model->getCode();

            CActiveRecord::model('Configuration')->deleteAll(array('condition'=>'code="'.$code.'" and `key` like "CARTRULE_'.$code.'_%"'));
            CActiveRecord::model('ConfigurationGroup')->deleteAll(array('condition'=>'type="CARTRULE" and code="'.$code.'"'));
            Yii::app()->user->setFlash('success',Yii::t('common', 'message_delete_success'));
        }else
        {
            Yii::app()->user->setFlash('alert','Invalid Cart Rule!!');//Yii::t('common', 'message_checkboxValidation_alert'));
            Yii::app()->user->setFlash('error',Yii::t('common', 'message_delete_fail'));
        }
        
        if(!isset($_GET['ajax']))
            $this->redirect($this->createUrl('index'));
        
    }
    
    public function actionIndex() 
    {
        $scanPaymentDir=scandir(Library::getCartRulesPath());
        $model=array();
        $payRows=CHtml::listData(ConfigurationGroup::model()->findAll(array('condition'=>'type="CARTRULE"')),'id_configuration_group' ,'code');
        
        foreach($scanPaymentDir as $file)
        {
            if(substr($file,-10,10)=='_Model.php')
            {
                $obj=$this->loadModel(substr($file,0,-4));
                $code=$obj->getCode();
                $title="CARTRULE_".$code."_TITLE";
                $sort_order="CARTRULE_".$code."_SORT_ORDER";
                $status="CARTRULE_".$code."_STATUS";
                $installed=in_array($code,$payRows)?'1':'0';
                $model[]=array("code"=>$code,"file"=>substr($file,0,-10),"title"=>$obj->$title,"sort_order"=>$obj->$sort_order,"status"=>$obj->$status,"installed"=>$installed);
            }
        }
        
        $arrayDataProvider=new CArrayDataProvider($model, array(
		'pagination'=>array(
			'pageSize'=>10,
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
                        $return=$data['installed']=='1'?'<a href="'.$this->createUrl('cartrules/update',array("str"=>base64_encode($data['file']))).'">Configure</a> | <a href="'.$this->createUrl('cartrules/delete',array("str"=>base64_encode($data['file']))).'" id="uninstall" >Un Install</a>':'<a href="'.$this->createUrl('cartrules/create',array("str"=>base64_encode($data['file']))).'">Install</a>';
                        break;
        }
        return $return;
    }

    public function loadModel($str)
    {
        $model=new $str;
        $code=$model::getCode();
        $data=Configuration::model()->findAll(array('select'=>'`key`,value','condition'=>'code="'.$code.'" and `key` like "CARTRULE_'.$code.'_%"'));
        
        foreach($data as $conf ):
            if(substr($conf->key,-5,5)=='_FILE')
            {
                continue;
            }
            $key=$conf->key;
            $model->$key=$conf->value;
        endforeach;
        
        return $model;
    }
}