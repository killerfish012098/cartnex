<?php

class OrderStatusController extends Controller
{
   
       public function actionCreate() {
	   
        $model['o'] = new OrderStatus;
 	
        if (Yii::app()->request->isPostRequest)
            {
                    foreach(Language::getLanguages() as $language):
                        $model['o'] = new OrderStatus;
                        $model['o']->attributes = $_POST['OrderStatus'];
			$model['o']->id_order_status=$id_order_status;
                        $model['o']->id_language=$language->id_language;
                        $model['o']->name=$_POST['OrderStatus']['name'];
                        $model['o']->color=$_POST['OrderStatus']['color'];
                        $model['o']->id_email_template=$_POST['OrderStatus']['id_email_template'];
                        $model['o']->save(false);
                        $id_order_status=$model['o']->id_order_status;
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
		$model['o']->attributes = $_POST['OrderStatus'];
		$model['o']->id_language = Yii::app()->session['language'];
                $model['o']->save();
                Yii::app()->user->setFlash('success',Yii::t('common','message_modify_success'));
                $this->redirect(base64_decode(Yii::app()->request->getParam('backurl')));      
            }
            $this->render('update', array('model' => $model,));
    }
	
	    public function actionDelete() {//($id)
        $arrayRowId = is_array(Yii::app()->request->getParam('id')) ? Yii::app()->request->getParam('id') : array(
        Yii::app()->request->getParam('id'));
        if (sizeof($arrayRowId) > 0) {
            $criteria = new CDbCriteria;
            $criteria->addInCondition('id_order_status', $arrayRowId);
            CActiveRecord::model('OrderStatus')->deleteAll($criteria);
            Yii::app()->user->setFlash('success',Yii::t('common', 'message_delete_success'));
        } else {
            Yii::app()->user->setFlash('alert', Yii::t('common', 'message_checkboxValidation_alert'));
            Yii::app()->user->setFlash('error', Yii::t('common', 'message_delete_fail'));
        }
        if (!isset($_GET['ajax']))
                $this->redirect(base64_decode(Yii::app()->request->getParam('backurl')));
    }
	
	public function loadModel($id)
	{
            $model['o']=OrderStatus::model()->lang()->find(array("condition"=>"id_order_status=".$id)); //validation
            return $model;
	}
	
	
	public function actionIndex()
	{
        $model=new OrderStatus('search');
                
        $model->unsetAttributes();  // clear any default values
		if(isset($_GET['OrderStatus']))
			$model->attributes=$_GET['OrderStatus'];
                $this->render('index',array('model'=>$model,));
         }
         
        protected function grid($data,$row,$dataColumn)
        {
             switch ($dataColumn->name)
             {
                 case 'name':
                            $return='<span style="background-color:'.$data->color.';color:white" class="label color_field">'.$data->name.'</span>';
                            break;
             }
             return $return;
        }
}
