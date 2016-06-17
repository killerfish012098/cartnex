<?php

class OrderController extends BaseController
{
		public $position;
	public $data;
	/**
	 * Declares class-based actions.
	 */
	private $data=array();
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	
	public function ActionOrder(){
		
	    if (file_exists(DIR_TEMPLATE.'/'.CONFIG_WEBSITE_TEMPLATE.'/order/order.php')) {
			$this->render("/".CONFIG_WEBSITE_TEMPLATE."/order/order",array('model'=>$model));
		}else{
			$this->render("/default/order/order",array('model'=>$model));
		}
	}
}