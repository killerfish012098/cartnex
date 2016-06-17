<?php
class UpdateAction extends CAction
{
	public $pk = 'id';
	public $redirectTo = 'index';
	public $modelClass;
	public $render='update';
	public $formName;

	public function run($id) {
		//exit("inside");
		$model = CActiveRecord::model($this->modelClass)->findByPk((int)$_GET[$this->pk]);
		//$model = $this->loadModel($id, 'Zones');

		//$this->performAjaxValidation($model, 'zones-form'); 
		if (Yii::app()->getRequest()->getIsAjaxRequest() && (($this->formName === null) || ($_POST['ajax'] == $this->formName))) {
			echo GxActiveForm::validate($model);
			Yii::app()->end();
		}

		if (isset($_POST[$this->modelClass])) {
			$model->setAttributes($_POST[$this->modelClass]);

			if ($model->save()) {
				//$this->getController()->redirect(array('view', 'id' => $model->zone_id));
				$this->getController()->redirect(array($this->redirectTo));
			}
		}

		$this->getController()->render($this->render, array(
				'model' => $model,
				));
	}
}

?>