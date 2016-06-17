<?php
class AdminAction extends CAction{
	public $pk = 'id';
	public $render = 'index';
	public $modelClass;
	public $getForm;
	
	public function run() 
	{
		$model = new $this->modelClass('search');
		$model->unsetAttributes();

		if (isset($_GET[$this->getForm]))
			$model->setAttributes($_GET[$this->getForm]);

		$this->getController()->render($this->render, array(
			'model' => $model,
		));
	}
}
?>