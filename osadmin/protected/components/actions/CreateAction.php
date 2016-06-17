<?php
class CreateAction extends CAction{	
	public $redirectTo = 'index';
	public $modelClass;
	public $formName;
	public $render='create';
	
	public function run() {
            //echo Yii::app()->controller->id;
            //exit;
		$model = new $this->modelClass;
 
		//$this->getController()->performAjaxValidation($model, 'zones-form');$this->formName
		//$form='zones-form';
		if (Yii::app()->getRequest()->getIsAjaxRequest() && (($this->formName === null) || ($_POST['ajax'] == $this->formName))) {
			echo GxActiveForm::validate($model);
			Yii::app()->end();
		}

		if (isset($_POST[$this->modelClass])) {
			$model->setAttributes($_POST[$this->modelClass]);

			if ($model->save()) {
				if (Yii::app()->getRequest()->getIsAjaxRequest())
					Yii::app()->end();
				else
					//$this->getController()->redirect(array('view', 'id' => $model->zone_id));
				///$this->getController()->redirect(array($this->redirectTo));
                                    $this->getController()->redirect(array($this->redirectTo));
			}
		}

		$this->getController()->render($this->render, array( 'model' => $model));
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
			$this->getController()->redirect('index.php?r=zones/admin');

		}else{
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
		}
	
	}*/
	
}
?>