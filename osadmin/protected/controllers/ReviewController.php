<?php

class ReviewController extends Controller
{
	public function actionCreate()
	{
		$model=new Review;
		
		if (Yii::app()->request->isPostRequest)
		{
			$model->attributes=$_POST['Review'];
			if($model->save(false))
			//exit;
				Yii::app()->user->setFlash('success',Yii::t('common','message_create_success'));
				$this->redirect('index');
		}
		$this->render('create',array('model'=>$model));
	}

	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		if (Yii::app()->request->isPostRequest)
		{
			$model->attributes=$_POST['Review'];
			if($model->save(false))
				Yii::app()->user->setFlash('success',Yii::t('common','message_modify_success'));
                $this->redirect(base64_decode(Yii::app()->request->getParam('backurl')));
		}
		$this->render('update',array('model'=>$model));
	}

    public function actionDelete()//($id)
	{
            $arrayRowId=  is_array(Yii::app()->request->getParam('id'))?Yii::app()->request->getParam('id'):array(Yii::app()->request->getParam('id'));
            if(sizeof($arrayRowId)>0)
            {
                $criteria=new CDbCriteria;
                $criteria->addInCondition('id_review', $arrayRowId);
                                
                if(CActiveRecord::model('Review')->deleteAll($criteria))
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

	
	public function actionIndex()
	{
		$model=new Review('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Review']))
			$model->attributes=$_GET['Review'];
		$this->render('index',array('model'=>$model));
		
	}
	protected function grid($data,$row,$dataColumn)
    {
        switch ($dataColumn->name)
        {
            case 'text':$return=substr($data->text,0,40);
                        break;
        }
        return $return;
    }


	public function loadModel($id)
	{
		$model=Review::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}


	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='country-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
