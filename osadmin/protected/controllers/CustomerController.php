<?php

class CustomerController extends Controller {
    
    public function accessRules() {
        return $this->addActions(array('Approve'));
    }
    
    public function actionApprove()
    {
        $ids=Yii::app()->request->getParam('id');
        //echo '<pre>';print_r($ids);exit;
        $approved=0;
        foreach($ids as $id)
        {
            $row=Customer::model()->find('id_customer='.$id);
            if(!$row->approved)
            {
                $data = array('id' => '4', 'replace' => array('%customer_name%' => $row->firstname . " " . $row->lastname), 'mail' => array("to" => array($row->email => $row->firstname . " " . $row->lastname)));
                //echo '<pre>';print_r($data);exit;
                Mail::send($data);
                $approved=1;
                $row->approved=1;
                $row->save(false);
            }
        }
        
        if($approved)
        {
            Yii::app()->user->setFlash('success','Selected customers approved successfully!!');
        }
        $this->redirect('index');
    }
    
    public function actionCreate() {
        $model['c'] = new Customer;
        if (Yii::app()->request->isPostRequest)
            {
                $model['c']->attributes = $_POST['Customer'];
                if($model['c']->validate())
				{
					$model['c']->date_created = new CDbExpression('NOW()');
					$model['c']->password = Customer::hashPassword($_POST['Customer']['password']);
					
					if (Yii::app()->config->getData('CONFIG_STORE_APPROVE_NEW_CUSTOMER')) 
                                        {
                                                $data = array('id' => '3', 'replace' => array('%customer_name%' => $_POST['Customer']['firstname'] . " " . $_POST['Customer']['lastname']), 'mail' => array("to" => array($_POST['Customer']['email'] => $_POST['Customer']['firstname'] . " " . $_POST['Customer']['lastname'],)));
                                                $model['c']->approved = 0;
                                        } else {
                                                $data = array('id' => '2', 'replace' => array('%customer_name%' => $_POST['Customer']['firstname'] . " " . $_POST['Customer']['lastname'], '%username%' => $_POST['Customer']['email'], '%password%' => $_POST['Customer']['password']), 'mail' => array("to" => array($_POST['Customer']['email'] => $_POST['Customer']['firstname'] . " " . $_POST['Customer']['lastname'],)));
                                                $model['c']->approved = 1;
                                        }
                                        $model['c']->save(false);
                                        foreach ($_POST['customer_address'] as $k=>$v) 
					{
						$modelAddress = new CustomerAddress;
						$modelAddress->attributes = $v;
						$modelAddress->id_customer=$model['c']->id_customer;
						$modelAddress->save();
						if($k==$_POST['default']){
							$model['c']->id_customer_address_default=$modelAddress->id_customer_address;
							$model['c']->save(false);
						}
					}
                                        //$model->save(false);
                                        Mail::send($data);
					
					Yii::app()->user->setFlash('success',Yii::t('common','message_create_success'));
					$this->redirect('index');
				}
            }
        $this->render('create', array('model' => $model,
        ));
    }
    
    public function actionUpdate($id) 
    {
			$model = $this->loadModel($id);
            if (Yii::app()->request->isPostRequest)
            {
				$model['c']->firstname = $_POST['Customer']['firstname'];
				$model['c']->lastname = $_POST['Customer']['lastname'];
				$model['c']->gender = $_POST['Customer']['gender'];
				$model['c']->id_customer_group = $_POST['Customer']['id_customer_group'];
				$model['c']->email = $_POST['Customer']['email'];
				$model['c']->telephone = $_POST['Customer']['telephone'];
				$model['c']->newsletter = $_POST['Customer']['newsletter'];
				$model['c']->status = $_POST['Customer']['status'];
				$model['c']->approved = $_POST['Customer']['approved'];
				if($_POST['Customer']['approved']==1){
					if(Yii::app()->config->getData('CONFIG_STORE_APPROVE_NEW_CUSTOMER')==1){
						$data = array('id'=>'4','replace'=>array('%username%'=>$_POST['Customer']['firstname'].$_POST['Customer']['lastname'],'%email%'=>$_POST['Customer']['email'],'%password%'=>$_POST['Customer']['password']),'mail'=>array("to"=>array($_POST['Customer']['email']=>$_POST['Customer']['firstname'].$_POST['Customer']['lastname']),"from"=>array(Yii::app()->config->getData('CONFIG_STORE_SUPPORT_EMAIL_ADDRESS')=>Yii::app()->config->getData('CONFIG_STORE_NAME')), "reply"=>array(Yii::app()->config->getData('CONFIG_STORE_REPLY_EMAIL')=>Yii::app()->config->getData('CONFIG_STORE_NAME')),));
						Mail::send($data);
					}
				}
				
				if(!empty($_POST['Customer']['password'])){
					$model['c']->password=Admin::hashPassword($_POST['Customer']['password']);
				}
                   
                    if ($model['c']->save(false))
                    {
                        CustomerAddress::model()->deleteAll(array('condition' => 'id_customer=:io','params' => array('io' => $id)));
                        foreach ($_POST['customer_address'] as $k=>$v) 
                        {
                            //echo "value of ".key($address)."<br/>";
                            $modelAddress = new CustomerAddress;
                            $modelAddress->attributes = $v;
                            $modelAddress->id_customer=$model['c']->id_customer;
                            $modelAddress->save();
                            if($k==$_POST['default']){
                                $model['c']->id_customer_address_default=$modelAddress->id_customer_address;
                                $model['c']->save(false);
                            }
                        }
                        Yii::app()->user->setFlash('success',Yii::t('common','message_modify_success'));
                        $this->redirect(base64_decode(Yii::app()->request->getParam('backurl')));
                    }
            }
            $this->render('update', array('model' => $model,));
    }

    public function actionDelete() {//($id)
        $arrayRowId = is_array(Yii::app()->request->getParam('id')) ? Yii::app()->request->getParam('id') : array(
        Yii::app()->request->getParam('id'));
        if (sizeof($arrayRowId) > 0) {
            $criteria = new CDbCriteria;
            $criteria->addInCondition('id_customer', $arrayRowId);
            CActiveRecord::model('Customer')->deleteAll($criteria);
            CActiveRecord::model('CustomerAddress')->deleteAll($criteria);
            Yii::app()->user->setFlash('success',Yii::t('common', 'message_delete_success'));
            
        } else {
            Yii::app()->user->setFlash('alert',
                    Yii::t('common', 'message_checkboxValidation_alert'));
            Yii::app()->user->setFlash('error',
                    Yii::t('common', 'message_delete_fail'));
        }
        if (!isset($_GET['ajax']))
                $this->redirect(base64_decode(Yii::app()->request->getParam('backurl')));
    }


	public function actionIndex()
	{
		$model=new Customer('search');
	        $model->unsetAttributes();  // clear any default values
		if(isset($_GET['Customer']))
			$model->attributes=$_GET['Customer'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

    public function loadModel($id)
	{
        $model['c']=Customer::model()->find(array("condition"=>"id_customer=".$id));
        $model['add']=CustomerAddress::model()->findAll(array("condition"=>"id_customer=".$id));
		return $model;
	}
    
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'manufacturer-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
