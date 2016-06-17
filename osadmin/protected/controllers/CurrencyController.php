<?php
class CurrencyController extends Controller
{
	public function actionCreate()
	{
		$model=new Currency;
		if (Yii::app()->request->isPostRequest)
		{
			$model->attributes=$_POST['Currency'];
			if($model->save())
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
			//echo '<pre>';
			//print_r($_POST['Currency']);
			$model->attributes=$_POST['Currency'];
			if($model->save())
				 Yii::app()->user->setFlash('success',Yii::t('common','message_modify_success'));
			//exit;
                    $this->redirect(base64_decode(Yii::app()->request->getParam('backurl')));
		}
		$this->render('update',array('model'=>$model));
	}

    public function actionDelete() {
       
        $arrayRowId = is_array(Yii::app()->request->getParam('id')) ? Yii::app()->request->getParam('id') : array(
        Yii::app()->request->getParam('id'));
        if (sizeof($arrayRowId) > 0) {
            $criteria = new CDbCriteria;
            $criteria->addInCondition('id_currency', $arrayRowId);
            CActiveRecord::model('Currency')->deleteAll($criteria);
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
		$model=new Currency('search');
		$model->unsetAttributes();
		if(isset($_GET['Currency']))
			$model->attributes=$_GET['Currency'];
		$this->render('index',array('model'=>$model));
	}


	public function loadModel($id)
	{
		$model=Currency::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}


	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='currency-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
