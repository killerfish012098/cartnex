<?php

class Flashmessages extends CComponent
{
	public function init()
	{

	}
	public function setFlash($statustype,$messagetype){
	   Yii::app()->user->setFlash($statustype, $messagetype);
	}
	public function getFlash(){
	foreach(Yii::app()->user->getFlashes() as $key => $message) {
      echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
    }
	}

	
}