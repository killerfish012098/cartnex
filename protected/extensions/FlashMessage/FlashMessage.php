<?php
class FlashMessage extends CWidget {
	public $flashMessages;
	public function run() {
		$this->flashMessages = Yii::app()->user->getFlashes();
		//echo '<pre>';print_r($this->flashMessages);echo '</pre>';
		if ($this->flashMessages): 
		$this->render("flashmessage");   
		endif;
	}
}
?>
