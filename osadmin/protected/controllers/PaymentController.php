<?php

class PaymentController extends Controller 
{
    public function install($code)
    {
        CActiveRecord::model('ConfigurationGroup')->deleteAll(array('condition'=>'type="PAYMENT" and code="'.$code.'"'));
        $model=new ConfigurationGroup;
        $model->type='PAYMENT';
        $model->code=$code;
        $model->date_created=new CDbExpression('NOW()');
        $model->save(false);
    }
    
    public function actionCreate() 
    {
        $str=base64_decode($_GET['str']);
        if(file_exists(Library::getPaymentPath().'/'.$str."_Model.php"))
        {
            $modelStr=$str."_Model";
            $code=$modelStr::getCode();
            $this->install($code);
            ConfigurationGroup::model()->updateAll(array('date_modified'=> new CDbExpression('NOW()')),"`type`='PAYMENT' and `code`='".$code."'");
			Yii::app()->user->setFlash('success',Yii::t('common', 'message_create_success'));
        }else
        {
            Yii::app()->user->setFlash('alert','Invalid Payment Gateway!!');//Yii::t('common', 'message_checkboxValidation_alert'));
            Yii::app()->user->setFlash('error',Yii::t('common', 'message_create_fail'));
        }
        $this->redirect(array('payment/index'));
    }
    
    /*public function actionCreate() {
            
        $str=base64_decode($_GET['str']);
            
       // EXIT;
        if(file_exists(Library::getPaymentPath().'/'.$str."_Model.php"))
        {
            $modelStr=$str."_Model";
            $formStr=$str."_Form";
            
            $form = new CForm('application.models.payment.'.$formStr,$this->loadModel($modelStr));
            if($form->submitted($modelStr) && $form->validate())
            {
                $code=$modelStr::getCode();
                $this->install($code);
                Configuration::model()->deleteAll(array('condition'=>'code="'.$code.'" and `key` like "PAYMENT_'.$code.'_%"'));
                foreach($_POST[$modelStr] as $k=>$v)
                {
                    $insert=new Configuration;
                    $insert->key=$k;
                    $insert->value=$v;
                    $insert->code=$code;
                    $insert->save();
                }
                //Yii::app()->user->setFlash('success',Yii::t('common', 'message_create_success'));
				Yii::app()->user->setFlash('success',Yii::t('common', 'module_install_success',array('{module}'=>ucfirst($code))));
                $this->redirect(array('payment/index'));
            }
            
            $this->render('create', array('form'=>$form));

        }else
        {
            Yii::app()->user->setFlash('alert','Invalid Payment Gateway!!');//Yii::t('common', 'message_checkboxValidation_alert'));
            Yii::app()->user->setFlash('error',Yii::t('common', 'message_create_fail'));
            $this->redirect($this->createUrl('index'));
        }
    }*/

    public function actionUpdate()//$id) 
    {
        $str=base64_decode($_GET['str']);
        $modelStr=$str."_Model";
        $formStr=$str."_Form";
        
        $form = new CForm('application.models.payment.'.$formStr, $this->loadModel($modelStr));
        if($form->submitted($modelStr) && $form->validate())
        {
            //exit($str);
            $code=$modelStr::getCode();
            //array_merge($_POST[$modelStr],array('PAYMENT_'.$code.'_FILE',$str));
            //$_POST[$modelStr]['PAYMENT_'.$code.'_FILE']=$str;
            /*echo '<pre>';
            print_r($_POST);
            echo '</pre>';
            exit;*/
            Configuration::model()->deleteAll(array('condition'=>'code="'.$code.'" and `key` like "PAYMENT_'.$code.'_%"'));
            $this->insertFile(array('code'=>$code,'value'=>$str,'key'=>'PAYMENT_'.$code.'_FILE'));
            foreach($_POST[$modelStr] as $k=>$v)
            {
                $insert=new Configuration;
                $insert->key=$k;
                $insert->value=$v;
                $insert->code=$code;
                $insert->save();
            }
			ConfigurationGroup::model()->updateAll(array('date_modified'=> new CDbExpression('NOW()')),"`type`='PAYMENT' and `code`='".$code."'");

            Yii::app()->user->setFlash('success',Yii::t('common', 'module_modify_success',array('{module}'=>ucfirst($code))));
            $this->redirect(array('payment/index'));
        }
        $this->render('update', array('form'=>$form));
    }
    
    public function insertFile($input)
    {
        $insert=new Configuration;
        $insert->key=$input['key'];
        $insert->value=$input['value'];
        $insert->code=$input['code'];
        $insert->save();
    }
    
    public function actionDelete() {//($id)
        /*echo $_SERVER['REQUEST_METHOD'];
        exit;*/
        $file=base64_decode($_GET['str'])."_Model";
        
        if(file_exists(Library::getPaymentPath().'/'.$file.".php"))
        {
            $model=new $file;
            $code=$model->getCode();

            CActiveRecord::model('Configuration')->deleteAll(array('condition'=>'code="'.$code.'" and `key` like "PAYMENT_'.$code.'_%"'));
            CActiveRecord::model('ConfigurationGroup')->deleteAll(array('condition'=>'type="payment" and code="'.$code.'"'));
            Yii::app()->user->setFlash('success',Yii::t('common', 'module_uninstall_success',array('{module}'=>ucfirst($code))));
        }else
        {
            Yii::app()->user->setFlash('alert','Invalid Payment Gateway!!');//Yii::t('common', 'message_checkboxValidation_alert'));
            Yii::app()->user->setFlash('success',Yii::t('common', 'module_uninstall_fail',array('{module}'=>ucfirst($code))));
        }
        
        if(!isset($_GET['ajax']))
            $this->redirect($this->createUrl('index'));
        
        }
    


    public function actionIndex() 
    {
        $scanPaymentDir=scandir(Library::getPaymentPath());
        $model=array();
        $payRows=CHtml::listData(ConfigurationGroup::model()->findAll(array('condition'=>'type="PAYMENT"')),'id_configuration_group' ,'code');
        
        foreach($scanPaymentDir as $file)
        {
            if(substr($file,-10,10)=='_Model.php')
            {
                $obj=$this->loadModel(substr($file,0,-4));
                $code=$obj->getCode();
                $title="PAYMENT_".$code."_TITLE";
                $sort_order="PAYMENT_".$code."_SORT_ORDER";
                $status="PAYMENT_".$code."_STATUS";
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
                //http://sun-network/osadmin/index.php/payment/update/id/'.base64_encode($data['file']).'
                        
                        $return=$data['installed']=='1'?'<a href="'.$this->createUrl('payment/update',array("str"=>base64_encode($data['file']))).'">Configure</a> | <a href="'.$this->createUrl('payment/delete',array("str"=>base64_encode($data['file']))).'" id="uninstall" >Un Install</a>':'<a href="'.$this->createUrl('payment/create',array("str"=>base64_encode($data['file']))).'">Install</a>';
                        break;
        }
        return $return;
    }

    public function loadModel($str)
    {
        $model=new $str;
        $code=$model::getCode();
        $data=Configuration::model()->findAll(array('select'=>'`key`,value','condition'=>'code="'.$code.'" and `key` like "PAYMENT_'.$code.'_%"'));
        
        foreach($data as $conf ):
        if(substr($conf->key,-5,5)=='_FILE')
        {
            continue;
        }
            $key=$conf->key;
            $model->$key=$conf->value;
        endforeach;
        //exit;
        return $model;
    }
}
