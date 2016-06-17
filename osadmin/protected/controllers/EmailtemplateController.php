<?php

class EmailTemplateController extends Controller
{
   
        public function actionCreate()
	{
		$model[0]=new EmailTemplate;
        $model[1]= new EmailTemplateDescription;
                
        if (Yii::app()->request->isPostRequest)
		{
                    	$model[0]->attributes=$_POST['EmailTemplate'];
                        $model[1]->attributes=$_POST['EmailTemplateDescription'];
                        
                        
                        if($model[0]->validate() && $model[1]->validate()):
                            $model[0]->save(false);
                            foreach(Language::getLanguages() as $language){
                                $insert=new EmailTemplateDescription;
                                $insert->attributes=$_POST['EmailTemplateDescription'];
                                $insert->id_email_template=$model[0]->id_email_template;
                                $insert->id_language=$language->id_language;
                                $insert->save(false);
                            }
                        Yii::app()->user->setFlash('success',Yii::t('common','message_create_success'));
                        $this->redirect('index');
                        endif;
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		if (Yii::app()->request->isPostRequest)
		{
        		$model[0]->attributes=$_POST['EmailTemplate'];
			$model[1]->attributes=$_POST['EmailTemplateDescription'];
                        if($model[0]->validate() && $model[1]->validate()):
                        //if($model[0]->save() && $model[1]->save()):
                            $model[0]->save(false);
                            $model[1]->save(false);
                            Yii::app()->user->setFlash('success',Yii::t('common','message_modify_success'));
                            $this->redirect(base64_decode (Yii::app()->request->getParam('backurl')));
                        endIf;
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

        public function actionDelete()//($id)
	{
            $arrayRowId=  is_array(Yii::app()->request->getParam('id'))?Yii::app()->request->getParam('id'):array(Yii::app()->request->getParam('id'));
            if(sizeof($arrayRowId)>0)
            {
                $criteria=new CDbCriteria;
                $criteria->addInCondition('id_email_template',$arrayRowId);
                if(CActiveRecord::model('EmailTemplate')->deleteAll($criteria) && CActiveRecord::model('EmailTemplateDescription')->deleteAll($criteria))
                {
                    Yii::app()->user->setFlash('success',Yii::t('common','message_delete_success'));
                }else
                {
                    //Yii::app()->user->setFlash('alert',Yii::t('common','message_checkboxValidation_alert'));
                    Yii::app()->user->setFlash('error',Yii::t('common','message_delete_fail'));
                }
            }else
            {
                Yii::app()->user->setFlash('alert',Yii::t('common','message_checkboxValidation_alert'));
                Yii::app()->user->setFlash('error',Yii::t('common','message_delete_fail'));
            }
            //exit;
  	    // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if(!isset($_GET['ajax']))
		//$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
                $this->redirect(base64_decode (Yii::app()->request->getParam('backurl')));
	}

	public function actionIndex()
	{
		$model=new EmailTemplate('search');
	        $model->unsetAttributes();  // clear any default values
		if(isset($_GET['EmailTemplate']))
			$model->attributes=$_GET['EmailTemplate'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	public function loadModel($id)
	{
		$modelp=EmailTemplate::model()->find('t.id_email_template='.$id);
        $modelc=EmailTemplateDescription::model()->lang()->find('t.id_email_template='.$id);
		if($modelp===null || $modelc===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return array($modelp,$modelc);
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='email-template-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
        public function actionlist(){
            echo "in list action";            
        }
}
