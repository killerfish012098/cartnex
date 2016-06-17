<?php
class CustomerGroupsController extends Controller
{
   
        public function actionCreate()
	{
                $model[0]= new CustomerGroup;
                $model[1]= new CustomerGroupDescription;
                
            if (Yii::app()->request->isPostRequest)
			{

                $model[0]->attributes=$_POST['CustomerGroup'];
				$model[1]->attributes=$_POST['CustomerGroupDescription'];							
				if($model[0]->validate() && $model[1]->validate()):
				$model[0]->save(false);

					
                foreach(Language::getLanguages() as $language){
				$insert=new CustomerGroupDescription;
				$insert->attributes=$_POST['CustomerGroupDescription'];
				$insert->id_customer_group=$model[0]->id_customer_group;
                $insert->id_language=$language->id_language;
				$insert->save(false);
				}
                Yii::app()->user->setFlash('success',Yii::t('common','message_create_success'));
			$this->redirect('index');
			endif;
		}
		$this->render('create',array('model'=>$model,));
	}

	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		if (Yii::app()->request->isPostRequest)
		{
        		$model[0]->attributes=$_POST['CustomerGroup'];
			$model[1]->attributes=$_POST['CustomerGroupDescription'];
                        if($model[0]->validate() && $model[1]->validate()):
                        //if($model[0]->save() && $model[1]->save()):
                            $model[0]->save(false);
                            $model[1]->save(false);
                            Yii::app()->user->setFlash('success',Yii::t('common','message_modify_success'));
                            $this->redirect(base64_decode (Yii::app()->request->getParam('backurl')));
                        endIf;
		}

		$this->render('update',array('model'=>$model,));
	}

	
	   public function actionDelete()//($id)
	{
            $arrayRowId=  is_array(Yii::app()->request->getParam('id'))?Yii::app()->request->getParam('id'):array(Yii::app()->request->getParam('id'));
            if(sizeof($arrayRowId)>0)
            {
                $arrayRowId=$this->findRelated($arrayRowId);
                
                $criteria=new CDbCriteria;
                $criteria->addInCondition('id_customer_group',$arrayRowId);
                                
                if(CActiveRecord::model('CustomerGroup')->deleteAll($criteria) && CActiveRecord::model('CustomerGroupDescription')->deleteAll($criteria))
                {
                    Yii::app()->user->setFlash('success',Yii::t('common','message_delete_success'));
                }else
                {
                    Yii::app()->user->setFlash('error',Yii::t('common','message_delete_fail'));
                }
            }else
            {
                Yii::app()->user->setFlash('alert',Yii::t('common','message_checkboxValidation_alert'));
                Yii::app()->user->setFlash('error',Yii::t('common','message_delete_fail'));
            }
        
            if(!isset($_GET['ajax']))
                $this->redirect(base64_decode (Yii::app()->request->getParam('backurl')));
	}
        
        public function findRelated($input)
        {
            $criteria=new CDbCriteria;
            $criteria->select="DISTINCT t.id_customer_group, cg.name";
            $criteria->join="INNER JOIN r_customer_group_description cg on t.id_customer_group = cg.id_customer_group";
            $criteria->condition='cg.id_language =  "'.Yii::app()->session['language'].'" AND t.id_customer_group   IN ( '.implode(",",$input).' )';
            $customers=Customer::model()->findAll($criteria); 
			

            if(sizeof($customers)>0)
            {
                $items="";
                $input=array_flip($input);
                foreach($customers as $customer):
                    $items.=$prefix.strip_tags($customer->firstname." ".$customer->lastname);
                    $prefix=",";
                    unset($input[$customer->id_customer_group]);
                endforeach;
                $input=array_flip($input);

                Yii::app()->user->setFlash('alert',Yii::t('customergroups','warning_customergroup', array('{details}'=>$items)));
            }
            return $input; 
        }
		
		
		

	public function actionIndex()
	{
		$model=new CustomerGroup('search');
	        $model->unsetAttributes();  // clear any default values
		if(isset($_GET['CustomerGroup']))
			$model->attributes=$_GET['CustomerGroup'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	public function loadModel($id)
	{
		$modelp=CustomerGroup::model()->find('t.id_customer_group='.$id);
        $modelc=CustomerGroupDescription::model()->lang()->find('t.id_customer_group='.$id);
		if($modelp===null || $modelc===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return array($modelp,$modelc);
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='customer-group-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
 
}