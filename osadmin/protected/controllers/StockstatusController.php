<?php

class StockStatusController extends Controller
{
   
       public function actionCreate() {
	   
        $model['s'] = new StockStatus;
 
        if (Yii::app()->request->isPostRequest) 
            {
                    foreach(Language::getLanguages() as $language):
                        $model['s'] = new StockStatus;
                        $model['s']->attributes = $_POST['StockStatus'];
			$model['s']->id_stock_status=$id_stock_status;
                        $model['s']->id_language=$language->id_language;
                        $model['s']->name=$_POST['StockStatus']['name'];
                        $model['s']->save(false); 
			$id_stock_status=$model['s']->id_stock_status;
                   endforeach;
                   Yii::app()->user->setFlash('success',Yii::t('common','message_create_success'));
                   $this->redirect('index');
            }
        $this->render('create', array(
            'model' => $model,
        ));
    }
	
	
	  public function actionUpdate($id) 
    {
            $model = $this->loadModel($id);

            if (Yii::app()->request->isPostRequest) 
            {
                $model['s']->attributes = $_POST['StockStatus'];
                $model['s']->id_language = Yii::app()->session['language'];
                $model['s']->save();
                Yii::app()->user->setFlash('success',Yii::t('common','message_modify_success'));
                $this->redirect(base64_decode (Yii::app()->request->getParam('backurl')));     
            }
            $this->render('update', array('model' => $model,));
    }
	
        public function actionDelete() {//($id)

        $arrayRowId = is_array(Yii::app()->request->getParam('id')) ? Yii::app()->request->getParam('id') : array(
        Yii::app()->request->getParam('id'));
        if (sizeof($arrayRowId) > 0) {
		
	
            $criteria = new CDbCriteria;
            $criteria->addInCondition('id_stock_status', $arrayRowId);
            CActiveRecord::model('StockStatus')->deleteAll($criteria);
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
	
	public function loadModel($id)
	{
            $model['s']=StockStatus::model()->lang()->find(array("condition"=>"id_stock_status=".$id)); //validation
            return $model;
	}
	
	
	public function actionIndex()
	{
        $model=new StockStatus('search');
                
        $model->unsetAttributes();  // clear any default values
		if(isset($_GET['StockStatus']))
			$model->attributes=$_GET['StockStatus'];
                $this->render('index',array('model'=>$model,));
         }
}

