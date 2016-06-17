<?php
class DeleteAction extends CAction
{
	public $pk = 'id'; //db primary key
	public $redirectTo = 'index';
	public $modelClass;
	public $getId='id'; //param passed from view
	public function run()//($id)
	{
            //print_r($_REQUEST);
            //exit;
            $arrayRowId=  is_array(Yii::app()->request->getParam($this->getId))?Yii::app()->request->getParam($this->getId):array(Yii::app()->request->getParam($this->getId));
            if(sizeof($arrayRowId)>0)
            {
                $criteria=new CDbCriteria;
                $criteria->addInCondition($this->pk,$arrayRowId);
                if(CActiveRecord::model($this->modelClass)->deleteAll($criteria))
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
  	    // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if(!isset($_GET['ajax']))
		//$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
                $this->getController()->redirect(base64_decode (Yii::app()->request->getParam('backurl')));
	}
        
        /*function run()
	{
 		if(empty($_GET[$this->pk]))
			throw new CHttpException(404);
		
		$model = CActiveRecord::model($this->modelClass)->findByPk((int)$_GET[$this->pk]);
		if(!$model)
			throw new CHttpException(404);

		if($model->delete())
		{
			if(!Yii::app()->getRequest()->getIsAjaxRequest())
			//$this->getController()->redirect('index.php?r=zones/admin');
			$this->getController()->redirect(array($this->redirectTo));

		}else{
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
		}
	
	}*/
}
?>